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

class ModuleBuilder_ClearCacheData_Action extends Settings_Vtiger_Index_Action 
{
	/**
	 * Class Constructor
	 */
    function __construct() 
	{
		global $log;
		$log->debug("Entering __construct() method....");
        $this->exposeMethod('clearData');
		$log->debug("Exiting __construct() method....");
    }
	
	/**
	 * Function to check permission for the User
	 */
	function checkPermission(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering __construct() method....");
		$log->debug("Exiting __construct() method....");
		return true;
	}
	
	/**
	 * Function to clear all module builder data stored in session
	 */
    public function clearData(Vtiger_Request $request) 
	{
		global $log;
		$log->debug("Entering clearData(request array()) method....");
		$_SESSION['tks_module_builder'] = array();
		$log->debug("Exiting clearData(request array()) method....");
		header("Location: index.php?module=".$request->getModule()."&view=MBindex&parent=Tools");
		exit();
    }
}