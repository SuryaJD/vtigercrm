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

class ModuleBuilder_MBindex_View extends Vtiger_Index_View {

        function __construct() 
        {
            global $log;
            $log->debug("Entering __construct() method....");
            $this->exposeMethod('editModule');
            $log->debug("Exiting __construct() method....");
        }

        public function editModule()
        {
            global $log, $adb;
            $log->debug("Entering editModule(request array()) method....");

            $module = $request->getModule();
            $viewer = $this->getViewer($request);

            $sql = "SELECT name, tabid FROM vtiger_tks_module Order By tabid";
            $res = $adb->pquery($sql,array());
            $row = $adb->num_rows($res);

            $module_name = array();
            $tabid = array();
            for($i=0; $i < $row; $i++){
                $module_info[$i]['module_name'] = $adb->query_result($res,$i,'name');
                $module_info[$i]['tab_id'] = $adb->query_result($res,$i,'tabid');
            }

            $viewer->assign('ModuleInfo', $module_info);
            $viewer->view('ModuleBuilderModuleList.tpl', $module );

            $log->debug("Exiting editModule(request array()) method....");
        }
	/**
	 * Function to pre process module ui diplay event for instializing default parameters
	 */
	public function preProcess(Vtiger_Request $request, $display = true) {

		global $log;
		$log->debug("Entering preProcess(request array()) method....");

		$flags  = ModuleBuilder_Module_Model::validate_pacakges();

		if($flags["zipflag"] == 1 && $flags["domflag"] == 1 )
		{
			header("Location: index.php?module=".$request->getModule()."&view=PackageError");
			exit();
		}


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
	 * Function to get preprcess TPL name
	 */
	protected function preProcessTplName(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering preProcessTplName(request array()) method....");
		$log->debug("Exiting preProcessTplName(request array()) method....");
		return 'ModuleBuilderViewPreProcess.tpl';
	}

	/**
	 * Function to get header CSS
	 */
	public function getHeaderCss(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering getHeaderCss(request array()) method....");

		$headerCssInstances = parent::getHeaderCss($request);

		$cssFileNames = array(
			'~/libraries/jquery/bootstrapswitch/css/bootstrap2/bootstrap-switch.min.css',
		);
		$cssInstances = $this->checkAndConvertCssStyles($cssFileNames);
		$headerCssInstances = array_merge($headerCssInstances, $cssInstances);

		$log->debug("Exiting getHeaderCss(request array()) method....");
		return $headerCssInstances;
	}

	/**
	 * Function to get Header JS
	 */
	public function getHeaderScripts(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering getHeaderScripts(request array()) method....");

		$headerScriptInstances = parent::getHeaderScripts($request);
		$jsFileNames = array(
			"modules.Settings.Vtiger.resources.Index",
			"modules.ModuleBuilder.resources.ModuleBuilderView",
			"libraries/jquery/posabsolute-jQuery-Validation-Engine/js/jquery.validationEngine.js",

		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		$log->debug("Exiting getHeaderScripts(request array()) method....");
		return $headerScriptInstances;
	}

	public function postProcess(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->view('ModuleBuilderViewPostProcess.tpl', $moduleName);

		parent::postProcess($request);
	}

	/**
	 * Function to get process UI dispaly and Paramets for display the UI
	 */

	public function process(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering process(request array()) method....");

                if($request->get('mode') == 'editModule')
                {
                    $this->editModule($request);
                }
                else {
                    if(!isset($_SESSION['tks_module_builder']))
                            $_SESSION['tks_module_builder'] = array();

                    $files = array();
                    $files = glob('test/vtlib/modules/*');
                    if(is_array($files) && !empty($files))
                    {
                            foreach($files as $file)
                            {
                                    if(is_file($file))
                                            unlink($file);
                            }
                    }

                    global $current_user;
                    $viewer = $this->getViewer($request);
                    $moduleModel = Settings_LayoutEditor_Module_Model::getInstanceByName('Accounts');
                    $fieldtypes = ModuleBuilder_Module_Model::getAddSupportedFieldTypes();
                    $currentUserModel = Users_Record_Model::getCurrentUserModel();

                    $module = $request->getModule();
                    $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
                    $viewer->assign('UNINSTALLURL', $this -> getUninstallUrl($module));
                    $flag1 = 0;
                    $flag2 = 0;
                    
                    if(!is_dir( 'test/vtlib/modules' ))
                    {

                            $viewer->assign('DIRCRATION', true);
                            $log->debug("Exiting process(request array()) method....");
                            $viewer->view('Error.tpl', $module );
                    }
                    elseif( $flag1 == 1 && $flag2 == 1)
                    {
                            $viewer->assign('PACKAGENAME', 'LBL_ZIPANDDOMPACKAGE');
                            $viewer->assign('PACKAGEERROR', true);
                            $log->debug("Exiting process(request array()) method....");

                            $viewer->view('Error.tpl', $module );
                    }
                    elseif($flag1 == 1)
                    {
                            $viewer->assign('PACKAGENAME', 'LBL_ZIPPACKAGE');
                            $viewer->assign('PACKAGEERROR', true);
                            $log->debug("Exiting process(request array()) method....");

                            $viewer->view('Error.tpl', $module );
                    }
                    elseif( $flag2 == 1 )
                    {
                            $viewer->assign('PACKAGENAME', 'LBL_DOMDOCUMENTPACKAGE');
                            $viewer->assign('PACKAGEERROR', true);
                            $log->debug("Exiting process(request array()) method....");

                            $viewer->view('Error.tpl', $module );
                    }
                    else
                    {
                            if($request->get('srcModule') != '' && $request->get('tabid') != '')
                            {
                                global $adb;
                                $edit_module = $request->get('srcModule');
                                $tab_id = $request->get('tabid');
                                $query = "SELECT *
                                            FROM vtiger_tks_module
                                            INNER JOIN vtiger_tks_blocks ON vtiger_tks_blocks.tabid = vtiger_tks_module.tabid
                                            WHERE vtiger_tks_module.name = ? and vtiger_tks_module.tabid = ?";

                                $result     = $adb->pquery($query,array($edit_module, $tab_id));
                                $row        = $adb->num_rows($result);

                                $modlabel   = $adb->query_result($result,0,'tablabel');
                                $parenttab  = $adb->query_result($result,0,'parent');

                                $blockinfo = array();
                                for($i=0; $i < $row; $i++){
                                    $blockinfo['blockno'][$i]    = $adb->query_result($result,$i,'sequence');
                                    $blockinfo['blocklabel'][$i] = $adb->query_result($result,$i,'blocklabel');
                                }

                                $viewer->assign('BLOCK_INFO', $blockinfo);
                                $viewer->assign('EDIT_MODULE', $edit_module);
                                $viewer->assign('MODULE_LABEL', $modlabel);
                                $viewer->assign('PARENTTABNAME', $parenttab);
                            }
                            $viewer->assign('SELECTED_MODULE_MODEL', $moduleModel);
                            $viewer->assign('CURRENT_USER', $currentUserModel);
                            $viewer->assign('TKS_PARENT_MODULE', $this -> getTabs() );
                            $viewer->assign('RELATED_LIST', $this -> modList() );
                            $viewer->assign('IS_SORTABLE', true );
                            $viewer->assign('IS_BLOCK_SORTABLE', true );
                            $viewer->assign('NOOFBLOCK', 0 );
                            $viewer->assign('CURRENT_USER_ID',$current_user->id);
                            $viewer->assign('ADD_SUPPORTED_FIELD_TYPES', $fieldtypes );
                            $viewer->assign('TOKEN', $this -> getToken(4) );
                            $viewer->assign('CLEARCACHEURL', $this -> getModuleCacheUrl($module));

                            $log->debug("Exiting process(request array()) method....");

                            $viewer->view('ModuleBuilderView.tpl', $module );
                    }
                }
	}

	/**
	 * Function to get default UI tabs or Headers
	 */

	public function getTabs() {

		global $log;
		$log->debug("Entering getTabs() method....");

		global $current_user, $adb;
		$query 		= "SELECT parenttab_label FROM vtiger_parenttab";
		$result   	= $adb->query($query);
		for($i=0 ; $i < $adb->num_rows($result) ; $i++)
		{
	 		if($adb->query_result($result,$i,'parenttab_label') == 'My Home Page' || $adb->query_result($result,$i,'parenttab_label') =='Settings' || $adb->query_result($result,$i,'parenttab_label') =='Analytics')
	 			continue;
	 		$parent[] = $adb->query_result($result,$i,'parenttab_label');
		}
		$log->debug("Exiting getTabs() method....");
		return $parent;
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

	/*
	 * Function to get the url for default view of the module
	 * @return <string> - url
	 */
	public function getUninstallUrl($module) {
		global $log;
		$log->debug("Entering getUninstallUrl($module) method....");
		$log->debug("Exiting getUninstallUrl($module) method....");
		return 'index.php?module='.$module.'&view=Uninstall&parent=Tools';

	}

	/*
	 * Function to get the url for unistalling the module
	 * @return <string> - url
	 */
	public function getModuleCacheUrl($module) {
		global $log;
		$log->debug("Entering getModuleCacheUrl($module) method....");
		$log->debug("Exiting getModuleCacheUrl($module) method....");
		return 'index.php?module='.$module.'&action=ClearCacheData&mode=clearData&parent=Tools';

	}

	/**
	 * Function to genrate random token for the current session.
	 */
	public function getToken($length)
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
	}

}