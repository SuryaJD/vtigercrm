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

class ModuleBuilder_Module_Model extends Vtiger_Module_Model {

	/**
	 * Function to get the Default View Component Name
	 * @return string
	 */
	public function getDefaultViewName() {
		global $log;
		$log->debug("Entering getDefaultViewName() method....");
		$log->debug("Exiting getDefaultViewName() method....");
		return 'MBindex';
	}
	public function getSettingsActiveBlock($viewName) {
		$blocksList = array('OutgoingServerEdit' => array('block' => 'LBL_CONFIGURATION', 'menu' => 'LBL_MAIL_SERVER_SETTINGS'));
		return $blocksList[$viewName];
	}
	
	/*
	 * Function to get the url for default view of the module
	 * @return <string> - url
	 */
	public function getDefaultUrl() {
		global $log;
		$log->debug("Entering getDefaultUrl() method....");
		$log->debug("Exiting getDefaultUrl() method....");
		return 'index.php?module='.$this -> get( 'name' ).'&view='.$this -> getDefaultViewName().'&parent=Tools';
		
	}
	
	/**
	 * Function to get the default supported field types
	 */ 
	 public function getAddSupportedFieldTypes() {
	 	global $log;
		$log->debug("Entering getAddSupportedFieldTypes() method....");
		$log->debug("Exiting getAddSupportedFieldTypes() method....");
        return array(
            'Text','Decimal','Integer','Percent','Currency','Date','Email','Phone','Picklist',
            'URL','Checkbox','TextArea','MultiSelectCombo','Skype','Time','Relate'
        );
    }
	
	public function validate_pacakges()
	{	
		global $adb, $site_URL, $mod_strings, $currentModule;
		$zipflag = 0;
		$domflag = 0;
		$flags = array();
		
		if(!class_exists(ZipArchive))
			{
				 $zipflag = 1;
			}
		elseif(!class_exists(DOMDocument))
			{
				$domflag = 1;			
			}
			
		$flags["zipflag"] = $zipflag;
		$flags["domflag"] = $domflag;
		
		return $flags;	
	}
}