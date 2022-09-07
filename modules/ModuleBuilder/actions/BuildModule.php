<?php
/***********************************************************************************************
** The contents of this file are subject to the Vtiger Module-Builder License Version 1.0
 * ( "License" ); You may not use this file except in compliance with the License
 * The Original Code is:  Technokrafts Labs Pvt Ltd
 * The Initial Developer of the Original Code is Technokrafts Labs Pvt Ltd.
 * Portions created by Technokrafts Labs Pvt Ltd are Copyright ( C ) Technokrafts Labs Pvt Ltd.
 * All Rights Reserved.
**
*************************************************************************************************/
error_reporting( 0 );
set_time_limit( 0 );
include_once( 'modules/ModuleBuilder/utils/ZipMB.php' );
include_once( 'vtlib/Vtiger/Module.php' );
include_once( 'vtlib/Vtiger/Menu.php' );
include_once( 'vtlib/Vtiger/Event.php' );
include_once( 'vtlib/Vtiger/Cron.php' );
require_once( 'include/utils/VtlibUtils.php' );
require_once( "modules/ModuleBuilder/utils/tks_utils.php" );
class ModuleBuilder_BuildModule_Action extends Settings_Vtiger_Index_Action
{

	private	$modulename;
	private	$src;
	private	$dst;
	private	$xmlfile;
	private	$xmlfilename;
	private	$export_tmpdir;
	private	$tks_entity;
	private	$zipfilename;
	private $current_language;
	private $flag;
	private $token;
	private $moduleData;

	/**
	 * Class Constructor
	 */
    function __construct()
	{

		global $log;
		$log->debug("Entering __construct() method....");
        $this -> exposeMethod( 'saveModule' );
		$this -> modulename		  = NULL ;
		$this -> src			  = './modules/ModuleBuilder/Module_Template';
		$this -> dst			  = 'test/vtlib/modules/';
		$this -> xmlfile 		  = NULL;
		$this -> xmlfilename	  = NULL;
		$this -> export_tmpdir	  = 'test/vtlib/modules';
		$this -> tks_entity		  = NULL;
		$this -> zipfilename	  = NULL;
		$this -> current_language = NULL;
		$this -> flag 			  = 0;
		$this -> token 			  = NULL;
		$this -> tabid		  = NULL ;
		$this -> moduleData		  = NULL;
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
	 * Function to check module directory exist
	 */
	private function check_dir( $dir )
	{
		global $log;
		$log->debug("Entering check_dir($dir) method....");
		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting check_dir($dir) method.... INITIALIZAION SESSION ERROR");
			exit;
		}

		if ( !file_exists( $dir ) and !is_dir( $dir ) )
		{
			if( @mkdir( $dir ) != 1 )
			{
				$log->debug("Exiting check_dir($dir) method....");
				return false;
			}
		}
		$log->debug("Exiting check_dir($dir) method....");
		return true;
	}

	/**
	 * Function to check dulicate module name
	 */
	private function checkDuplicateModule( $modulename )
	{
		global $log;
		$log->debug("Entering checkDuplicateModule($modulename) method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting checkDuplicateModule($modulename) method.... INITIALIZAION SESSION ERROR");
			exit;
		}
		global $adb;
		$table_flag1 = 0;
		$table_flag2 = 0;

		$query1		= "SELECT name FROM vtiger_tab where name=?";
		$result1   	= $adb->pquery($query1,array($modulename));

		if($adb->num_rows($result1) > 0)
		{
			$table_flag1 = 1;
		}

		$tks_table_name = "vtiger_".strtolower($modulename);
		$query2		= "SHOW TABLES LIKE ?";
		$result2   	= $adb->pquery($query2,array($tks_table_name));

		if($adb->num_rows($result2) > 0)
		{
			$table_flag2 = 1;
		}

		if($table_flag1 == 1 || $table_flag2 == 1)
		{
			$log->debug("Exiting checkDuplicateModule($modulename) method.... Module Exisit");
			return true;
		}
		$log->debug("Exiting checkDuplicateModule($modulename) method....");
		return false;
	}

	/**
	 * Function to check id deleted
	 */
	private function checkDeleted( $farray )
	{
		global $log;
		$log->debug("Entering checkDeleted(arrray()) method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting checkDeleted(arrray()) method.... INITIALIZAION SESSION ERROR");
			exit;
		}
	 	for($i = 0 ;$i < sizeof($farray) ;$i++)
		{
		 	if($farray[$i] == '')
			{
				$log->debug("Exiting checkDeleted(arrray()) method....");
				return true;
			}
			elseif($farray[$i]['deleted'] == 'false')
			{
				$log->debug("Exiting checkDeleted(arrray()) method....");
				return false;
			}
		}
		$log->debug("Exiting checkDeleted(arrray()) method....");
		return true;
	}

	/**
	 * Function to Build Module Data From Session
	 */
	function buildSessionData($token) {
		global $log;
		$log->debug("Entering buildSessionData($token) method....");

		$data = array();

		$tempData = $_SESSION['tks_module_builder'][$token];

		$blockid = 0;
		foreach($tempData['blocks'] as $key => $value )
		{
			if($tempData['blocks'][$key]['fieldCount'] > 0 && $tempData['blocks'][$key]['deleted'] == 'false')
			{
				$data['tks_blocks'][] = $value;
				end($data['tks_blocks']);
				$blockid = key($data['tks_blocks']);

				foreach($tempData['fields'] as $k => $v)
				{
					if( $v['blockid'] == $value['block_id'] && $v['deleted'] == 'false')
					{
						$data['tks_blocks'][$blockid]['tks_fields'][] = $v;
					}
				}
				$data['tks_blocks'][$blockid]['tks_fields'] = array_sort($data['tks_blocks'][$blockid]['tks_fields'], 'sequence', SORT_ASC);
			}
		}




		$data['tks_modname'] 	= $_SESSION['tks_module_builder'][$token]['tks_modname'];
		$data['tks_label'] 		= $_SESSION['tks_module_builder'][$token]['tks_label'];
		$data['tks_parent'] 	= $_SESSION['tks_module_builder'][$token]['tks_parent'];

		$log->debug("Exiting buildSessionData($token) method....");
		return $data;
	}


	/**
	 * Function to save module and build
	 */
    public function saveModule( Vtiger_Request $request )
	{


		global $log;
		$log->debug("Entering saveModule(request array()) method....");


		$token = $request->get('token');
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $request->getModule(false)));
			$response->emit();
			$log->debug("Exiting saveModule(request array()) method.... INITIALIZAION SESSION ERROR");
			exit;
		}
		$this -> token = $token;

		$result = '';
		global $adb;


		$this -> moduleData		 = $this -> buildSessionData($token);

		$this -> modulename		 = ucfirst( strtolower($this -> moduleData['tks_modname']) );
        $this -> tabid           = $request -> get( 'tabid' ) ;
		$this -> dst			 = $this -> dst.$this -> modulename;
		$this -> tks_entity		 = $this -> moduleData['tks_modname'];
		$this -> zipfilename 	 = $this -> export_tmpdir.'/'.$this -> modulename.'.zip';

		if( sanitizeModuleName($this -> modulename) )
		{
			$this->response( vtranslate('LBL_RESERVED_KEYWORD', $request->getModule() ) );
		}

		if( $this -> checkDuplicateModule ( $this -> modulename ) )
		{
			$this->response( vtranslate( 'LBL_EXIST_MODULE', $request->getModule() ) );
		}

		$realtedlist = ModuleBuilder_MBindex_View::modList();
		$temp_rel = array();
		$i=0;


		foreach($realtedlist as $key => $val)
		{
			if($request ->get($key) != '')
			{
				$temp_rel[$i]['module'] = $key;
				if($request ->get($key.'_add') != '')
				{
					$temp_rel[$i]['add'] = 1;
				}
				else
				{
					$temp_rel[$i]['add'] = 0;
				}
				if($request ->get($key.'_sel') != '')
				{
					$temp_rel[$i]['sel'] = 1;
				}
				else
				{
					$temp_rel[$i]['sel'] = 0;
				}
				$i++;
			}
		}
		$_SESSION['tks_module_builder'][$token]['tks_relatedlist'] = $temp_rel;

		$this -> moduleData	['tks_relatedlist'] = $temp_rel;

		$block = array();
		$sequenceList = $request->get('tkssequence');




		if(is_array($sequenceList) && !empty($sequenceList))
		{
			foreach($sequenceList as $key => $val)
			{
				foreach($this -> moduleData['tks_blocks'] as $k => $v)
				{
					if($val == $v['name'])
					{
						$block[] = $this -> moduleData['tks_blocks'][$k];
						break;
					}
				}
			}

			unset($this -> moduleData['tks_blocks']);
			$this -> moduleData['tks_blocks']=$block;
		}
		else
		{
			$this -> moduleData['tks_blocks'] = array_reverse($this -> moduleData['tks_blocks']);

		}
		unset($block);


		if( $request -> get( 'download' ) == 'download' )
		{
			$zipfilename = 'test/vtlib/modules/'. ucfirst( strtolower(  vtlib_purify ( $this -> modulename ) ) ).'.zip';
			if ( !file_exists( $zipfilename ) )
			{
				$this->response(vtranslate('LBL_ZIP_NOT_PRESENT', $request->getModule()));
			}
		}
		else
		{

			if( sizeof( $this -> moduleData[ 'tks_blocks' ] ) < 1 || $this -> moduleData[ 'tks_blocks' ] == '' )
			{
				$this->response(vtranslate('LBL_ZERO_BLOCK', $request->getModule()));
			}
			elseif(sizeof($this -> moduleData[ 'tks_blocks' ] ) > 0 )
			{
				/*this is to check there must be atleat one field per block*/
				for( $i = 0; $i < sizeof( $this -> moduleData[ 'tks_blocks' ] ) ; $i++ )
				{
					if( $this->checkDeleted($this -> moduleData[ 'tks_blocks' ]) )
					{
						for( $j = 0; $j < sizeof( $this -> moduleData[ 'tks_blocks' ][ $i ][ 'tks_fields' ] ) ; $j++ )
						{
							$fieldarr = $this -> moduleData[ 'tks_blocks' ][ $i ][ 'tks_fields' ];
							if(  $this->checkDeleted($fieldarr) )
							{
								$this->response(vtranslate('LBL_ZERO_FIELD_IN_BLOCK', $request->getModule()).
													$this -> moduleData[ 'tks_blocks' ][ $i ]['name'].' BLock');
							}
						}
					}
				 }


				if( $this -> check_dir( 'test/vtlib/modules' ) == false )
			    {
					$this->response(vtranslate('LBL_DIR_CREATION', $request->getModule()));
				}
				elseif(!class_exists(ZipArchive))
				{
					$this->response(vtranslate('LBL_ZIP_ARCHIVE_PACKAGE_NOT_FOUND', $request->getModule()));
				}
				elseif(!class_exists(DOMDocument))
				{
					$this->response(vtranslate('LBL_DOMDOCUMENT_PACKAGE_NOT_FOUND', $request->getModule()));
				}
				else
				{
					$this ->  copy_folder( $this -> src, $this -> dst, $request, 'BASE' );
                    $this ->  saveIntoDB( $request );
				}
			}
		}




		$log->debug("Exiting saveModule(request array()) method....");
        $this->response('');
    }

	/**
	 * Function to forward response if validation fails or success
	 */
	private function response( $result )
	{
		global $log;
		$log->debug("Entering response($result) method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting response($result) method.... INITIALIZAION SESSION ERROR");
			exit;
		}



		$response = new Vtiger_Response();
		try
		{

			if( empty( $result ) )
			{
				$log->debug("response($result) method.... Module Build successfully");
				$response->setResult( array( 'success'=>true, 'saved' => 'success', 'tabid' => $this -> tabid ));
			}
			else
			{
				$log->debug("response($result) method.... Module Build Failure");
				$response->setResult( array( 'success'=>true, 'saved' => 'fail', 'status' => $result ) );
			}
		}
		catch( Exception $e)
		{
			$log->debug("response($result) method.... Module Build ERROR");
			$response->setError( $e->getCode(), $e->getMessage());
		}
		$log->debug("Exiting response($result) method....");
		$response->emit();
		exit();
	}

	/**
	 * Function to copy default module template folder to test folder for further processing
	 */
	private function copy_folder( $src,$dst,$request,$base)
	{

		global $log;
		$log->debug("Entering copy_folder($src,$dst,request array(),$base) method....");

	 	$token = $this -> token;


		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting copy_folder($src,$dst,request array(),$base) method.... INITIALIZAION SESSION ERROR");
			exit;
		}
		$content = '';
        $dir = opendir( $src);
        @mkdir( $dst);


		while( false !== ( $file = readdir( $dir)) )
		{
            if ( ( $file != '.' ) && ( $file != '..' ))
			{
				if ( is_dir( $src . '/' . $file) )
				{
                    $this -> copy_folder( $src . '/' . $file,$dst . '/' . $file,$request,'PATH');
                }
                else
				{
                    @copy( $src . '/' . $file,$dst . '/' . $file);
				}
          	}

			if( $file == 'ModuleFile.php')
			{
				@rename( $dst.'/'."ModuleFile.php" , $dst.'/'.$this -> modulename.".php");
			}
			if( $file == 'languages')
			{
				@rename( $dst.'/languages/'."ModuleFile.php" , $dst.'/languages/'.$this -> modulename.".php");
			}
		}
        @closedir( $dir);


		if( $base == 'BASE')
		{
			$this -> export( $request);
		}
		$log->debug("Exiting copy_folder($src,$dst,request array(),$base) method....");


	}

	/**
	 * Function to create manifest XML file
	 */
	private function getManifestFilePath()
	{
		global $log;
		$log->debug("Entering getManifestFilePath() method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting getManifestFilePath() method.... INITIALIZAION SESSION ERROR");
			exit;
		}

		if( empty( $this ->  xmlfilename))
		{
			// Set the module xml filename to be written for exporting.
			$this ->  xmlfilename = "manifest-".time().".xml";
		}
		$log->debug("Exiting getManifestFilePath() method....");
		return $this ->  dst.'/'.$this ->  xmlfilename;
	}

	/**
	 * Function to create query for module table and module custom table
	 */
	private function create_tablesql( $tablename, $type)
	{
		global $log;
		$log->debug("Entering create_tablesql( $tablename, $type) method....");
		$log->debug("Exiting create_tablesql( $tablename, $type) method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting create_tablesql( $tablename, $type) method.... INITIALIZAION SESSION ERROR");
			exit;
		}

		$engine = ' ENGINE=InnoDB DEFAULT CHARSET=utf8';
		$primarykey	= '`'.strtolower( $this -> modulename).'id`'.' int(11) NOT NULL, ';
		$primarykeycf	= '`'.strtolower( $this -> modulename).'id`'.' int(11) NOT NULL, ';
		$moduleno = '`'.strtolower( $this -> modulename).'no` varchar(100) default NULL, ';
		$field = '';
		if( !$type == 'cf')
		{
			$mblocks 	= $this -> moduleData['tks_blocks'];
			for( $i=0; $i < sizeof( $mblocks) ; $i++)
			{
				if($mblocks[$i]['deleted'] == 'true')
				{
					continue;
				}

				$mfield 	= $mblocks[$i]['tks_fields'];
				for( $j=0; $j<sizeof( $mfield); $j++ )
				{
					$m_field = $mfield[$j];

					if($m_field['deleted'] == 'true')
					{
						continue;
					}

					$field .= '`'.$m_field['fieldname'].'` ';
					if( $m_field['typeofdata'] == 'V~M' || $m_field['typeofdata'] == 'V~O'
							||$m_field['typeofdata'] == 'E~M' || $m_field['typeofdata'] == 'E~O')
					{
						$type = 'varchar('.$m_field['maximumlength'].')'.' ';
					}

					if( $m_field['typeofdata'] == 'D~M' || $m_field['typeofdata'] == 'D~O')
					{
						$type = 'date'.' ';
					}
					if( $m_field['typeofdata'] == 'N~M' || $m_field['typeofdata'] == 'N~O')
					{
						if( !isset( $m_field['decimal']))
						$type = 'varchar('.$m_field['maximumlength'].')'.' ';
						else
						$type = 'decimal('.$m_field['decimal'].')'.' ';
					}
					if( $m_field['typeofdata'] == 'I~M' || $m_field['typeofdata'] == 'I~O')
					{
						$type = 'int('.$m_field['maximumlength'].')'.' ';
					}

					if( $m_field['typeofdata'] == 'C~M' || $m_field['typeofdata'] == 'C~O')
					{
						$type = 'varchar(3)'.' ';
					}
					if( $m_field['typeofdata'] == 'T~M' || $m_field['typeofdata'] == 'T~O')
					{
						$type = 'varchar('.$m_field['maximumlength'].')'.' ';
					}
						$field .= $type;

					$default = 'default NULL ';

					$field .= $default;

					if( $i == sizeof( $mblocks)-1 && $j == sizeof( $mfield)-1)
					{
						$field .= ' ';
					}
					else
					{
						$field .= ',';
					}
				}
			}

			$log->debug("Exiting create_tablesql( $tablename, $type) method....");
			return 'CREATE TABLE `'.$tablename."` (".$primarykey.$moduleno.$field." , PRIMARY KEY (`".strtolower( $this -> modulename)."id"."`) )".$engine;
		}
		else
		{
			$log->debug("Exiting create_tablesql( $tablename, $type) method....");
			return 'CREATE TABLE `'.$tablename."cf` (".$primarykeycf."PRIMARY KEY (`".strtolower( $this -> modulename)."id"."`) )".$engine;
		}
	}

	/**
	 * Function to create query for module table and module custom table
	 */
	private function create_tablesq2( $tablename)
	{
		global $log;
		$log->debug("Entering create_tablesql( $tablename, $type) method....");
		$log->debug("Exiting create_tablesql( $tablename, $type) method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting create_tablesql( $tablename, $type) method.... INITIALIZAION SESSION ERROR");
			exit;
		}

		$engine = ' ENGINE=InnoDB DEFAULT CHARSET=utf8';
		$primarykey	= '`recordid` int(25) NOT NULL, ';
		$primarykeycf	= '`userid` int(25) NOT NULL, ';
		$moduleno = '`starred` varchar(100) default NULL';
		$field = '';

		$log->debug("Exiting create_tablesql( $tablename, $type) method....");
		return 'CREATE TABLE `'.$tablename."_user_field` (".$primarykey.$primarykeycf.$moduleno." , KEY (`".strtolower( $tablename)."_user_field"."`) )".$engine;


	}

	/**
	 * Function to get the field name from the field label
	 */
	private function getFieldName( $fldlabel )
	{
		global $log;
		$log->debug("Entering getFieldName( $fldlabel ) method....");


		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting getFieldName( $fldlabel ) method.... INITIALIZAION SESSION ERROR");
			exit;
		}

		$log->debug("Exiting getFieldName( $fldlabel ) method....");
		return substr( strtolower( $this -> modulename.'_'."tks_".str_replace( " ", "", strtolower( $fldlabel ) ) ), 0, 30 );
	}

	/**
	 * Function to get return number for true or false
	 */
	private function returnNos( $val )
	{
		global $log;
		$log->debug("Entering returnNos( $val ) method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting returnNos( $val ) method.... INITIALIZAION SESSION ERROR");
			exit;
		}
		$log->debug("Exiting returnNos( $val ) method....");
		return $val == 'true' ? '1' : '0';
	}

	/**
	 * Function to get the field attributes
	 */
	private function getFieldAttributes( $field, $seq )
	{
		global $log;
		$log->debug("Entering getFieldAttributes( $field, $seq ) method....");


		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting getFieldAttributes( $field, $seq ) method.... INITIALIZAION SESSION ERROR");
			exit;
		}

		$field_data=array();
		$fldType = strtolower($field['type']);
		$fldlength=$field['tkslength'];
		$field_data['fieldname']  			= substr(strtolower( $this -> modulename ).'_'."tks_".str_replace( " ", "", strtolower( $field['tkslabel'])), 0, 30);
		$field_data['columnname'] 			= substr(strtolower( $this -> modulename ).'_'."tks_".str_replace( " ", "", strtolower( $field['tkslabel'])), 0, 30);
		$field_data['tablename']			='vtiger_'.strtolower( $this -> modulename);
		$field_data['generatedtype']		= '1';
		$field_data['fieldlabel']			= $field['tkslabel'];
		$field_data['readonly']				= '1';
		$field_data['presence']				= '2';
		$field_data['defaultvalue']			= $field['fieldDefaultValue'];
		$field_data['sequence']				= $seq;
		$field_data['fieldselect']			= $field['blockid'].'_'.$seq;
		$field_data['quickcreate']			= $field['quickcreate'] == 'true' ? '2' : '1';
		$field_data['quickcreatesequence']	= '';
		$field_data['displaytype']			= '1';
		$field_data['info_type']			= 'BAS';
		$field_data['helpinfo']				= '<![CDATA[]]>';
		$field_data['masseditable']			= $this -> returnNos( $field['masseditable']);
		$tks_mfield							= $field['tksrequired'];
		if( $field['tksfilterfield'] == 'true' )
		{
			$field_data['filter']='Yes';
		}
		else
		{
			$field_data['filter']='No';
		}

		if( get_magic_quotes_gpc() == 1)
		{
			$fldlabel = stripslashes( $field['tkslabel']);
		}

		$uitype='';
		$fldPickList='';

		if( $field['tksdecimal'] != '')
		{
			$decimal=$field['tksdecimal'];
		}
		else
		{
			$decimal=0;
		}

		$type='';
		$uichekdata='';
		if( $fldType == 'string')
		{
			$field_data['uitype']='2';
			$field_data['maximumlength']=$fldlength;
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='V~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='V~O';
				$field_data['fieldtype']='O';
			}

		}
		elseif( $fldType == 'number')
		{
			$field_data['uitype']='7';
			$field_data['maximumlength']=$fldlength;
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='N~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='N~O';
				$field_data['fieldtype']='O';
			}

		}
		elseif( $fldType == 'double')
		{
			$field_data['uitype']='7';
			$field_data['maximumlength']='100';
			$field_data['decimal']=$fldlength .','.$decimal;
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='N~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='N~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'percentage')
		{
			$field_data['uitype']='9';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='N~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='N~O';
				$field_data['fieldtype']='O';
			}

			$field_data['decimal']='5,2';
		}
		elseif( $fldType == 'currency')
		{
			$field_data['uitype']='71';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='N~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='N~O';
				$field_data['fieldtype']='O';
			}
			$field_data['decimal']=$fldlength .','.$decimal;
		}
		elseif( $fldType == 'date')
		{
			$field_data['uitype']='5';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='D~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='D~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'email')
		{
			$field_data['uitype']='13';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='E~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='E~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'time')
		{
			$field_data['uitype']='14';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='T~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='T~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'phone')
		{
			$field_data['uitype']='11';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='V~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='V~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'picklist')
		{
			$field_data['uitype']='15';
			$field_data['maximumlength']='100';
			$field_data['pickArray'] = $field['tkspickListValues'];
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='V~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='V~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'url')
		{
			$field_data['uitype']='17';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='V~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='V~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'boolean')
		{
			$field_data['uitype']='56';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='C~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='C~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'textarea')
		{
			$field_data['uitype']='21';
			$field_data['maximumlength']='250';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='V~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='V~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'multipicklist')
		{
			$field_data['uitype']='33';
			$field_data['maximumlength']='100';
			$field_data['pickArray'] = $field['tkspickListValues'];
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='V~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='V~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'skype')
		{
			$field_data['uitype']='85';
			$field_data['maximumlength']='100';
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='V~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='V~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'integer')
		{
			$field_data['uitype']='1';
			$field_data['maximumlength']=$fldlength;
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='I~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='I~O';
				$field_data['fieldtype']='O';
			}
		}
		elseif( $fldType == 'relate')
		{
			$field_data['uitype']='10';
			$field_data['maximumlength']='100';

			$field_data['relatedmodules'] = $field['tksrelate'];
			if( $tks_mfield== 'true' )
			{
				$field_data['typeofdata']='V~M';
				$field_data['fieldtype']='M';
			}
			else
			{
				$field_data['typeofdata']='V~O';
				$field_data['fieldtype']='O';
			}
		}
		$log->debug("Exiting getFieldAttributes( $field, $seq ) method....");
		return $field_data;
	}

	/**
	 * Function to claborate all the related module files to embed in the language file
	 */
	private function getlangStr( $mod_list )
	{
		global $log;
		$log->debug("Entering getlangStr(array()) method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting getlangStr(array()) method.... INITIALIZAION SESSION ERROR");
			exit;
		}
		global $adb;
		$str = NULL;
		for( $i = 0; $i < sizeof( $mod_list ); $i++ )
		{
			$str .= '\''.$mod_list[ $i ].'\' => \''.vtranslate('SINGLE_'.$mod_list[ $i ],$mod_list[ $i ]). '\','."\n";
		}
		$log->debug("Exiting getlangStr(array()) method....");
		return $str;
	}
	/**
	 * Function to Save data into database.
	 */
        private function saveIntoDB( $request)
        {

            global $log,$adb,$current_user;
            $log->debug("Entering saveIntoDB(request array()) method....");

            $token = $this -> token;
            if($token == '')
            {
                $response = new Vtiger_Response();
                $response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
                $response->emit();
                $log->debug("Exiting saveIntoDB(request array()) method.... INITIALIZAION SESSION ERROR");
                exit;
            }
            //*********** Insert Table *************//
            $tabid		=	$this -> tabid;
            $user_id	=	$current_user->id;
            $parent		=	$this -> moduleData['tks_parent'];		//$request->get('tks_parent');
            $tks_entity	=	$this -> moduleData['tks_modname'];	//$request->get('tks_entity');
            $modulename	=	$this -> moduleData['tks_modname'];
            $label		=	$this -> moduleData['tks_label'];
            $sql		=	"SELECT version FROM vtiger_tks_module WHERE tabid=?";
            $result		=	$adb->pquery($sql,array($tabid));
            if($adb->num_rows($result)>0 && $tabid!=''){
                $sql = "UPDATE vtiger_tks_module SET tablabel=?,name=?, modifiedby=?,tks_entity=?,version=?,parent=? WHERE tabid=? ";
                $adb->pquery($sql, array($label,$modulename, $user_id,$tks_entity,1,$parent,$tabid));
            }else{
                $tabid_res  =  $adb->pquery("SELECT MAX(tabid) FROM vtiger_tks_module" , array());
                $row1 = $adb->fetch_row($tabid_res);
                $this -> tabid = $row1[0]+1;
                $tabid = $this -> tabid;
                $adb->pquery("INSERT INTO vtiger_tks_module(tabid,name,tablabel,modifiedby,ownedby,version,parent,tks_entity) VALUES(?,?,?,?,?,?,?,?)" , array($tabid,$modulename, $label,$user_id,$user_id,1,$parent,$tks_entity));
            }
            $mblocks 	= $this -> moduleData['tks_blocks'];
            if($tabid!=''){
                $sql = "DELETE FROM vtiger_tks_blocks WHERE tabid=?";
                $adb->pquery($sql, array($tabid));
                $sql = "DELETE FROM vtiger_tks_field WHERE tabid=?";
                $adb->pquery($sql, array($tabid));
                $sql = "DELETE FROM vtiger_tks_fieldmodulerel WHERE tabid=?";
                $adb->pquery($sql, array($tabid));
                $sql = "DELETE FROM vtiger_tks_picklist WHERE tabid=?";
                $adb->pquery($sql, array($tabid));
                $sql = "DELETE FROM vtiger_tks_relatedlists WHERE tabid=?";
                $adb->pquery($sql, array($tabid));
            }

            //*********** Insert Block *************//

            for( $i=0; $i < sizeof( $mblocks) ; $i++)
            {
                if($mblocks[$i]['deleted'] == 'true')
                    continue;
                $tabid_res  =  $adb->pquery("SELECT MAX(blockid) FROM vtiger_tks_blocks" , array());
                $row1 = $adb->fetch_row($tabid_res);
                $blobkId = $row1[0]+1;
                $blocksequence  =  $i+1;
                $adb->pquery("INSERT INTO vtiger_tks_blocks(blockid, tabid, blocklabel, sequence, show_title) VALUES(?,?,?,?,?)" , array($blobkId,$tabid, $mblocks[$i]['name'],$blocksequence,$mblocks[$i]['name']));
                $mfield 	= $mblocks[$i]['tks_fields'];
                $k = 0;
                //*********** Insert Fields *************//
                for(  $j=0; $j<sizeof( $mfield); $j++ )
                {
                    if($mfield[$j]['deleted'] == 'true')
                    {
                            continue;
                    }
                    $s = $k+1;
                    $fldname= $mfield[$j]['fieldname'];
                    $tablename = $mfield[$j]['tablename'];
                    $fldlabel = $mfield[$j]['fieldlabel'];
                    $fldcolumnname = $mfield[$j]['columnname'];
                    $defaultvalue = $mfield[$j]['defaultvalue'];
                    $maximumlength = $mfield[$j]['maximumlength'];
                    $blockid = $mfield[$j]['blockid'];
                    $uitype = $mfield[$j]['uitype'];
                    $typeofdata = $mfield[$j]['typeofdata'];

                    if($mfield[$j]['isQuickCreateDisabled'] == 'true')
                        $quickcreate=1;
                    else
                        $quickcreate=0;
                    if($mfield[$j]['tksfilterfield'] == 'true')
                        $isfilter=1;
                    else
                        $isfilter=0;
                     if($mfield[$j]['isSummaryField'] == 'true')
                        $summaryfield=1;
                    else
                        $summaryfield=0;
                    $generatedtype= $mfield[$j]['generatedtype'];
                    $readonly = $mfield[$j]['readonly'];
                    $presence = $mfield[$j]['presence'];
                    $displaytype = $mfield[$j]['displaytype'];
                    $quickcreatesequence = $mfield[$j]['quickcreatesequence'];
                    $info_type = $mfield[$j]['info_type'];
                    $helpinfo = $mfield[$j]['helpinfo'];
                    $masseditable = $mfield[$j]['masseditable'];
                    $tabid_res  =  $adb->pquery("SELECT MAX(fieldid) FROM vtiger_tks_field" , array());
                    $row1 = $adb->fetch_row($tabid_res);
                    $fieldid = $row1[0]+1;
                    $adb->pquery("INSERT INTO vtiger_tks_field(tabid, fieldid, columnname, tablename,generatedtype, uitype, fieldname, fieldlabel,readonly,presence,defaultvalue, maximumlength, sequence, block,displaytype,typeofdata, quickcreate,quickcreatesequence,info_type,isfilter, helpinfo, masseditable,summaryfield) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)" ,
                    array($tabid,$fieldid, $fldcolumnname,$tablename,$generatedtype,$uitype,$fldname,$fldlabel,$readonly,$presence,$defaultvalue,$maximumlength,$s,$blockid,$displaytype,$typeofdata,$quickcreate,$quickcreatesequence,$info_type,$isfilter,$helpinfo,$masseditable,$summaryfield));
                    //Relation Fields.
                    if($uitype == 10)
                    {
                        $module = $this -> moduleData['tks_modname'];
                        $relatedmodules = $mfield[$j]['relatedmodules'];
                        $rls=0;
                        if(is_array($relatedmodules))
                        {
                            for($rls=0;$rls<count($relatedmodules);$rls++)
                            {
                                $relmodule=$relatedmodules[$rls];
                                $adb->pquery("INSERT INTO vtiger_tks_fieldmodulerel(fieldid,tabid,module, relmodule, status,sequence) VALUES(?,?,?,?,?,?)" ,
                                array($fieldid,$tabid,$module,$relmodule,'',$rls));
                            }
                        }
                        else
                        {
                            $relmodule=$relatedmodules;
                            $adb->pquery("INSERT INTO vtiger_tks_fieldmodulerel(fieldid,tabid,module, relmodule, status,sequence) VALUES(?,?,?,?,?,?)" ,
                            array($fieldid,$tabid,$module,$relmodule,'',$rls));
                        }
                    }
                    //Picklist and Multi Picklis Fields.
                    if($uitype == 15 || $uitype == 33)
                    {
                        $picklistvalues = $mfield[$j]['picklistvalues'];
                        $pls=0;
                        foreach ($picklistvalues as $picklistvalue) {
                            $adb->pquery("INSERT INTO vtiger_tks_picklist(fieldid,tabid,picklistvalue, sequence) VALUES(?,?,?,?)" ,
                            array($fieldid,$tabid,$picklistvalue,$pls));
                            $pls++;
                        }
                    }
                    $k++;
                }
            }
            //Related List.
            $tks_relatedlist = $this -> moduleData['tks_relatedlist'];
            for($i=0;$i<count($tks_relatedlist);$i++)
            {
                $tabid_res  =  $adb->pquery("SELECT tabid FROM vtiger_tab WHERE `tablabel` LIKE ?" , array($tks_relatedlist[$i]['module']));
                $row1 = $adb->fetch_row($tabid_res);
                $related_tabid= $row1['tabid'];
                $tabid_res  =  $adb->pquery("SELECT MAX(relation_id) FROM vtiger_tks_relatedlists" , array());
                $row1 = $adb->fetch_row($tabid_res);
                $relation_id= $row1[0]+1;
                $name   =   'get_related_list';
                $sequence   =   $i;
                $label  =   $tks_relatedlist[$i]['module'];
                $presence=0;
                $actions    =   array();
                if($tks_relatedlist[$i]['add'])
                    $actions[]    =   'add';
                if($tks_relatedlist[$i]['sel'])
                    $actions[]    =   'select';
                $action= implode(',',$actions);
                $adb->pquery("INSERT INTO vtiger_tks_relatedlists(relation_id,tabid,related_tabid, name,sequence,label,presence,actions) VALUES(?,?,?,?,?,?,?,?)" ,
                array($relation_id,$tabid,$related_tabid,$name,$sequence,$label,$presence,$action));
            }
            $log->debug("Exiting saveIntoDB(request array()) method....");
        }



	/**
	 * Function to export module zip to the test folder
	 */
	private function export( $request)
	{
		global $log;
		$log->debug("Entering export(request array()) method....");

		$token = $this -> token;
		if($token == '')
		{
			$response = new Vtiger_Response();
			$response->setError('502', vtranslate('LBL_FAILED_MODULE_INIT', $this -> modulename));
			$response->emit();
			$log->debug("Exiting export(request array()) method.... INITIALIZAION SESSION ERROR");
			exit;
		}

		$modulename = $this -> modulename;
		$zipfilename = '';
		/*START -- Temp array to take care of  all related list*/
		$temp_rel = array();
		/*END -- Temp array to take care of  all related list*/

		$mblocks 	= $this -> moduleData['tks_blocks'];
		for( $i=0; $i < sizeof( $mblocks) ; $i++)
		{
			if($mblocks[$i]['deleted'] == 'true')
			{
				continue;
			}

			$mfield 	= $mblocks[$i]['tks_fields'];
			$k = 0;
			for(  $j=0; $j<sizeof( $mfield); $j++ )
			{
				if($mfield[$j]['deleted'] == 'true')
				{
					continue;
				}

				$s = $k+1;
				$m_field = $this -> getFieldAttributes( $mfield[$j],$s);

				$this -> moduleData['tks_blocks'][$i]['tks_fields'][$j]
						= array_merge( $this -> moduleData['tks_blocks'][$i]['tks_fields'][$j], $m_field);
				$k++;
			}
		}

		$ManifestFilePath = $this -> getManifestFilePath();
		$tablename = "vtiger_".strtolower( $this -> modulename);
		$primarykey	= strtolower( $this -> modulename).'id';
		$label = ucfirst( $this -> moduleData['tks_modname']);

		$xml = new DOMDocument( "1.0","UTF-8");
		$module = $xml->createElement( "module");
		$xml->appendChild( $module);

		$exporttime   = $xml->createElement( "exporttime");
		$exporttimeText = $xml->createTextNode( date( 'Y-m-d H:i:s'));
		$exporttime->appendChild( $exporttimeText);

		$name   = $xml->createElement( "name");
		$nameText = $xml->createTextNode( $this -> modulename);
		$name->appendChild( $nameText);

		$label1   = $xml->createElement( "label");
		$label1Text = $xml->createTextNode( $label);
		$label1->appendChild( $label1Text);

		$parent   = $xml->createElement( "parent");
		$parentText = $xml->createTextNode($this -> moduleData['tks_parent']);
		$parent->appendChild( $parentText);

			$module->appendChild( $exporttime);
			$module->appendChild( $name);
			$module->appendChild( $label1);
			$module->appendChild( $parent);

		$dependencies   = $xml->createElement( "dependencies");
			$vtiger_version   = $xml->createElement( "vtiger_version");
			$vtiger_versionText = $xml->createTextNode( '7.1.0');
			$vtiger_version->appendChild( $vtiger_versionText);
			$dependencies->appendChild( $vtiger_version);
		$module->appendChild( $dependencies);

		$licence   			= $xml->createElement( "license");
			$inline   		= $xml->createElement( "inline");
			$lic 			= vtranslate('LBL_TECH_LICENCE', 'ModuleBuilder');
			$lic 			= str_replace( '##moduleLable##', $this -> moduleData['tks_modname'], $lic);
			$techlicence 	= $xml->createCDATASection( $lic);
			$inline->appendChild( $techlicence);
			$licence->appendChild( $inline);
		$module->appendChild( $licence);

		$tables   = $xml->createElement( "tables");
			$table   = $xml->createElement( "table");

				$table_name   = $xml->createElement( "name");
				$table_nameText = $xml->createTextNode( $tablename);
				$table_name->appendChild( $table_nameText);

				$sql   = $xml->createElement( "sql");
				$query = $this -> create_tablesql( $tablename, '');
				$sqlText = $xml->createCDATASection( $query);
				$sql->appendChild( $sqlText);

			$table->appendChild( $table_name);
			$table->appendChild( $sql);
			$tables->appendChild( $table);

		$table1   = $xml->createElement( "table");
				$cftable_name   = $xml->createElement( "name");
				$cftable_nameText = $xml->createTextNode( $tablename.'cf');
				$cftable_name->appendChild( $cftable_nameText);

				$cfsql   = $xml->createElement( "sql");
				$cfquery = $this -> create_tablesql( $tablename, 'cf');
				$cfsqlText = $xml->createCDATASection( $cfquery);
				$cfsql->appendChild( $cfsqlText);

				$table1->appendChild( $cftable_name);
				$table1->appendChild( $cfsql);
				$tables->appendChild( $table1);

				$table2   = $xml->createElement( "table");
				$usertable_name   = $xml->createElement( "name");
				$usertable_nameText = $xml->createTextNode( $tablename.'_user_field');
				$usertable_name->appendChild( $usertable_nameText);

				$usersql   = $xml->createElement( "sql");
				$userquery = $this -> create_tablesq2( $tablename);
				$usersqlText = $xml->createCDATASection( $userquery);
				$usersql->appendChild( $usersqlText);

				$table2->appendChild( $usertable_name);
				$table2->appendChild( $usersql);
				$tables->appendChild( $table2);

		$module->appendChild( $tables);

			$blocks   	= $xml->createElement( "blocks");
			$mblocks 	= $this -> moduleData['tks_blocks'];

			for( $i=0; $i < sizeof( $mblocks) ; $i++)
			{
				if($mblocks[$i]['deleted'] == 'true')
					continue;
				$block   = $xml->createElement( "block");
					$block_label   = $xml->createElement( "label");
					$block_labelText = $xml->createTextNode( $mblocks[$i]['name']);
					$block_label->appendChild( $block_labelText);

					$block_fields   = $xml->createElement( "fields");

				$mfield 	= $mblocks[$i]['tks_fields'];
				$k = 0;
				for(  $j=0; $j<sizeof( $mfield); $j++ )
				{
					if( $i==0 && $j==0)
					{
						$field   = $xml->createElement( "field");

							$fieldname   = $xml->createElement( "fieldname");
							$fieldnameText = $xml->createTextNode( strtolower( $this -> modulename).'no');
							$fieldname->appendChild( $fieldnameText);

							$uitype   = $xml->createElement( "uitype");
							$uitypeText = $xml->createTextNode( '4');
							$uitype->appendChild( $uitypeText);

							$columnname   = $xml->createElement( "columnname");
							$columnnameText = $xml->createTextNode( strtolower( $this -> modulename).'no');
							$columnname->appendChild( $columnnameText);

							$tablename1   = $xml->createElement( "tablename");
							$tablename1Text = $xml->createTextNode( $tablename);
							$tablename1->appendChild( $tablename1Text);

							$generatedtype   = $xml->createElement( "generatedtype");
							$generatedtypeText = $xml->createTextNode( '1');
							$generatedtype->appendChild( $generatedtypeText);

							$fieldlabel   = $xml->createElement( "fieldlabel");
							$fieldlabelText = $xml->createTextNode( $this -> modulename.' No');
							$fieldlabel->appendChild( $fieldlabelText);

							$readonly   = $xml->createElement( "readonly");
							$readonlyText = $xml->createTextNode( '1');
							$readonly->appendChild( $readonlyText);

							$presence   = $xml->createElement( "presence");
							$presenceText = $xml->createTextNode( '2');
							$presence->appendChild( $presenceText);

							$defaultvalue   = $xml->createElement( "defaultvalue");
							$defaultvalueText = $xml->createTextNode('');
							$defaultvalue->appendChild( $defaultvalueText);

							$sequence   = $xml->createElement( "sequence");
							$sequenceText = $xml->createTextNode( '0');
							$sequence->appendChild( $sequenceText);

							$maximumlength   = $xml->createElement( "maximumlength");
							$maximumlengthText = $xml->createTextNode( '100');
							$maximumlength->appendChild( $maximumlengthText);

							$typeofdata   = $xml->createElement( "typeofdata");
							$typeofdataText = $xml->createTextNode( 'V~M');
							$typeofdata->appendChild( $typeofdataText);

							$quickcreate   = $xml->createElement( "quickcreate");
							$quickcreateText = $xml->createTextNode( '1');
							$quickcreate->appendChild( $quickcreateText);

							$quickcreatesequence   = $xml->createElement( "quickcreatesequence");
							$quickcreatesequenceText = $xml->createTextNode( '');
							$quickcreatesequence->appendChild( $quickcreatesequenceText);

							$displaytype   = $xml->createElement( "displaytype");
							$displaytypeText = $xml->createTextNode( '1');
							$displaytype->appendChild( $displaytypeText);

							$info_type   = $xml->createElement( "info_type");
							$info_typeText = $xml->createTextNode( 'BAS');
							$info_type->appendChild( $info_typeText);

							$helpinfo   = $xml->createElement( "helpinfo");
							$helpinfoText = $xml->createCDATASection( '');
							$helpinfo->appendChild( $helpinfoText);

							$masseditable   = $xml->createElement( "masseditable");
							$masseditableText = $xml->createTextNode( '1');
							$masseditable->appendChild( $masseditableText);

							if($this -> flag == 0 && $this -> tks_entity == '')
							{
								$entityidentifier   = $xml->createElement( "entityidentifier");
									$entityidfield   = $xml->createElement( "entityidfield");
									$entityidfieldText = $xml->createTextNode( strtolower( $this -> modulename).'id' );
									$entityidfield->appendChild( $entityidfieldText);

									$entityidcolumn   = $xml->createElement( "entityidcolumn");
									$entityidcolumnText = $xml->createTextNode( strtolower( $this -> modulename).'id' );
									$entityidcolumn->appendChild( $entityidcolumnText);
								$entityidentifier->appendChild( $entityidfield);
								$entityidentifier->appendChild( $entityidcolumn);
							}

						$field->appendChild( $fieldname);
						$field->appendChild( $uitype);
						$field->appendChild( $columnname);
						$field->appendChild( $tablename1);
						$field->appendChild( $generatedtype);
						$field->appendChild( $fieldlabel);
						$field->appendChild( $readonly);
						$field->appendChild( $presence);
						$field->appendChild( $defaultvalue);
						$field->appendChild( $sequence);
						$field->appendChild( $maximumlength);
						$field->appendChild( $typeofdata);
						$field->appendChild( $quickcreate);
						$field->appendChild( $quickcreatesequence);
						$field->appendChild( $displaytype);
						$field->appendChild( $info_type);
						$field->appendChild( $helpinfo);
						$field->appendChild( $masseditable);

						if($this -> flag == 0 && $this -> tks_entity == '')
						{
							$this -> flag = 1;
							$field->appendChild( $entityidentifier);
						}

					$block_fields->appendChild( $field);
					}//end if

					if($mfield[$j]['deleted'] == 'true')
					{
						continue;
					}

					$s = $k+1;
					$k++;

					$field   = $xml->createElement( "field");
					$m_field = $mfield[$j];

							$fieldname   = $xml->createElement( "fieldname");
							$fieldnameText = $xml->createTextNode( $m_field['fieldname']);
							$fieldname->appendChild( $fieldnameText);

							$uitype   = $xml->createElement( "uitype");
							$uitypeText = $xml->createTextNode( $m_field['uitype']);
							$uitype->appendChild( $uitypeText);

							$columnname   = $xml->createElement( "columnname");
							$columnnameText = $xml->createTextNode( $m_field['columnname']);
							$columnname->appendChild( $columnnameText);

							$tablename1   = $xml->createElement( "tablename");
							$tablename1Text = $xml->createTextNode( $m_field['tablename']);
							$tablename1->appendChild( $tablename1Text);

							$generatedtype   = $xml->createElement( "generatedtype");
							$generatedtypeText = $xml->createTextNode( $m_field['generatedtype']);
							$generatedtype->appendChild( $generatedtypeText);

							$fieldlabel   = $xml->createElement( "fieldlabel");
							$fieldlabelText = $xml->createTextNode( $m_field['fieldlabel']);
							$fieldlabel->appendChild( $fieldlabelText);

							$readonly   = $xml->createElement( "readonly");
							$readonlyText = $xml->createTextNode( $m_field['readonly']);
							$readonly->appendChild( $readonlyText);

							$presence   = $xml->createElement( "presence");
							$presenceText = $xml->createTextNode( $m_field['presence']);
							$presence->appendChild( $presenceText);

							$defaultvalue   = $xml->createElement( "defaultvalue");
							$defaultvalueText = $xml->createTextNode( $m_field['defaultvalue']);
							$defaultvalue->appendChild( $defaultvalueText);

							$sequence   = $xml->createElement( "sequence");
							$sequenceText = $xml->createTextNode( $m_field['sequence']);
							$sequence->appendChild( $sequenceText);

							$maximumlength   = $xml->createElement( "maximumlength");
							$maximumlengthText = $xml->createTextNode( $m_field['maximumlength']);
							$maximumlength->appendChild( $maximumlengthText);

							$typeofdata   = $xml->createElement( "typeofdata");
							$typeofdataText = $xml->createTextNode( $m_field['typeofdata']);
							$typeofdata->appendChild( $typeofdataText);

							$quickcreate   = $xml->createElement( "quickcreate");
							$quickcreateText = $xml->createTextNode( $m_field['quickcreate'] );
							$quickcreate->appendChild( $quickcreateText);

							$quickcreatesequence   = $xml->createElement( "quickcreatesequence");
							$quickcreatesequenceText = $xml->createTextNode( $m_field['quickcreatesequence']);
							$quickcreatesequence->appendChild( $quickcreatesequenceText);

							$displaytype   = $xml->createElement( "displaytype");
							$displaytypeText = $xml->createTextNode( $m_field['displaytype']);
							$displaytype->appendChild( $displaytypeText);

							$info_type   = $xml->createElement( "info_type");
							$info_typeText = $xml->createTextNode( $m_field['info_type']);
							$info_type->appendChild( $info_typeText);

							$helpinfo   = $xml->createElement( "helpinfo");
							$helpinfoText = $xml->createCDATASection( '');
							$helpinfo->appendChild( $helpinfoText);

							$masseditable   = $xml->createElement( "masseditable");
							$masseditableText = $xml->createTextNode( $m_field['masseditable']);
							$masseditable->appendChild( $masseditableText);

							if($this -> flag == 0 && $m_field['uitype'] != '10' && $m_field['tksrequired'] == 'true' && $m_field['tksfilterfield'] == 'true')
							{
								$entity = explode( ':',$request ->get ( 'tks_entity'));
								$m_identifier = $mblocks[$entity[0] - 1]['tks_fields'][$entity[1]];
								if($m_identifier['fieldname'] == $m_field['fieldname'])
								{
										$entityidentifier   = $xml->createElement( "entityidentifier");
										$entityidfield   = $xml->createElement( "entityidfield");
										$entityidfieldText = $xml->createTextNode( strtolower( $this -> modulename).'id' );
										$entityidfield->appendChild( $entityidfieldText);

										$entityidcolumn   = $xml->createElement( "entityidcolumn");
										$entityidcolumnText = $xml->createTextNode( strtolower( $this -> modulename).'id' );
										$entityidcolumn->appendChild( $entityidcolumnText);
									$entityidentifier->appendChild( $entityidfield);
									$entityidentifier->appendChild( $entityidcolumn);
								}
							}

						$field->appendChild( $fieldname);
						$field->appendChild( $uitype);
						$field->appendChild( $columnname);
						$field->appendChild( $tablename1);
						$field->appendChild( $generatedtype);
						$field->appendChild( $fieldlabel);
						$field->appendChild( $readonly);
						$field->appendChild( $presence);
						$field->appendChild( $defaultvalue);
						$field->appendChild( $sequence);
						$field->appendChild( $maximumlength);
						$field->appendChild( $typeofdata);
						$field->appendChild( $quickcreate);
						$field->appendChild( $quickcreatesequence);
						$field->appendChild( $displaytype);
						$field->appendChild( $info_type);
						$field->appendChild( $helpinfo);
						$field->appendChild( $masseditable);
						if($this -> flag == 0 && $m_field['uitype'] != '10' && $m_field['tksrequired'] == 'true' && $m_field['tksfilterfield'] == 'true' )
						{
							$entity = explode( ':',$request ->get ( 'tks_entity'));
							$m_identifier = $mblocks[$entity[0] - 1]['tks_fields'][$entity[1]];
							if($m_identifier['fieldname'] == $m_field['fieldname'])
							{
								$this -> flag = 1;
								$field->appendChild( $entityidentifier);
							}
						}
						//picklist fields
								$uitype = $m_field['uitype'];
								if( $uitype == '15' || $uitype == '33'){
									$picklistvalues1 = preg_split('/,/', $m_field['pickArray']);
									//$picklistvalues1 = split( ",", $m_field['pickArray']);

									$picklistvalues   = $xml->createElement( "picklistvalues");
										foreach( $picklistvalues1 as $picklistvalue1) {


											$picklistvalue   = $xml->createElement( "picklistvalue");
											$picklistvalueText = $xml->createTextNode( $picklistvalue1);
											$picklistvalue->appendChild( $picklistvalueText);
											$picklistvalues->appendChild( $picklistvalue);
										}
										$field->appendChild( $picklistvalues);
									}

						//relatedmodule fields
								if( $uitype == '10'){
									$relatedmodules1 = $m_field['relatedmodules'];

									$relatedmodules   = $xml->createElement( "relatedmodules");
										if(is_array($relatedmodules1))
										{
											foreach( $relatedmodules1 as $relatedmodule1) {
												/*START -- Enter the modulename in to temp_rel array*/
												$temp_rel[] = $relatedmodule1;
												/*END -- Enter the modulename in to temp_rel array*/

												if( $relatedmodule1 !=''){
													$relatedmodule   = $xml->createElement( "relatedmodule");
													$relatedmoduleText = $xml->createTextNode( $relatedmodule1);
													$relatedmodule->appendChild( $relatedmoduleText);
													$relatedmodules->appendChild( $relatedmodule);
												}
											}
										}
										else
										{
											if( $relatedmodules1 !=''){
													$relatedmodule   = $xml->createElement( "relatedmodule");
													$relatedmoduleText = $xml->createTextNode( $relatedmodules1);
													$relatedmodule->appendChild( $relatedmoduleText);
													$relatedmodules->appendChild( $relatedmodule);
												}
										}

									$field->appendChild( $relatedmodules);
									}
					$block_fields->appendChild( $field);

							//mandatory fields : assigned_user_id, CreatedTime, ModifiedTime
									if( $i == 0 && $j == sizeof( $mfield)-1)
									{
									 $s = $m_field['sequence'];
									 $a = $s+2;

									$field_assigned_user_id   = $xml->createElement( "field");

										$fieldname   = $xml->createElement( "fieldname");
										$fieldnameText = $xml->createTextNode( 'assigned_user_id');
										$fieldname->appendChild( $fieldnameText);

										$uitype   = $xml->createElement( "uitype");
										$uitypeText = $xml->createTextNode( '53');
										$uitype->appendChild( $uitypeText);

										$columnname   = $xml->createElement( "columnname");
										$columnnameText = $xml->createTextNode( 'smownerid');
										$columnname->appendChild( $columnnameText);

										$tablename1   = $xml->createElement( "tablename");
										$tablename1Text = $xml->createTextNode( 'vtiger_crmentity');
										$tablename1->appendChild( $tablename1Text);


										$generatedtype   = $xml->createElement( "generatedtype");
										$generatedtypeText = $xml->createTextNode( '1');
										$generatedtype->appendChild( $generatedtypeText);

										$fieldlabel   = $xml->createElement( "fieldlabel");
										$fieldlabelText = $xml->createTextNode( 'Assigned To');
										$fieldlabel->appendChild( $fieldlabelText);

										$readonly   = $xml->createElement( "readonly");
										$readonlyText = $xml->createTextNode( '1');
										$readonly->appendChild( $readonlyText);

										$presence   = $xml->createElement( "presence");
										$presenceText = $xml->createTextNode( '2');
										$presence->appendChild( $presenceText);

										$defaultvalue   = $xml->createElement( "defaultvalue");
										$defaultvalueText = $xml->createTextNode( '');
										$defaultvalue->appendChild( $defaultvalueText);

										$sequence   = $xml->createElement( "sequence");
										$sequenceText = $xml->createTextNode( $a++);
										$sequence->appendChild( $sequenceText);

										$maximumlength   = $xml->createElement( "maximumlength");
										$maximumlengthText = $xml->createTextNode( '100');
										$maximumlength->appendChild( $maximumlengthText);

										$typeofdata   = $xml->createElement( "typeofdata");
										$typeofdataText = $xml->createTextNode( 'V~M');
										$typeofdata->appendChild( $typeofdataText);

										$quickcreate   = $xml->createElement( "quickcreate");
										$quickcreateText = $xml->createTextNode( '1');
										$quickcreate->appendChild( $quickcreateText);

										$quickcreatesequence   = $xml->createElement( "quickcreatesequence");
										$quickcreatesequenceText = $xml->createTextNode( '');
										$quickcreatesequence->appendChild( $quickcreatesequenceText);

										$displaytype   = $xml->createElement( "displaytype");
										$displaytypeText = $xml->createTextNode( '1');
										$displaytype->appendChild( $displaytypeText);

										$info_type   = $xml->createElement( "info_type");
										$info_typeText = $xml->createTextNode( 'BAS');
										$info_type->appendChild( $info_typeText);

										$masseditable   = $xml->createElement( "masseditable");
										$masseditableText = $xml->createTextNode( '1');
										$masseditable->appendChild( $masseditableText);

								$field_assigned_user_id->appendChild( $fieldname);
								$field_assigned_user_id->appendChild( $uitype);
								$field_assigned_user_id->appendChild( $columnname);
								$field_assigned_user_id->appendChild( $tablename1);
								$field_assigned_user_id->appendChild( $generatedtype);
								$field_assigned_user_id->appendChild( $fieldlabel);
								$field_assigned_user_id->appendChild( $readonly);
								$field_assigned_user_id->appendChild( $presence);
								$field_assigned_user_id->appendChild( $defaultvalue);
								$field_assigned_user_id->appendChild( $sequence);
								$field_assigned_user_id->appendChild( $maximumlength);
								$field_assigned_user_id->appendChild( $typeofdata);
								$field_assigned_user_id->appendChild( $quickcreate);
								$field_assigned_user_id->appendChild( $quickcreatesequence);
								$field_assigned_user_id->appendChild( $displaytype);
								$field_assigned_user_id->appendChild( $info_type);
								$field_assigned_user_id->appendChild( $masseditable);

								$field_CreatedTime   = $xml->createElement( "field");

										$fieldname   = $xml->createElement( "fieldname");
										$fieldnameText = $xml->createTextNode( 'createdtime');
										$fieldname->appendChild( $fieldnameText);

										$uitype   = $xml->createElement( "uitype");
										$uitypeText = $xml->createTextNode( '70');
										$uitype->appendChild( $uitypeText);

										$columnname   = $xml->createElement( "columnname");
										$columnnameText = $xml->createTextNode( 'createdtime');
										$columnname->appendChild( $columnnameText);

										$tablename1   = $xml->createElement( "tablename");
										$tablename1Text = $xml->createTextNode( 'vtiger_crmentity');
										$tablename1->appendChild( $tablename1Text);

										$generatedtype   = $xml->createElement( "generatedtype");
										$generatedtypeText = $xml->createTextNode( '1');
										$generatedtype->appendChild( $generatedtypeText);

										$fieldlabel   = $xml->createElement( "fieldlabel");
										$fieldlabelText = $xml->createTextNode( 'Created Time');
										$fieldlabel->appendChild( $fieldlabelText);

										$readonly   = $xml->createElement( "readonly");
										$readonlyText = $xml->createTextNode( '1');
										$readonly->appendChild( $readonlyText);

										$presence   = $xml->createElement( "presence");
										$presenceText = $xml->createTextNode( '2');
										$presence->appendChild( $presenceText);

										$defaultvalue   = $xml->createElement( "defaultvalue");
										$defaultvalueText = $xml->createTextNode( '');
										$defaultvalue->appendChild( $defaultvalueText);

										$sequence   = $xml->createElement( "sequence");
										$sequenceText = $xml->createTextNode( $a++);
										$sequence->appendChild( $sequenceText);

										$maximumlength   = $xml->createElement( "maximumlength");
										$maximumlengthText = $xml->createTextNode( '100');
										$maximumlength->appendChild( $maximumlengthText);

										$typeofdata   = $xml->createElement( "typeofdata");
										$typeofdataText = $xml->createTextNode( 'T~O');
										$typeofdata->appendChild( $typeofdataText);

										$quickcreate   = $xml->createElement( "quickcreate");
										$quickcreateText = $xml->createTextNode( '1');
										$quickcreate->appendChild( $quickcreateText);

										$quickcreatesequence   = $xml->createElement( "quickcreatesequence");
										$quickcreatesequenceText = $xml->createTextNode( '');
										$quickcreatesequence->appendChild( $quickcreatesequenceText);

										$displaytype   = $xml->createElement( "displaytype");
										$displaytypeText = $xml->createTextNode( '2');
										$displaytype->appendChild( $displaytypeText);

										$info_type   = $xml->createElement( "info_type");
										$info_typeText = $xml->createTextNode( 'BAS');
										$info_type->appendChild( $info_typeText);

										$masseditable   = $xml->createElement( "masseditable");
										$masseditableText = $xml->createTextNode( '1');
										$masseditable->appendChild( $masseditableText);

								$field_CreatedTime->appendChild( $fieldname);
								$field_CreatedTime->appendChild( $uitype);
								$field_CreatedTime->appendChild( $columnname);
								$field_CreatedTime->appendChild( $tablename1);
								$field_CreatedTime->appendChild( $generatedtype);
								$field_CreatedTime->appendChild( $fieldlabel);
								$field_CreatedTime->appendChild( $readonly);
								$field_CreatedTime->appendChild( $presence);
								$field_CreatedTime->appendChild( $defaultvalue);
								$field_CreatedTime->appendChild( $sequence);
								$field_CreatedTime->appendChild( $maximumlength);
								$field_CreatedTime->appendChild( $typeofdata);
								$field_CreatedTime->appendChild( $quickcreate);
								$field_CreatedTime->appendChild( $quickcreatesequence);
								$field_CreatedTime->appendChild( $displaytype);
								$field_CreatedTime->appendChild( $info_type);
								$field_CreatedTime->appendChild( $masseditable);

								$field_ModifiedTime   = $xml->createElement( "field");

										$fieldname   = $xml->createElement( "fieldname");
										$fieldnameText = $xml->createTextNode( 'modifiedtime');
										$fieldname->appendChild( $fieldnameText);

										$uitype   = $xml->createElement( "uitype");
										$uitypeText = $xml->createTextNode( '70');
										$uitype->appendChild( $uitypeText);

										$columnname   = $xml->createElement( "columnname");
										$columnnameText = $xml->createTextNode( 'modifiedtime');
										$columnname->appendChild( $columnnameText);

										$tablename1   = $xml->createElement( "tablename");
										$tablename1Text = $xml->createTextNode( 'vtiger_crmentity');
										$tablename1->appendChild( $tablename1Text);

										$generatedtype   = $xml->createElement( "generatedtype");
										$generatedtypeText = $xml->createTextNode( '1');
										$generatedtype->appendChild( $generatedtypeText);

										$fieldlabel   = $xml->createElement( "fieldlabel");
										$fieldlabelText = $xml->createTextNode( 'Modified Time');
										$fieldlabel->appendChild( $fieldlabelText);

										$readonly   = $xml->createElement( "readonly");
										$readonlyText = $xml->createTextNode( '1');
										$readonly->appendChild( $readonlyText);

										$presence   = $xml->createElement( "presence");
										$presenceText = $xml->createTextNode( '2');
										$presence->appendChild( $presenceText);

										$defaultvalue   = $xml->createElement( "defaultvalue");
										$defaultvalueText = $xml->createTextNode( '');
										$defaultvalue->appendChild( $defaultvalueText);

										$sequence   = $xml->createElement( "sequence");
										$sequenceText = $xml->createTextNode( $a++);
										$sequence->appendChild( $sequenceText);

										$maximumlength   = $xml->createElement( "maximumlength");
										$maximumlengthText = $xml->createTextNode( '100');
										$maximumlength->appendChild( $maximumlengthText);

										$typeofdata   = $xml->createElement( "typeofdata");
										$typeofdataText = $xml->createTextNode( 'T~O');
										$typeofdata->appendChild( $typeofdataText);

										$quickcreate   = $xml->createElement( "quickcreate");
										$quickcreateText = $xml->createTextNode( '1');
										$quickcreate->appendChild( $quickcreateText);

										$quickcreatesequence   = $xml->createElement( "quickcreatesequence");
										$quickcreatesequenceText = $xml->createTextNode( '');
										$quickcreatesequence->appendChild( $quickcreatesequenceText);

										$displaytype   = $xml->createElement( "displaytype");
										$displaytypeText = $xml->createTextNode( '2');
										$displaytype->appendChild( $displaytypeText);

										$info_type   = $xml->createElement( "info_type");
										$info_typeText = $xml->createTextNode( 'BAS');
										$info_type->appendChild( $info_typeText);

										$masseditable   = $xml->createElement( "masseditable");
										$masseditableText = $xml->createTextNode( '1');
										$masseditable->appendChild( $masseditableText);

								$field_ModifiedTime->appendChild( $fieldname);
								$field_ModifiedTime->appendChild( $uitype);
								$field_ModifiedTime->appendChild( $columnname);
								$field_ModifiedTime->appendChild( $tablename1);
								$field_ModifiedTime->appendChild( $generatedtype);
								$field_ModifiedTime->appendChild( $fieldlabel);
								$field_ModifiedTime->appendChild( $readonly);
								$field_ModifiedTime->appendChild( $presence);
								$field_ModifiedTime->appendChild( $defaultvalue);
								$field_ModifiedTime->appendChild( $sequence);
								$field_ModifiedTime->appendChild( $maximumlength);
								$field_ModifiedTime->appendChild( $typeofdata);
								$field_ModifiedTime->appendChild( $quickcreate);
								$field_ModifiedTime->appendChild( $quickcreatesequence);
								$field_ModifiedTime->appendChild( $displaytype);
								$field_ModifiedTime->appendChild( $info_type);
								$field_ModifiedTime->appendChild( $masseditable);

							$block_fields->appendChild( $field_assigned_user_id);
							$block_fields->appendChild( $field_CreatedTime);
							$block_fields->appendChild( $field_ModifiedTime);
						}

				}
				$block->appendChild( $block_label);
				$block->appendChild( $block_fields);

			$blocks->appendChild( $block);
		}

		$customviews   = $xml->createElement( "customviews");
			 $customview   = $xml->createElement( "customview");
				 $viewname   = $xml->createElement( "viewname");
				 $viewnameText = $xml->createTextNode( 'All');
				 $viewname->appendChild( $viewnameText);

				 $setdefault   = $xml->createElement( "setdefault");
				 $setdefaultText = $xml->createTextNode( 'false');
				 $setdefault->appendChild( $setdefaultText);

				 $setmetrics   = $xml->createElement( "setmetrics");
				 $setmetricsText = $xml->createTextNode( 'false');
				 $setmetrics->appendChild( $setmetricsText);

				 $fields   = $xml->createElement( "fields");
					$field   = $xml->createElement( "field");
						$fieldname   = $xml->createElement( "fieldname");
						$fieldnameText = $xml->createTextNode( strtolower( $this -> modulename).'no');
						$fieldname->appendChild( $fieldnameText);

						$columnindex   = $xml->createElement( "columnindex");
						$columnindexText = $xml->createTextNode( '1');
						$columnindex->appendChild( $columnindexText);

					$field->appendChild( $fieldname);
					$field->appendChild( $columnindex);
					 $fields->appendChild( $field);

						 $k = 2;
					 for( $i=0; $i < sizeof( $mblocks) ; $i++)
					 {
					 	if($mblocks[$i]['deleted'] == 'true')
							continue;
					 	$mfield 	= $mblocks[$i]['tks_fields'];
						for( $j=0; $j<sizeof( $mfield) && $j < 10 ;$j++)
						{
							if($mfield[$j]['deleted'] == 'true')
								continue;

							if( $mfield[$j]['tksfilterfield']=='true'){
								$field1   = $xml->createElement( "field");
								$fieldname   = $xml->createElement( "fieldname");
								$fieldnameText = $xml->createTextNode( $this -> getFieldName( $mfield[$j]['tkslabel']));
								$fieldname->appendChild( $fieldnameText);

								$columnindex   = $xml->createElement( "columnindex");
								$columnindexText = $xml->createTextNode( $k++);
								$columnindex->appendChild( $columnindexText);

								$field1->appendChild( $fieldname);
								$field1->appendChild( $columnindex);
								$fields->appendChild( $field1);
							}
						}
					 }

					 $field2   = $xml->createElement( "field");
						$fieldname   = $xml->createElement( "fieldname");
						$fieldnameText = $xml->createTextNode( 'assigned_user_id');
						$fieldname->appendChild( $fieldnameText);

						$columnindex   = $xml->createElement( "columnindex");
						$columnindexText = $xml->createTextNode( $k++);
						$columnindex->appendChild( $columnindexText);

					$field2->appendChild( $fieldname);
					$field2->appendChild( $columnindex);
					$fields->appendChild( $field2);

			 $customview->appendChild( $viewname);
			 $customview->appendChild( $setdefault);
			 $customview->appendChild( $setmetrics);
			 $customview->appendChild( $fields);
		 $customviews->appendChild( $customview);

			$sharingaccess   = $xml->createElement( "sharingaccess");
				$default   = $xml->createElement( "default");
				$defaultText = $xml->createTextNode( 'private');
				$default->appendChild( $defaultText);
			$sharingaccess->appendChild( $default);

			$actions   = $xml->createElement( "actions");
				$action1   = $xml->createElement( "action");
					$import   = $xml->createElement( "name");
					$importText = $xml->createCDATASection( 'Import');
					$import->appendChild( $importText);

					$status   = $xml->createElement( "status");
					$statusText = $xml->createTextNode( 'enabled');
					$status->appendChild( $statusText);
				$action1->appendChild( $import);
				$action1->appendChild( $status);

				$action2   = $xml->createElement( "action");
					$export   = $xml->createElement( "name");
					$exportText = $xml->createCDATASection( 'Export');
					$export->appendChild( $exportText);

					$status   = $xml->createElement( "status");
					$statusText = $xml->createTextNode( 'enabled');
					$status->appendChild( $statusText);
				$action2->appendChild( $export);
				$action2->appendChild( $status);

				$action3   = $xml->createElement( "action");
					$merge   = $xml->createElement( "name");
					$mergeText = $xml->createCDATASection( 'Merge');
					$merge->appendChild( $mergeText);

					$status   = $xml->createElement( "status");
					$statusText = $xml->createTextNode( 'enabled');
					$status->appendChild( $statusText);
				$action3->appendChild( $merge);
				$action3->appendChild( $status);

			$actions->appendChild( $action1);
			$actions->appendChild( $action2);
			$actions->appendChild( $action3);

			// Relatedlists
			$mod_list=$this -> moduleData['tks_relatedlist'];
			$relatedlists   = $xml->createElement( "relatedlists");
				for( $m = 0; $m < sizeof( $mod_list); $m++ )
				{
					$relmethod ='get_related_list';
					if($mod_list[$m]['module'] == 'Documents')
					{
						$relmethod ='get_attachments';
					}

					$relatedlist   = $xml->createElement( "relatedlist");
							$function   = $xml->createElement( "function");
							$functionText = $xml->createTextNode( $relmethod );
							$function->appendChild( $functionText);

							$label   = $xml->createElement( "label");
							$labelText = $xml->createTextNode( $mod_list[$m]['module']);
							$label->appendChild( $labelText);

							$sequence   = $xml->createElement( "sequence");
							$sequenceText = $xml->createTextNode( $m+1 );
							$sequence->appendChild( $sequenceText);

							$presence   = $xml->createElement( "presence");
							$presenceText = $xml->createTextNode( '0');
							$presence->appendChild( $presenceText);

						$relatedlist->appendChild( $function);
						$relatedlist->appendChild( $label);
						$relatedlist->appendChild( $sequence);
						$relatedlist->appendChild( $presence);


					 if( $mod_list[$m]['add'] == 1 && $mod_list[$m]['sel'] == 1)
					 {
						$actions_r   = $xml->createElement( "actions");
								$action   = $xml->createElement( "action");
								$actionText = $xml->createTextNode( 'ADD');
								$action->appendChild( $actionText);

								$action1   = $xml->createElement( "action");
								$action1Text = $xml->createTextNode( 'SELECT');
								$action1->appendChild( $action1Text);

						$actions_r->appendChild( $action);
						$actions_r->appendChild( $action1);
					 }
					 elseif( $mod_list[$m]['add'] == 1){
						 $actions_r   = $xml->createElement( "actions");
								$action   = $xml->createElement( "action");
								$actionText = $xml->createTextNode( 'ADD');
								$action->appendChild( $actionText);

								$action1   = $xml->createElement( "action");
								$action1Text = $xml->createTextNode( 'NULL');
								$action1->appendChild( $action1Text);

						$actions_r->appendChild( $action);
						$actions_r->appendChild( $action1);
					 }
					 elseif( $mod_list[$m]['sel'] == 1){
						 $actions_r   = $xml->createElement( "actions");
								$action   = $xml->createElement( "action");
								$actionText = $xml->createTextNode( 'SELECT');
								$action->appendChild( $actionText);

								$action1   = $xml->createElement( "action");
								$action1Text = $xml->createTextNode( 'NULL');
								$action1->appendChild( $action1Text);

						$actions_r->appendChild( $action);
						$actions_r->appendChild( $action1);
					 }
					 else{
						$actions_r   = $xml->createElement( "actions");

								$action1   = $xml->createElement( "action");
								$action1Text = $xml->createTextNode( 'NULL');
								$action1->appendChild( $action1Text);

						$actions_r->appendChild( $action1);
					 }

					 $relatedlist->appendChild( $actions_r);

							$relatedmodule   = $xml->createElement( "relatedmodule");
							$relatedmoduleText = $xml->createTextNode( $mod_list[$m]['module']);
							$relatedmodule->appendChild( $relatedmoduleText);
							$relatedlist->appendChild( $relatedmodule);

					$relatedlists->appendChild( $relatedlist);
				}

			//crons
			$crons   = $xml->createElement( "crons");
			$cronsText = $xml->createTextNode( '');
			$crons->appendChild( $cronsText);

			$module->appendChild( $blocks);
			$module->appendChild( $customviews);
			$module->appendChild( $sharingaccess);
			$module->appendChild( $actions);
			if( sizeof( $mod_list) > 0	)
				$module->appendChild( $relatedlists);
			$module->appendChild( $crons);

			$xml->formatOutput = true;
			$xml->save( $ManifestFilePath);


			//Creating Zip file of module
			if( $zipfilename == '')  $zipfilename = "$modulename.zip";
				$zipfilename = $this -> export_tmpdir."/$zipfilename";

			$zip = new Vtiger_ZipMB( $zipfilename);
			$zip->addFile( $ManifestFilePath, "manifest.xml");
			$zip->copyDirectoryFromDisk( 'test/vtlib/modules/'.$modulename.'/ModuleFile', 'modules/'.$modulename);
			$zip->copyDirectoryFromDisk( 'test/vtlib/modules/'.$modulename.'/languages', 'languages');
			$zip->save();

			//To rename zlanguage folder to language
			$tks_zip = new ZipArchive;
			$res = $tks_zip->open( "$zipfilename", ZipArchive::CREATE );
			if ( $res === TRUE)
			{
				//To replace modulename and tablenames
				$fileContents 	= $tks_zip->getFromName( 'modules/'.$modulename.'/'.$modulename.'.php');
				$replaced 		= str_replace( 'ModuleClass', $modulename, $fileContents);
				$final_content 	= str_replace( '##tablename##', strtolower( $modulename), $replaced);

				//Entity Identifier Field
			  	$mblocks 	= $this -> moduleData['tks_blocks'];

				/*TECHNOKRAFTS :- Resolve Issue for pop-up field*/
				$entityIdentifierLabel = $modulename.' No';
				$entityIdentifierField = strtolower($modulename).'no';

				$final_content	= str_replace( '##ENTITYIDENTIFIERLABEL##', $entityIdentifierLabel, $final_content);
				$final_content = str_replace( '##ENTITYIDENTIFIERFIELD##', $entityIdentifierField, $final_content);
				/*TECHNOKRAFTS :- Resolve Issue for pop-up field*/


				if( $request ->get ( 'tks_entity') != '')
				{
					$entity = explode( ':',$request ->get ( 'tks_entity'));
					$m_identifier = $mblocks[$entity[0] - 1]['tks_fields'][$entity[1]];
					$final_content	= str_replace( '##label##', $m_identifier['fieldlabel'], $final_content);
					$final_content = str_replace( '##labelfield##', $m_identifier['fieldname'], $final_content);
				}
				else
				{
					$final_content	= str_replace( '##label##', $entityIdentifierLabel, $final_content);
					$final_content = str_replace( '##labelfield##', $entityIdentifierField, $final_content);
					$final_content	= str_replace( '/*FIELDSTART*/', '/*', $final_content);
					$final_content	= str_replace( '/*FIELDEND*/', '*/', $final_content);

				}
				  $lang_fileContents 	= $tks_zip->getFromName( 'languages/en_us/'.$modulename.'.php');
				  $lang_replaced 		= str_replace( '##ModuleName##', $modulename, $lang_fileContents);
				  $lang_replaced 		= str_replace( '##moduleLable##', $this -> moduleData['tks_modname'], $lang_replaced);

				  /*START -- Logic to add the module names in the language file*/
				  $rel_arr = '';
				  if(  isset ( $temp_rel) && is_array( $temp_rel ) )
					  $rel_arr = $this ->  getlangStr( $temp_rel );
				  $lang_replaced = str_replace( '\'#####\'', $rel_arr , $lang_replaced);
				 /*END -- Logic to add the module names in the language file*/

				  //To replace language variables
				  $tks_zip->deleteName( 'languages/en_us/'.$modulename.'.php');
				  $tks_zip->addFromString( 'languages/en_us/'.$modulename.'.php',  $lang_replaced);

				  $tks_zip->deleteName( 'modules/'.$modulename.'/'.$modulename.'.php');
				  $tks_zip->addFromString( 'modules/'.$modulename.'/'.$modulename.'.php', $final_content);

				  $tks_zip->close();
			  }
		//unlink manifest file
		unlink( $ManifestFilePath);
		$log->debug("Exiting export(request array()) method....");
	 }
}