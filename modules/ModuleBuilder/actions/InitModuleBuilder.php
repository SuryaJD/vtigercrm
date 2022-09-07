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

class ModuleBuilder_InitModuleBuilder_Action extends Settings_Vtiger_Index_Action 
{
	/**
	 * Class Constructor
	 */
    function __construct() 
	{
		global $log;
		$log->debug("Entering __construct() method....");
        $this->exposeMethod('initMB');
		$this->exposeMethod('setSession');
		$log->debug("Exiting __construct() method....");
    }
	
	/**
	 * Function to check permission for the User
	 */
	function checkPermission(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering checkPermission(request array()) method....");
		$log->debug("Exiting checkPermission(request array()) method....");
		return true;
	}
	
	/**
	 * Function to check permission for the User
	 */
	function setSession(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering setSession(request array()) method....");
		$temp_array = array();
		$token = $request->get('token');
		$response = new Vtiger_Response();
		
		unset($_SESSION['tks_module_builder'][$token]['blocks']);
		unset($_SESSION['tks_module_builder'][$token]['fields']);
		$response->setResult(array('init' => true));
		
		$log->debug("Exiting setSession(request array()) method....");
		return true;
	}
	
	/**
	 * Function to initaliza Module Builder and clear old data
	 */
    public function initMB(Vtiger_Request $request) 
	{
		global $log;
		$log->debug("Entering initMB(request array()) method....");
		
		$temp_array = array();
		$token = $request->get('token');
		//$token = $request->get('token');
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule(false)));
			$response->emit();
			$log->debug("Exiting initMB(request array()) method.... INITIALIZAION SESSION ERROR");
			return;
		}
		$_SESSION['tks_module_builder']["$token"] = array();
		
		$temp_array['tks_modname'] 		= $request -> get('tks_modulename');
		$temp_array['tks_label'] 		= $request -> get('tks_modulelabel');
		$temp_array['tks_parent'] 		= $request -> get('tks_parent');
		
		$_SESSION['tks_module_builder']["$token"] = $temp_array;
		
		$response = new Vtiger_Response();
		try
		{
			$log->debug("initMB(request array()) method.... Init Done");
			$log->debug("Exiting initMB(request array()) method....");
			$response->setResult(array('init' => true));
			header('Location: index.php?module=ModuleBuilder&view=Index&parent=Tools&app=PROJECT&token='.$token);

		}
		catch(Exception $e) 
		{
			$log->debug("initMB(request array()) method.... ERROR OCCURED");
			$response->setError($e->getCode(),$e->getMessage());
		}	
		$log->debug("Exiting initMB(request array()) method....");
		$response->emit();
    }
}