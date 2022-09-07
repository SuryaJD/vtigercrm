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

class ModuleBuilder {	
	
	/**
	* Invoked when special actions are performed on the module.
	* @param String Module name
	* @param String Event Type
	*/
	function vtlib_handler($moduleName, $eventType) {
		global $adb;
 		if($eventType == 'module.postinstall') {
			// TODO Handle actions after this module is installed.
			ModuleBuilder::tks_makeDir();
			ModuleBuilder::tks_copyImg();
			
		} else if($eventType == 'module.disabled') {
			// TODO Handle actions before this module is being uninstalled.
		} else if($eventType == 'module.preuninstall') {
			// TODO Handle actions when this module is about to be deleted.
		} else if($eventType == 'module.preupdate') {
			// TODO Handle actions before this module is updated.
		} else if($eventType == 'module.postupdate') {
			// TODO Handle actions after this module is updated.
			ModuleBuilder::tks_makeDir();
			ModuleBuilder::tks_copyImg();
		}
 	}
	
	/**
	* Check if modules folder exsist in test/vtlib folder else create module folder
	*/
	function tks_makeDir()
	{
		global $log;
		$log->debug("Entering tks_makeDir() method ...");
		$dir = 'test/vtlib/modules';
		if ( !file_exists( $dir ) and !is_dir( $dir ) ) 
		{
			@mkdir( $dir );    
		}
		ModuleBuilder::tks_cleanDir();
		$log->debug("Exiting tks_makeDir() method ...");
	}
	
	/**
	*copy the Module Builder Logo to the vtiger Default Images
	*/
	function tks_copyImg()
	{
		global $log;
		$log->debug("Entering tks_copyImg() method ...");
		@copy( 'modules/ModuleBuilder/images/ModuleBuilder.png','layouts/vlayout/skins/images/ModuleBuilder.png');
		$log->debug("Exiting tks_copyImg() method ...");
	}
	
	/**
	*clean the modules directory if any data
	*/
	function tks_cleanDir()
	{
		global $log;
		$log->debug("Entering tks_cleanDir() method ...");
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
		$log->debug("Exiting tks_cleanDir() method ...");
	}
}
?>