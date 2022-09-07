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

class ModuleBuilder_PackageError_View extends Vtiger_Index_View {

	
	function checkPermission(Vtiger_Request $request) {
		//Return true as WebUI.php is already checking for module permission
		return true;
	}
	/**
	 * Function to get process UI dispaly and Paramets for display the UI
	 */
	public function process(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering process(request array()) method....");
		$module = $request->getModule();
		$viewer = $this->getViewer($request);
		
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$log->debug("Exiting process(request array()) method....");
		$viewer->view('PackageError.tpl', $module );
	}
}