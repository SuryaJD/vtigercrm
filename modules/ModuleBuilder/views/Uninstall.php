<?php
/***********************************************************************************************
** The contents of this file are subject to the Vtiger Module-Builder License Version 1.3
 * ( "License" ); You may not use this file except in compliance with the License
 * The Original Code is:  Technokrafts Labs Pvt Ltd
 * The Initial Developer of the Original Code is Technokrafts Labs Pvt Ltd.
 * Portions created by Technokrafts Labs Pvt Ltd are Copyright ( C ) Technokrafts Labs Pvt Ltd.
 * All Rights Reserved.
**
*************************************************************************************************/

class ModuleBuilder_Uninstall_View extends Vtiger_Index_View {

	
	function checkPermission(Vtiger_Request $request) {
		//Return true as WebUI.php is already checking for module permission
		return true;
	}
	/**
	 * Function to pre process module ui diplay event for instializing default parameters
	 */
	public function preProcess(Vtiger_Request $request, $display = true) {
		global $log;
		$log->debug("Entering preProcess(request array()) method....");

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);
		parent::preProcess($request, false);
		$viewer->assign('MODULE_NAME', $request->getModule());
		$viewer->assign('PARENT_MODULE', $request->get('parent'));
		$viewer->assign('PAGETITLE', $this->getPageTitle($request));
		$viewer->assign('SCRIPTS',$this->getHeaderScripts($request));
		$viewer->assign('STYLES',$this->getHeaderCss($request));
		$viewer->assign('SKIN_PATH', Vtiger_Theme::getCurrentUserThemePath());
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('LANGUAGE_STRINGS', Vtiger_Language_Handler::export($request->getModule(), 'jsLanguageStrings'));
		$viewer->assign('LANGUAGE', $currentUser->get('language'));

		$log->debug("Exiting preProcess(request array()) method....");
		if($display) {
			$this->preProcessDisplay($request);
		}
	}
	
	/**
	 * Function to get Header JS
	 */
	public function getHeaderScripts(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering getHeaderScripts(request array()) method....");

		$headerScriptInstances = parent::getHeaderScripts($request);
		$jsFileNames = array(
			"modules.ModuleBuilder.resources.Uninstall",
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		$log->debug("Exiting getHeaderScripts(request array()) method....");
		return $headerScriptInstances;
	}
	
	/**
	 * Function to get preprcess TPL name
	 */
	protected function preProcessTplName(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering preProcessTplName(request array()) method....");
		$log->debug("Exiting preProcessTplName(request array()) method....");
		return 'UninstallPreProcess.tpl';
	}

	public function postProcess(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('UninstallPostProcess.tpl', $moduleName);

		parent::postProcess($request);
	}

	/**
	 * Function to get process UI dispaly and Paramets for display the UI
	 */
	public function process(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering process(request array()) method....");
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		$MBModuleModel = Vtiger_Module_Model::getInstance($module);	
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('CANCEL_URL', $MBModuleModel->getDefaultUrl());
		
		$dir = 'test/vtlib/modules';
		if ( !file_exists( $dir ) and !is_dir( $dir ) ) 
		{
			if( @mkdir( $dir ) != 1 )
			{
				$log->debug("Exiting process(request array()) method....");
				$viewer->assign('DIRCRATION', true);
				$viewer->view('Error.tpl', $module );
				exit();
			}         
		}
		
		if($request -> get('step2') == 'step2')
		{
			$this->deleteModuleBuilder();
		}
		
		$viewer->view('Uninstall.tpl', $module );
		$log->debug("Exiting process(request array()) method....");
	}
	
	/**
	 * Function to get DeleteModule
	 */
	private function deleteModuleBuilder()
	{
		global $log;
		$log->debug("Entering deleteModuleBuilder() method....");

		$files = array();
		
		$files = glob('test/vtlib/modules/*');

		include_once('vtlib/Vtiger/Module.php');
		$module = Vtiger_Module::getInstance('ModuleBuilder');
		if($module)
		{
			$log->debug("Delete Module from Database Starts");
			// Delete from system
			$module->delete();
			global $adb;
			$sql = "DROP TABLE IF EXISTS vtiger_tks_blocks";
			$tks_res = $adb -> pquery( $sql, array() );
			$sql = "DROP TABLE IF EXISTS vtiger_tks_field";
			$tks_res = $adb -> pquery( $sql, array() );
			$sql = "DROP TABLE IF EXISTS vtiger_tks_fieldmodulerel";
			$tks_res = $adb -> pquery( $sql, array() );
			$sql = "DROP TABLE IF EXISTS vtiger_tks_module";
			$tks_res = $adb -> pquery( $sql, array() );
			$sql = "DROP TABLE IF EXISTS vtiger_tks_relatedlists";
			$tks_res = $adb -> pquery( $sql, array() );
			
			$log->debug("Delete Module from Database End");
		}

		@copy( 'modules/ModuleBuilder/utils/uninstall.php','test/vtlib/modules/uninstall.php');
		$log->debug("Exiting deleteModuleBuilder() method....");
		header ('Location: test/vtlib/modules/uninstall.php');
		exit();
	}
}