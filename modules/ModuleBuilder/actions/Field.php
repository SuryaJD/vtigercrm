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

class ModuleBuilder_Field_Action extends Settings_Vtiger_Index_Action
{
	/**
	 * Class Constructor
	 */
    function __construct()
	{
		global $log;
		$log->debug("Entering __construct() method....");
        $this->exposeMethod( 'add' );
        $this->exposeMethod( 'save' );
        $this->exposeMethod( 'delete' );
        $this->exposeMethod( 'move' );
		$this->exposeMethod( 'edit' );
        $this->exposeMethod( 'unHide' );
		$log->debug("Exiting __construct() method....");
    }

	/**
	 * Function to check permission for the User
	 */
	function checkPermission(Vtiger_Request $request) {
		global $log;
		$log->debug("Entering checkPermission() method....");
		$log->debug("Exiting checkPermission() method....");
		return true;
	}

	/**
	 * Function to check duplicate field for current module
	 */
	public function checkDuplicate( $req,$token )
	{
		global $log;
		$log->debug("Entering checkDuplicate($req,token) method....");
		if( isset( $_SESSION['tks_module_builder'][$token]['fields'] ) )
		{
			$value = $_SESSION['tks_module_builder'][$token];
			if(is_array($value['fields']))
			{
				foreach( $value['fields'] as $k => $v )
				{

					if( strcasecmp( $req, $v['tkslabel'] ) == 0 && $v['deleted'] == 'false' )
					{
						$log->debug("Exiting checkDuplicate($req,token) method.... DUPLICATE ENTRY EXSIST");
						return true;
					}
				}
			}
		}
		$log->debug("Exiting checkDuplicate($req,token) method....");
		return false;
	}

	/**
	 * Function to get Boolean Value
	 */
	private function getBool( $val )
	{
		global $log;
		$log->debug("Entering getBool($val) method....");

		if ( $val == 'M' )
		{
			$log->debug("Exiting getBool($val) method....");
			return 'true';
		}

		if ( $val == '1' )
		{
			$log->debug("Exiting getBool($val) method....");
			return 'true';
		}
		else
		{
			$log->debug("Exiting getBool($val) method....");
			return 'false';
		}
	}

	/**
	 * Function to add field
	 */
    public function add( Vtiger_Request $request )
	{
		global $log;
		$log->debug("Entering add(request array()) method....");
		$token = $request->get('token');

		$_SESSION['tks_module_builder'][$token]['tks_modname'] =  $request->get( 'sourceModule');

		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule(false)));
			$response->emit();
			$log->debug("Exiting add() method.... INITIALIZATION SESSION ERROR");
			return;
		}

		$picklistvalues = array();
		if($request->get( 'pickListValues' ) != '')
		{
			$p = explode(',',$request->get( 'pickListValues' ));
			foreach($p as $key => $value)
			{
				$picklistvalues[$key] = $value;


			}
			/*print_r($picklistvalues);
			exit;*/
		}
		else
		{
			$picklistvalues = '';
		}

        $type 		= strtolower($request->get( 'fieldType' ));
        $moduleName = $request->get( 'sourceModule' );
        $blockId 	= $request->get( 'blockid' );
		//$blockId 	= $blockId - 1;
		$fld 		= array();

	    $isDuplicate = $this -> checkDuplicate( $request->get( 'fieldLabel' ), $token );
        $response = new Vtiger_Response();
		if ( !$isDuplicate )
		{
        	try
			{
				$fld['tkslabel'] 		  	= $request->get( 'fieldLabel' );
				$fld['tkslength']		  	= $request->get( 'fieldLength' );
				$fld['tksdecimal']		  	= $request->get( 'decimal' );
				$fld['tkspicklistvalues'] 	= $request->get( 'mandatory' );
				$fld['tksrelate'] 			= $request->get( 'relate' );
				$fld['tksrequired'] 	  	= $this->getBool( $request->get( 'mandatory' ) );
				$fld['tksdefaultval'] 		= $request->get('fieldDefaultValue');

				if( $request->get( 'mandatory' ) == 'M')
				{
					$filter = 1;
				}

				$fld['tksfilterfield'] 	 	= $this->getBool( $filter );

				$_SESSION['tks_module_builder'][$token]['fields'][] = array( 0 => $fld['tkslabel'] );
				$end_val =  end( $_SESSION['tks_module_builder'][$token]['fields'] );
				$k = key( $_SESSION['tks_module_builder'][$token]['fields'] );
				$responseData = array(
						/*'id'				=> $k, 									 	 'blockid'					=> $blockId,
						'defaultvalue'		=> $request->get('fieldDefaultValue'),
						'SummaryField' 	=> $this->getBool($request->get('summaryfield')),
						'label'				=> $request->get('fieldLabel'),				 'mandatory'				=> $this->getBool($request->get('mandatory')),
						'masseditable'		=> $this->getBool($request->get('masseditable')),	'name'					 	=> 'tks_'.str_replace(' ','',$request->get('fieldLabel')),
						'presence'			=> 'true',									 'quickcreate'			 	=> $this->getBool($request->get('quickcreate')),
						'type'				=> $type,									 'tksrequired' 	  		 	=> $this->getBool($request->get('mandatory')),
						'tksfilterfield' 	=> $this->getBool( $filter ),				 'customField'			 	=> 'true',
						'deleted' 			=> 'false',									'headerfield' 			=> $this->getBool($request->get('headerfield')), */

						'id'				=> $k,
						'blockid'			=> $blockId,
						'label'				=> $request->get('fieldLabel'),
						'name'				=> 'tks_'.str_replace(' ','',$request->get('fieldLabel')),
						'presence'			=> 'true',
						'type'				=> $type,
						'tksrequired' 	  	=> $this->getBool($request->get('mandatory')),
						'customField'		=> 'true',
						'deleted' 			=> 'false',
						'tksfilterfield' 	=> $this->getBool( $filter ),

						'mandatory'			=> $this->getBool($request->get('mandatory')),
						'quickcreate'		=> $this->getBool($request->get('quickcreate')),
						'SummaryField' 		=> $this->getBool($request->get('summaryfield')),
						'headerfield' 		=> $this->getBool($request->get('headerfield')),
						'masseditable'		=> $this->getBool($request->get('masseditable')),
						'defaultvalue'		=> $request->get('fieldDefaultValue'),
						'length'			=> $request->get('fieldLength'),
						'tksfieldtype'		=> $request->get('fieldType'),


					);
				if($picklistvalues != '')
				{
					$responseData['picklistvalues']	= $picklistvalues;
				}

				switch ($responseData['type'])
				{
					case 'text':
							$responseData['type'] = 'string';
							break;

					case 'decimal':
							$responseData['type'] = 'double';
							break;

					case 'checkbox':
							$responseData['type'] = 'boolean';
							break;
					case 'multiselectcombo':
							$responseData['type'] = 'multipicklist';
							break;
					case 'percent':
							$responseData['type'] = 'percentage';
							break;
					case 'currency':
							$responseData['currency_symbol'] = '&#36;';
							break;
					case 'date':
							global $current_user;
							$responseData['date-format'] = $current_user->column_fields['date_format'];
							break;
					case 'time':
							global $current_user;
							$responseData['time-format'] = $current_user->column_fields['hour_format'];
							break;

				}
				$remove = array_pop( $_SESSION['tks_module_builder'][$token]['fields'] );
				foreach( $responseData as $key => $value )
				{
					$fld[$key] = $value;
				}
				$fld['tksrelate'] = 	$request->get( 'relate' );
				$fld['tkspickListValues'] = 	$request->get( 'pickListValues' );
				$fld['tksdecimal'] = 	$request->get( 'decimal' );

				$fieldCount = $_SESSION['tks_module_builder'][$token]['blocks'][$blockId]['fieldCount'];
				$_SESSION['tks_module_builder'][$token]['fields'][$k] = $fld;
				$_SESSION['tks_module_builder'][$token]['blocks'][$blockId]['fieldCount'] =  $fieldCount + 1;
				$_SESSION['tks_module_builder'][$token]['fields'][$k]['sequence'] = ($fieldCount == '' ? 0 : $fieldCount);

				if($responseData['type'] == 'textarea')
				{
					$responseData['type'] = 'string';
				}

            	$response->setResult( $responseData );
        	}
			catch( Exception $e )
			{
            	$response->setError( $e->getCode(), $e->getMessage() );
				$log->debug("add() method.... ERROR OCCURED");
        	}
		}
		else
		{
			$response->setError( '502', vtranslate( 'LBL_DUPLICATE_FILED_EXIST', $request->getModule() ) );
			$log->debug("add() method.... ERROR OCCURED");
		}
		$log->debug("Exiting add() method....");
        $response->emit();
    }

	/**
	 * Function to save field properties
	 */
    public function save( Vtiger_Request $request )
	{
		global $log;
		$log->debug("Entering save(request array()) method....");
		$token = $request->get('token');
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule(false)));
			$response->emit();
			$log->debug("Exiting save(request array()) method.... INITIALIZATION SESSION ERROR");
			return;
		}

		$quickcreate = $request->get( 'quickcreate' );

		if($quickcreate == 0)
		{
			$quickcreate = 'M';
		}

		$presence = $request->get( 'presence' );
		if( $presence == '2' )
		{
			$presence = '1';
		}
		else
		{
			$presence  = '0';
		}

		$defaultValue = $request->get('fieldDefaultValue');
		if(is_array($defaultValue)) {
			$defaultValue = implode(' |##| ',$defaultValue);
		}

        $fieldId = $request->get( 'fieldid' );
		$type = $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['type'];
		if($type == 'date' && $defaultValue != '')
		{
			global $current_user;
			if($current_user->column_fields['date_format'] == 'dd-mm-yyyy')
			{
				$defaultValue = date('Y-m-d', strtotime($defaultValue));
			}
			else if($current_user->column_fields['date_format'] == 'mm-dd-yyyy')
			{
				$defaultValue = str_replace('-', '/', $defaultValue);
				$defaultValue = date('Y-m-d', strtotime($defaultValue));
			}
		}

		/*$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['mandatory'] 	  		= $this->getBool($request->get('mandatory'));
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['presence'] 		    = $this->getBool($presence);
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['quickcreate'] 	  		= $this->getBool($quickcreate);
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['summaryfield'] 	    = $this->getBool($request->get('summaryfield'));
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['masseditable'] 	    = $this->getBool($request->get('masseditable'));
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['defaultvalue'] 	   	= $this->getBool($request->get('fieldDefaultValue'));
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['fieldDefaultValue']	= $defaultValue;
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tksfilterfield']   	= $this->getBool($filter);
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tksrequired'] 	   		= $this->getBool($request->get('mandatory'));*/
		if($request->get('mandatory')!=''){
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['mandatory'] 	  		= $this->getBool($request->get('mandatory'));
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tksrequired'] 	   		= $this->getBool($request->get('mandatory'));
		}
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['presence'] 		    = $this->getBool($presence);
		if($request->get('quickcreate')!=''){
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['quickcreate'] 	  		= $this->getBool($request->get('quickcreate'));
		}
		if($request->get('masseditable')!=''){
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['masseditable'] 	    = $this->getBool($request->get('masseditable'));
		}
		if($request->get('summaryfield')!=''){
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['isSummaryField'] 	  	= $this->getBool($request->get('summaryfield'));
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['SummaryField'] 	    = $this->getBool($request->get('summaryfield'));
		}
		if($request->get('fieldDefaultValue')!=''){
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['defaultvalue'] 	   	= $request->get('fieldDefaultValue');
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['fieldDefaultValue']	= $defaultValue;
		//$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tksfilterfield']   	= $this->getBool($filter);
		}
		if($request->get('headerfield')!=''){
		$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['headerfield'] 	   		= $this->getBool($request->get('headerfield'));
		}

		$lbl1 = $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['label'];

        $response = new Vtiger_Response();
        try
		{

            $response->setResult( array( 'success'=>true,'presence'=>$request->get( 'presence' ),
										'mandatory'=>$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['mandatory'],
										'label'=>$lbl, 'tksfilterfield'=>$this->getBool( $filter),
										'id' => $fieldId, 'blockid' => $request->get( 'blockid' ),
										'quickcreate'=>$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['quickcreate'],
										'SummaryField'=>$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['SummaryField'],
										'headerfield'=>$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['headerfield'],
										'masseditable'=>$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['masseditable'],
										'defaultvalue'=>$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['defaultvalue'] ) );
        }
		catch( Exception $e )
		{
            $response->setError( $e->getCode(), $e->getMessage() );
			$log->debug("save(request array()) method.... ERROR OCCURED");
        }
		$log->debug("Exiting save(request array()) method....");
        $response->emit();
    }


	 public function edit( Vtiger_Request $request )
	{
		global $log;
		$log->debug("Entering edit(request array()) method....");
		$token = $request->get('token');
        $fieldId = $request->get( 'fieldid' );

		$blockId = $request->get( 'blockid' );
        $module = $request->get( 'srcModule' );

		        $temp_array = array();
                $temp_array['tks_modname'] 				=	$module;
                $temp_array['id'] 						=	$fieldId;
                $temp_array['blockid'] 					=	$blockId;
                $temp_array['mandatory'] 				=	$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['mandatory'];
                $temp_array['quickcreate'] 				=   $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['quickcreate'];
                $temp_array['masseditable'] 			=   $_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['masseditable'];
		 	    $temp_array['tkslabel'] 				=	$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['tkslabel'];



        $response = new Vtiger_Response();
        try
		{

            $response->setResult( array( 'success'=>true,'presence'=> $temp_array) );
        }
		catch( Exception $e )
		{
            $response->setError( $e->getCode(), $e->getMessage() );
			$log->debug("edit(request array()) method.... ERROR OCCURED");
        }
		$log->debug("Exiting edit(request array()) method....");
        $response->emit();
    }




	/**
	 * Function to delete field
	*/
    public function delete( Vtiger_Request $request )
	{
		global $log;
		$log->debug("Entering delete(request array() method....");
		$token = $request->get('token');
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule(false)));
			$response->emit();
			$log->debug("Exiting delete(request array()) method.... INITIALIZAION SESSION ERROR");
			return;
		}

		$response = new Vtiger_Response();
        try
		{

		    $fieldId = $request->get( 'fieldid' );
		    $blockid = $request->get( 'blockid' );



		   if( $blockid != '' && $fieldId != '' )
		   {

		   		//$blockid = $blockid - 1;
				//unset($_SESSION['tks_module_builder'][$token]['fields'][$fieldId]);
				$_SESSION['tks_module_builder'][$token]['fields'][$fieldId]['deleted'] = 'true';
				$_SESSION['tks_module_builder'][$token]['blocks'][$blockid]['fieldCount'] = $_SESSION['tks_module_builder'][$token]['blocks'][$blockid]['fieldCount'] - 1;
				if($_SESSION['tks_module_builder'][$token]['blocks'][$blockid]['fieldCount'] < 0)
					$_SESSION['tks_module_builder'][$token]['blocks'][$blockid]['fieldCount'] = 0;



				$response->setResult( array( 'success'=>true, 'label'=>$fld['label'], 'blockid' => $request->get( 'blockid' ), 'id' => $fieldId  ) );
		   }
		   else
		   {
		   		$response->setResult( array( 'success'=>false ) );
		   }
        }
		catch( Exception $e )
		{
            $response->setError( $e->getCode(), $e->getMessage() );
			$log->debug(" delete(request array()) method.... ERROR OCCURED");
        }
		$log->debug("Exiting delete(request array()) method....");
        $response->emit();
    }

	/**
	 * Function to save the moved fields
	*/
    public function move( Vtiger_Request $request )
	{
		global $log;
		$log->debug("Entering move(request array()) method....");

		$token = $request->get('token');
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule(false)));
			$response->emit();
			$log->debug("Exiting move(request array()) method.... INITIALIZAION SESSION ERROR");
			return;
		}

        $updatedFieldsList = $request->get( 'updatedFields' );

		foreach( $updatedFieldsList as $ky => $val )
		{
			$oldblock = $_SESSION['tks_module_builder'][$token]['fields'][$val['fieldid']]['blockid'];
			if($oldblock != '')
			{
				$newblock = $val['block'];

				if($oldblock != $newblock )
				{
					$fldcnt = $_SESSION['tks_module_builder'][$token]['blocks'][$oldblock-1]['fieldCount'];
					$_SESSION['tks_module_builder'][$token]['blocks'][$oldblock-1]['fieldCount'] = $fldcnt - 1;

					$fldcnt = $_SESSION['tks_module_builder'][$token]['blocks'][$newblock-1]['fieldCount'];
					$_SESSION['tks_module_builder'][$token]['blocks'][$newblock-1]['fieldCount'] = $fldcnt + 1;
				}
				$_SESSION['tks_module_builder'][$token]['fields'][$val['fieldid']]['sequence'] = $val['sequence'] ;
				$_SESSION['tks_module_builder'][$token]['fields'][$val['fieldid']]['blockid'] = $val['block'] ;
			}
		}
        $response = new Vtiger_Response();
		$response->setResult( array( 'success'=>true ) );
		$log->debug("Exiting move(request array()) method....");
        $response->emit();
    }
}