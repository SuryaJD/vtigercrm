<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModuleBuilder_ImportZip_View extends Vtiger_Index_View 
{
    /**
	 * Class Constructor
	 */
    function __construct() 
    {
        global $log;
        $log->debug("Entering __construct() method....");
        $log->debug("Exiting __construct() method....");
    }
    
    public function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $jsFileNames = array(
		"~/layouts/vlayout/modules/ModuleBuilder/resources/importZip.js"
	);

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
    
    /**
     * Function to check permission for the User
     */
    function checkPermission(Vtiger_Request $request) {
        global $log;
        $log->debug("Entering checkPermission(request attay()) method....");
        $log->debug("Exiting checkPermission(request attay()) method....");
        return true;
    }
    
    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer ($request);
        $moduleName = $request->getModule();
        $srcModule  = $request->get('srcModule');
	$zipname    = 'test/vtlib/modules/'. ucfirst( strtolower(  $srcModule ) ).'.zip';
        $importModuleDepVtVersion    = ModuleBuilder_ImportModule_Action::getDependentVtigerVersion();
        
        $viewer->assign("MODULEIMPORT_DEP_VTVERSION", $importModuleDepVtVersion);
        $viewer->assign('ModuleName', $moduleName);
        $viewer->assign('sourceModule', $srcModule);
        $viewer->assign('zipFile', $zipname);
        $viewer->view('importZip.tpl', $moduleName);
    }
}