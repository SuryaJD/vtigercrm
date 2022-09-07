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

class ModuleBuilder_Block_Action extends Settings_Vtiger_Index_Action  
{

	
	function checkPermission(Vtiger_Request $request) {
		//Return true as WebUI.php is already checking for module permission
		return true;
	}
	
	function __construct() {
		parent::__construct();
		$this->exposeMethod('saveBlock');
		$this->exposeMethod('updateSequenceNumber');
		$this->exposeMethod('delete');
	}


  	/**
	 * Class Constructor
	 */
   /*function process(Vtiger_Request $request) {
		$this->saveBlock($request);
		$this->updateSequenceNumber();
        $this->delete();
	}
*/

	/**
	 * Function to check if filed exsist in the block before deletion
	 */
	private function checkFieldsExists($token,$blockid)
	{
		global $log;
		$log->debug("Entering checkFieldsExists($token,$blockid) method....");
		if($_SESSION['tks_module_builder'][$token]['blocks'][$blockid]['fieldCount'] > 0)
		{
			$log->debug("Exiting checkFieldsExists() method.... Duplicate Entry Exist");
				return true;
		}
		$log->debug("Exiting checkFieldsExists() method.... Duplicate Entry Not Exist");
		return false;
	}

	/**
	 * Function to save block
	 */
    public function saveBlock(Vtiger_Request $request) 
	{
		global $log;
		$log->debug("Entering saveBlock(request array()) method....");
		$token = $request->get('token');
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule(false)));
			$response->emit();
			$log->debug("Exiting saveBlock(request array()) method.... INITIALIZATION SESSION ERROR");
			return;
		}
		$temp_array = array();
		$key = 0; 	
		$isDuplicate = $this -> checkDuplicate($request->get('label'),$token);
		//$isDuplicate ='';
		
		

		$response = new Vtiger_Response();
		if (!$isDuplicate) 
		{
		
			try
			{
				
			
				if(empty($_SESSION['tks_module_builder'][$token]))
				{
					$temp_array['tks_modname'] 	= $request -> get('tks_mod');
					$temp_array['tks_label'] 	= $request -> get('tks_label');
					$temp_array['tks_parent'] 	= $request -> get('tks_parent');
					$_SESSION['tks_module_builder'][$token] = $temp_array;
				}
				$temp_array = array();
	
				if(is_array($_SESSION['tks_module_builder'][$token]['blocks']))
				{
					$end_val =  end($_SESSION['tks_module_builder'][$token]['blocks']);
				}	
				else
				{
					$end_val = array();
				}
				
				if(!empty($end_val) )
				{
					$k	 = $end_val['block_id'] + 1;	
				}
				else
				{
					$k = 1;
				}
				$temp_array	= array( 'name' => $request -> get('label'), 'block_id' => $k, 'deleted'	=> 'false');
				$_SESSION['tks_module_builder'][$token]['blocks'][$k] = $temp_array;
				
				$responseInfo = array('id'=>$k,'label'=>$request -> get('label'),
									  'sequenceList' => array_keys($_SESSION['tks_module_builder'][$token]['blocks']),
									  'beforeBlockId'=> $request -> get('beforeBlockId'));
				$response->setResult($responseInfo);
			} 
			catch(Exception $e) 
			{
				$log->debug("saveBlock() method.... ERROR OCCURED");
				$response->setError($e->getCode(),$e->getMessage());
			}
		} 
		else 
		{
			$response->setError('502', vtranslate('LBL_DUPLICATES_EXIST', $request->getModule(false)));
			$log->debug("saveBlock() method.... ERROR OCCURED");
		}
		
		$log->debug("Exiting saveBlock() method....");
		$response->emit();
   }
   
   /**
	 * Function to check duplicate block for current module
	 */
	public function checkDuplicate($req,$token) 
	{
		
		global $log;
		$log->debug("Entering checkDuplicate($req,$token) method....");
		if(isset($_SESSION['tks_module_builder'][$token]['blocks']))
		{
			
			foreach( $_SESSION['tks_module_builder'][$token]['blocks'] as $key => $value )
			{
				
				if( strcasecmp($req, $value['name']) == 0 && $value['deleted'] == 'false')
				{
					$log->debug("Exiting checkDuplicate() method.... Duplicate Entry Exisit");
					return true;
				}
			}
		}
		$log->debug("Exiting checkDuplicate() method.... Duplicate Entry Not Exist");
		return false;
	}
	
	/**
	* Function to update block sequence number
	*/  
   public function updateSequenceNumber(Vtiger_Request $request) 
   {
   		global $log;
		$log->debug("Entering updateSequenceNumber( request array()) method....");
   		$token = $request->get('token');
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule(false)));
			$response->emit();
			$log->debug("Exiting updateSequenceNumber(request array()) method.... INITIALIZATION SESSION ERROR");
			return;
		}
        $response = new Vtiger_Response();
        try
		{
            $sequenceList = $request->get('sequence');
			foreach($sequenceList as $key => $value)
			{
				$mblocks 	= $session['tks_module_builder']['blocks'][$value - 1];
				if($mblocks['deleted'] == 'true')
				{
					continue;
				}
						
				if($key != $value)
				{	
					unset($session['tks_module_builder']['blocks'][$value - 1]); 
					$session['tks_module_builder']['blocks'] = array_values($session['tks_module_builder']['blocks']);
					array_splice( $session['tks_module_builder']['blocks'], $key-1, 0, array($mblocks) );
				}	
			}	
            $response->setResult(array('success'=>true));
        }
		catch(Exception $e) 
		{
            $response->setError($e->getCode(),$e->getMessage());
			$log->debug(" updateSequenceNumber() method.... ERROR OCCURED");
        }
		$log->debug("Exiting updateSequenceNumber() method....");
        $response->emit();
    }
	
	
	/**
	 * Function to delete block
	 */ 
    public function delete(Vtiger_Request $request)
	{

		global $log;
		$log->debug("Entering delete( request array ) method....");
		$token = $request->get('token');
				
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule()));
			$response->emit();
			$log->debug("Exiting saveBlock(request array()) method.... INITIALIZATION SESSION ERROR");
			return;
		}
        $response = new Vtiger_Response();
        $blockId = $request->get('blockid');
		
		$fieldarr = $_SESSION[ 'tks_module_builder' ][$token][ 'blocks' ][ $blockId ][ 'fields' ];
		
		
        $checkIfFieldsExists = $this->checkFieldsExists($token , $blockId);
		
		
        if($checkIfFieldsExists) 
		{
            $response->setError('502', vtranslate('LBL_FIELD_EXISIT_FOR_BLOCK', $request->getModule()));
            $response->emit();
			$log->debug("Exiting delete() method.... FIELD EXSIST IN BLOCK");
            return;
        }
        try
		{

		   if($blockId != '')
		   {
		   		//$blockId = $blockId - 1;
				$_SESSION['tks_module_builder'][$token]['blocks'][ $blockId ]['deleted'] = 'true';
				$response->setResult(array('success'=>true, 'blockid' => $request->get('blockid')));
		   }	
		   else
		   {
		   		$response->setResult(array('success'=>false));
				$log->debug(" delete() method.... ERROR OCCURED");
		   }
        }
		catch(Exception $e) 
		{
            $response->setError($e->getCode(),$e->getMessage());
        }

		
		$log->debug("Exiting delete() method....");
        $response->emit();
    }
  
}