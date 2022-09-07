<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class ModuleBuilder_Index_View extends Settings_Vtiger_Index_View {
function __construct() {
		parent::__construct();
		$this->exposeMethod('showFieldLayout');
		$this->exposeMethod('showRelatedListLayout');
		$this->exposeMethod('showFieldEdit');
	}
	
	
	function checkPermission(Vtiger_Request $request) {
		//Return true as WebUI.php is already checking for module permission
		return true;
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->getMode();
		if($this->isMethodExposed($mode)) {
			$this->invokeExposedMethod($mode, $request);
		}else {
			//by default show field layout
			$this->showFieldLayout($request);
		}
	}
	

	public function showFieldLayout(Vtiger_Request $request) {
	
		$sourceModule = $request->get('sourceModule');
		$supportedModulesList = Settings_LayoutEditor_Module_Model::getSupportedModules();
		$supportedModulesList = array_flip($supportedModulesList);
		ksort($supportedModulesList);

		if(empty($sourceModule)) {
			//To get the first element
			$sourceModule = reset($supportedModulesList);
		}
		$moduleModel = Settings_LayoutEditor_Module_Model::getInstanceByName($sourceModule);
		$fieldModels = $moduleModel->getFields();
		$blockModels = $moduleModel->getBlocks();

		$blockIdFieldMap = array();
		$inactiveFields = array();
		$headerFieldsCount = 0;
		$headerFieldsMeta = array();
		foreach ($fieldModels as $fieldModel) {
			$blockIdFieldMap[$fieldModel->getBlockId()][$fieldModel->getName()] = $fieldModel;
			if(!$fieldModel->isActiveField()) {
				$inactiveFields[$fieldModel->getBlockId()][$fieldModel->getId()] = vtranslate($fieldModel->get('label'), $sourceModule);
			}
			if ($fieldModel->isHeaderField()) {
				$headerFieldsCount++;
			}
			$headerFieldsMeta[$fieldModel->getId()] = $fieldModel->isHeaderField() ? 1 : 0;
		}

		foreach($blockModels as $blockLabel => $blockModel) {
			$fieldModelList = $blockIdFieldMap[$blockModel->get('id')];
			$blockModel->setFields($fieldModelList);
		}

		$cleanFieldModel = Settings_LayoutEditor_Field_Model::getCleanInstance();
		$cleanFieldModel->setModule($moduleModel);
		$tks_module = $_SESSION['tks_module_builder'][$_REQUEST['token']]['tks_modname'];
		
		$blocks = $_SESSION['tks_module_builder'][$_REQUEST['token']]['blocks'];
		
		$qualifiedModule = $request->getModule(false);
		$viewer = $this->getViewer($request);
		$viewer->assign('CLEAN_FIELD_MODEL', $cleanFieldModel);
		$viewer->assign('REQUEST_INSTANCE', $request);
		$viewer->assign('SELECTED_MODULE_NAME',$tks_module);
		$viewer->assign('SELECTED_MODULE_MODEL', $moduleModel);
		$viewer->assign('BLOCKS',$blockModels);
		$viewer->assign('SUPPORTED_MODULES',$supportedModulesList);
		$viewer->assign('ADD_SUPPORTED_FIELD_TYPES', $moduleModel->getAddSupportedFieldTypes());
		$viewer->assign('FIELD_TYPE_INFO', $moduleModel->getAddFieldTypeInfo());
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('QUALIFIED_MODULE', 'ModuleBuilder');
		$viewer->assign('IN_ACTIVE_FIELDS', $inactiveFields);
		$viewer->assign('HEADER_FIELDS_COUNT', $headerFieldsCount);
		$viewer->assign('HEADER_FIELDS_META', $headerFieldsMeta);
		//$viewer->assign('TOKEN', $this -> getToken(4));
		$viewer->assign('TKSMODULE', $tks_module);
		$viewer->assign('LANGUAGE_STRINGS', Vtiger_Language_Handler::export($request->getModule(), 'jsLanguageStrings'));
		
	

		$cleanFieldModel = Settings_LayoutEditor_Field_Model::getCleanInstance();
		$cleanFieldModel->setModule($moduleModel);
		$sourceModuleModel = Vtiger_Module_Model::getInstance($sourceModule);
		$this->setModuleInfo($request, $sourceModuleModel, $cleanFieldModel);
		$viewer->assign('UNINSTALLURL', ModuleBuilder_MBindex_View::getUninstallUrl($_REQUEST['module']));
		$viewer->view('Index.tpl',$qualifiedModule);
	}

	public function showRelatedListLayout(Vtiger_Request $request) {

		$sourceModule = $_SESSION['tks_module_builder'][$_REQUEST['token']]['tks_modname'];
		$supportedModulesList = Settings_LayoutEditor_Module_Model::getSupportedModules();

		if(empty($sourceModule)) {
			//To get the first element
			$moduleInstance = reset($supportedModulesList);
			$sourceModule = $moduleInstance->getName();
		}
		$moduleModel = Settings_LayoutEditor_Module_Model::getInstanceByName($sourceModule);
		$relatedModuleModels = $moduleModel->getRelations();

		$hiddenRelationTabExists = false;
		foreach ($relatedModuleModels as $relationModel) {
			if (!$relationModel->isActive()) {
				// to show select hidden element only if inactive tab exists 
				$hiddenRelationTabExists = true;
				break;
			}
		}

		$relationFields = array();
		$referenceFields = $moduleModel->getFieldsByType('reference');

		foreach ($referenceFields as $fieldModel) {
			if ($fieldModel->get('uitype') == '52' || !$fieldModel->isActiveField()) {
				continue;
			}
			$relationType = $moduleModel->getRelationTypeFromRelationField($fieldModel);
			$fieldModel->set('_relationType', $relationType);
			$relationFields[$fieldModel->getName()] = $fieldModel;
		}

		$qualifiedModule = $request->getModule(false);
		$viewer = $this->getViewer($request);

		
		$viewer->assign('SELECTED_MODULE_NAME',$sourceModule);
		$viewer->assign('RELATED_MODULES', $relatedModuleModels);
		$viewer->assign('RELATION_FIELDS', $relationFields);
		$viewer->assign('HIDDEN_TAB_EXISTS', $hiddenRelationTabExists);
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('QUALIFIED_MODULE', 'ModuleBuilder');

		$viewer->assign('RELATED_LIST', ModuleBuilder_Index_View::modList());
		$viewer->assign('RELATED_LIST_COUNT', count(ModuleBuilder_Index_View::modList()));
		 $viewer->view('RelatedList.tpl',  'ModuleBuilder');
	}
	
	/**
	 * Function to get List of all module installed and Active on current CRM instance
	 */
	public function modList() {

		global $log;
		$log->debug("Entering modList() method....");

		global $current_user, $adb;
		$mod_sql = "SELECT tablabel, name FROM vtiger_tab
					WHERE presence=0 	AND ownedby=0
					AND isentitytype=1 	AND parent!=''
					AND tabid NOT IN (36,37,38,41,45,46,50,9,34)
					AND name != 'SMSNotifier' ";
		$mod_res   = $adb->query($mod_sql,array());
		while($row = $adb->fetch_row($mod_res))
		{
			$related_list[$row['name']] = $row['tablabel'];
		}
		$log->debug("Exiting modList() method....");
		return $related_list;
	}

	public function showFieldEdit(Vtiger_Request $request) {
		$sourceModule = $request->get('sourceModule');
		$fieldId = $request->get('fieldid');
		$fieldInstance = Settings_LayoutEditor_Field_Model::getInstance($fieldId);
		$moduleModel = Settings_LayoutEditor_Module_Model::getInstanceByName($sourceModule);

		$fieldModels = $moduleModel->getFields();
		$headerFieldsCount = 0;
		foreach ($fieldModels as $fieldModel) {
			if ($fieldModel->isHeaderField()) {
				$headerFieldsCount++;
			}
		}
		
		$token = $request->get('token');
        $fieldId = $request->get( 'fieldid' );
		
		$blockId = $request->get( 'blockid' );
        $module = $request->get( 'sourceModule' );

		$fieldInfo = array();
		/*$temp_array['tks_modname'] 				=	$module;
		$temp_array['id'] 						=	$fieldId;
		$temp_array['blockid'] 					=	$blockId;
		$temp_array['mandatory'] 				=	$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['mandatory'];
		$temp_array['quickcreate'] 				=   $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['quickcreate'];
		$temp_array['masseditable'] 			=   $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['masseditable'];
		$temp_array['tkslabel'] 				=	$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tkslabel'];*/

		
		$fieldInfo['id'] 						=	$fieldId;
		$fieldInfo['mandatory'] 				= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['mandatory'];
		$fieldInfo['presence'] 					= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['presence'];
		$fieldInfo['quickcreate'] 				= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['quickcreate'];
		$fieldInfo['SummaryField'] 				= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['SummaryField'];
		$fieldInfo['headerfield'] 				= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['headerfield'];
		$fieldInfo['masseditable'] 				= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['masseditable'];
		$fieldInfo['defaultvalue'] 				= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['defaultvalue'];
		$fieldInfo['type'] 						= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['type'];
		$fieldInfo['name'] 						= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['name'];
		$fieldInfo['label'] 					= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tkslabel'];
		$fieldInfo['tksfieldtype'] 				= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tksfieldtype'];
		$fieldInfo['picklistvalues'] 				= $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['picklistvalues'];

		
	

		/*$qualifiedModule = $request->getModule(false);
		$viewer = $this->getViewer($request);
				
		$viewer->assign('FIELD_INFO', $fieldInfo);
		$viewer->assign('SELECTED_MODULE_NAME', $sourceModule);
		$viewer->assign('ADD_SUPPORTED_FIELD_TYPES', $moduleModel->getAddSupportedFieldTypes());
		$viewer->assign('FIELD_TYPE_INFO', $moduleModel->getAddFieldTypeInfo());
		$viewer->assign('FIELD_MODEL', $fieldInstance);
		$viewer->assign('IS_FIELD_EDIT_MODE', true);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModule);
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('HEADER_FIELDS_COUNT', $headerFieldsCount);
		$viewer->assign('IS_NAME_FIELD', $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tkslabel']);
		$viewer->view('FieldCreate.tpl', 'ModuleBuilder');
		$viewer->view('FieldEdit.tpl', 'ModuleBuilder');*/
		$response = new Vtiger_Response();
		$response->setResult($fieldInfo);
		$response->emit();

		/*$cleanFieldModel = Settings_LayoutEditor_Field_Model::getCleanInstance();
		$cleanFieldModel->setModule($moduleModel);
		$sourceModuleModel = Vtiger_Module_Model::getInstance($sourceModule);
		$this->setModuleInfo($request, $sourceModuleModel, $cleanFieldModel);
		*/
		
		
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$jsFileNames = array(
			'~libraries/garand-sticky/jquery.sticky.js',
			'~/libraries/jquery/bootstrapswitch/js/bootstrap-switch.min.js',
			'~/layouts/v7/modules/ModuleBuilder/resources/LayoutEditor.js',
			'~/layouts/v7/modules/ModuleBuilder/resources/ModuleBuilderView.js',
		);
		
		$jsScriptInstances 		= $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances 	= array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	/**
	 * Setting module related Information to $viewer (for Vtiger7)
	 * @param type $request
	 * @param type $moduleModel
	 */
	public function setModuleInfo($request, $moduleModel, $cleanFieldModel = false) {
		$fieldsInfo = array();
		$basicLinks = array();
		$viewer = $this->getViewer($request);

		if (method_exists($moduleModel, 'getFields')) {
			$moduleFields = $moduleModel->getFields();
			foreach ($moduleFields as $fieldName => $fieldModel) {
				$fieldsInfo[$fieldName] = $fieldModel->getFieldInfo();
			}

			//To set the clean field meta for new field creation
			if ($cleanFieldModel) {
				$newfieldsInfo['newfieldinfo'] = $cleanFieldModel->getFieldInfo();
				$viewer->assign('NEW_FIELDS_INFO', json_encode($newfieldsInfo));
			}

			$viewer->assign('FIELDS_INFO', json_encode($fieldsInfo));
		}

		if (method_exists($moduleModel, 'getModuleBasicLinks')) {
			$moduleBasicLinks = $moduleModel->getModuleBasicLinks();
			foreach ($moduleBasicLinks as $basicLink) {
				$basicLinks[] = Vtiger_Link_Model::getInstanceFromValues($basicLink);
			}
			$viewer->assign('MODULE_BASIC_ACTIONS', $basicLinks);
		}
	}

	public function getHeaderCss(Vtiger_Request $request) {
		$headerCssInstances = parent::getHeaderCss($request);
		$cssFileNames = array(
			'~/libraries/jquery/bootstrapswitch/css/bootstrap2/bootstrap-switch.min.css',
		);
		$cssInstances 			= $this->checkAndConvertCssStyles($cssFileNames);
		$headerCssInstances 	= array_merge($headerCssInstances, $cssInstances);
		return $headerCssInstances;
	}
	
	/**
	 * Function to genrate random token for the current session.
	 */
	/*public function getToken($length)
	{
		global $log;
		$log->debug("Entering getToken($length) method....");

		$str="";
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$size = strlen( $chars );

		for( $i = 0; $i < $length; $i++ )
		{
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
		
		$log->debug("Exiting getToken($length) method....");

		return $str;
	}*/
}
