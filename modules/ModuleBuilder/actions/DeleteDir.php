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

class ModuleBuilder_DeleteDir_Action extends Settings_Vtiger_Index_Action 
{
	/**
	 * Class Constructor
	 */
    function __construct() 
	{
		global $log;
		$log->debug("Entering __construct() method....");
        $this->exposeMethod( 'deletefolder' );
        $this->exposeMethod( 'deletezip' );
		$this->exposeMethod( 'checkZip' );
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
	 * Function to delete the folder after the zip is been created.
	 */
    public function deletefolder( Vtiger_Request $request ) 
	{
		global $log;
		$log->debug("Entering deletefolder(request array()) method....");

		$moduleName = ucfirst( strtolower( $request -> get( 'srcModule' ) ) );
		$directory = 'test/vtlib/modules/'.$moduleName.'/';
		$response = new Vtiger_Response();
		try
		{
			$this->delete_directory( $directory );
			$log->debug("deletefolder(request array()) method.... Folder Deleted");
			$response->setResult( array( 'success'=>true, 'deleted' => 'true' ) );							
		}
		catch( Exception $e ) 
		{
			$log->debug("deletefolder(request array()) method.... Error occured at Folder Deletion");
			$response->setError( $e->getCode(), $e->getMessage() );
		}
		$log->debug("Exiting deletefolder(request array()) method....");
		$response->emit();
    }
	
	/**
	 * Function to delete each field and directory in the folder recursively
	 */
	public function delete_directory( $dir )
	{
		global $log;
		$log->debug("Entering delete_directory($dir) method....");
		
		if ( $handle = @opendir( $dir ) )
		{
			$array = array();
			while ( false !== ( $file = @readdir( $handle ) ) ) 
			{
				if ( $file != "." && $file != ".." ) 
				{
					if( @is_dir( $dir.$file ) )
					{
						if( ! @rmdir( $dir.$file ) ) // Empty directory? Remove it
						{
							$this->delete_directory( $dir.$file.'/' ); // Not empty? Delete the files inside it
						}
					}
					else
					{
						@unlink( $dir.$file );
					}
				}
			}
			@closedir( $handle );
			@rmdir( $dir );
		}
		$log->debug("Exiting delete_directory($dir) method....");
	}
	
	/**
	 * Function to delete module zip after user downloaded the zip
	 */
	public function deletezip( Vtiger_Request $request ) 
	{
		global $log;
		$log->debug("Entering deletezip(request array()) method....");
		
		$moduleName = $request->get( 'srcModule' );
		$directory = 'test/vtlib/modules/';
		$response = new Vtiger_Response();
		try
		{
			@unlink( $directory.$moduleName.'.zip' );
			$log->debug("deletezip(request array()) method.... ZIP DELETED");
			$response->setResult( array( 'success'=>true, 'deleted' => 'true' ) );					
		}
		catch( Exception $e ) 
		{
			$log->debug("deletezip(request array()) method.... ERROR OCCURED ON ZIP DELETION");
			$response->setError( $e->getCode(), $e->getMessage() );
		}
		$log->debug("Exiting deletezip(request array()) method....");
		$response->emit();
    }
	
	/**
	 * Function to check if zip exsist on given path
	 */
	public function checkZip( Vtiger_Request $request ) 
	{
		global $log;
		$log->debug("Entering checkZip(request array()) method....");

		$moduleName = ucfirst( strtolower( $request->get( 'srcModule' ) ) );
		$directory = 'test/vtlib/modules/';
		$response = new Vtiger_Response();
		try
		{
			$log->debug("checkZip(request array()) method.... ZIP EXIT true / false ");
			if( file_exists( $directory.$moduleName.'.zip' ) )
				$response->setResult( array( 'success'=>true, 'exist' => 'true' ) );
			else
				$response->setResult( array( 'success'=>true, 'exist' => 'false' ) );						
		}
		catch( Exception $e ) 
		{
			$log->debug("checkZip(request array()) method.... ERROR OCCURED ON ZIP CHECKING");
			$response->setError( $e->getCode(), $e->getMessage() );
		}
		$log->debug("Exiting checkZip(request array()) method....");
		$response->emit();
    }
}