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

class ModuleBuilder_DownloadZip_Action extends Settings_Vtiger_Index_Action 
{
	/**
	 * Class Constructor
	 */
    function __construct() 
	{
		global $log;
		$log->debug("Entering __construct() method....");
                $this->exposeMethod('downloadModuleZip');
		$log->debug("Exiting __construct() method....");
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
	
	/**
	 * Function to download the module zip
	 */
    public function downloadModuleZip(Vtiger_Request $request) 
	{
		global $log;
		$log->debug("Entering downloadModuleZip(request attay()) method....");
		
		global $site_URL;
		$moduleName = $request->get('srcModule');
		$zipname 		 = 'test/vtlib/modules/'. ucfirst( strtolower(  $moduleName ) ).'.zip';
		
		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: application/zip' );
		header( 'Content-Disposition: attachment; filename='.basename( $zipname ) );
		header( 'Content-Transfer-Encoding: binary' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Pragma: public');
		header( 'Content-Length: ' . filesize( $zipname ) );	
		ob_clean();	
		flush();
		readfile( $zipname ); 
		@unlink( $zipname );
		$log->debug("Exiting downloadModuleZip(request attay()) method....");
		exit();	
    }
}