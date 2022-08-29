<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModuleBuilder_tksGetInfo_Action extends Settings_Vtiger_Index_Action 
{
    public function process(Vtiger_Request $request) {
        
        global $log, $adb;
        $module 		=	$request->get('srcModule');
        $tabid  		=	$request->get('tabid');
        
        $blkquery 		=	"SELECT * 
                    		FROM vtiger_tks_module
                    		INNER JOIN vtiger_tks_blocks ON vtiger_tks_blocks.tabid = vtiger_tks_module.tabid
                    		WHERE vtiger_tks_module.name = ? and vtiger_tks_module.tabid = ?";

        $blkresult      =	$adb->pquery($blkquery,array($module, $tabid ));
        $blkrow         =	$adb->num_rows($blkresult);
        
        $label          =	$adb->query_result($blkresult,0,'tablabel');
        $parent         =	$adb->query_result($blkresult,0,'parent');
        
        $blockinfo		=	array();
        
        $fldquery		=	"SELECT * 
                    		FROM vtiger_tks_module
                    		INNER JOIN vtiger_tks_field ON vtiger_tks_field.tabid = vtiger_tks_module.tabid
                    		WHERE vtiger_tks_module.name = ? and vtiger_tks_module.tabid = ?";

        $fldresult      =	$adb->pquery($fldquery,array($module, $tabid ));
        $fldrow         =	$adb->num_rows($fldresult);
        
        $fieldinfo = array();
        
        $token = $request->get('token');
        $temp_array = array();
        if($_SESSION['tks_module_builder'][$token] == null)
        {
                $temp_array['tks_modname'] 				=	$module;
                $temp_array['tks_label'] 				=	$label;
                $temp_array['tks_parent'] 				=	$parent;
                $_SESSION['tks_module_builder'][$token]	=	$temp_array;
        }
        
        for($i=0; $i < $blkrow; $i++)
        {
            $blockinfo['blockno'][$i]    	=	$adb->query_result($blkresult,$i,'sequence');
            $blockinfo['blocklabel'][$i]	=	$adb->query_result($blkresult,$i,'blocklabel');
            $a .= $i.',';
            $blockinfo['sequencelist'][$i]	=	'['.rtrim($a,", ").']';
            
            $blockid    	=	$adb->query_result($blkresult,$i,'sequence');
            $blocklabel 	=	$adb->query_result($blkresult,$i,'blocklabel');
            
            $fcsql 			=	"SELECT count( block ) AS fcount
                        		FROM `vtiger_tks_field`
                        		WHERE block = ?
                        		AND tabid = ?";
            
            $fcresult      	=	$adb->pquery($fcsql,array($blockid, $tabid));
            $fcount        	=	$adb->query_result($fcresult,0,'fcount');
            
            $temp_array		=	array( 'name' => $blocklabel, 'block_id' => $blockid, 'deleted' => 'false', 'fieldCount' => $fcount);
            $_SESSION['tks_module_builder'][$token]['blocks'][] = $temp_array;
        }
        
        for($j=0; $j < $fldrow; $j++)
        {
            $fieldinfo['block'][$j]         	=	$adb->query_result($fldresult,$j,'block');
            $fieldinfo['fieldlabel'][$j]    	=	$adb->query_result($fldresult,$j,'fieldlabel');
 
            $defaultvalue                  		=	$adb->query_result($fldresult,$j,'defaultvalue');           
            if($defaultvalue == null)
                $fieldinfo['defaultvalue'][$j]	=	"false";
            else
                $fieldinfo['defaultvalue'][$j]	=	"true";
            
            $mandatory = $adb->query_result($fldresult,$j,'typeofdata');
            if (strpos($mandatory, 'M') !== false) {
                $fieldinfo['mandatory'][$j] 	=	"true";
            }
            else
                $fieldinfo['mandatory'][$j] 	=	"false";
            
            $presence = $adb->query_result($fldresult,$j,'presence');
            if($presence == 0)
                $fieldinfo['presence'][$j] 		=	"false";
            else
                $fieldinfo['presence'][$j] 		=	"true";
            
            $name = $adb->query_result($fldresult,$j,'fieldlabel');
            $name = str_replace(' ', '', $name);
            $fieldinfo['name'][$j] = 'tks_'.$name;
            
            $massedit       = $adb->query_result($fldresult,$j,'masseditable');
            $summaryfield   = $adb->query_result($fldresult,$j,'summaryfield');
            $isfilter       = $adb->query_result($fldresult,$j,'isfilter');
            $quickcreate    = $adb->query_result($fldresult,$j,'quickcreate');
            
            if($massedit == 0)
                $fieldinfo['massedit'][$j] = "false";
            else
                $fieldinfo['massedit'][$j] = "true";

            if($summaryfield == 0)
                $fieldinfo['summaryfield'][$j] = "false";
            else
                $fieldinfo['summaryfield'][$j] = "true";
            
            if($isfilter == 0) 
                $isFilter = "false";
            else
                $isFilter = "true";
            
            if($quickcreate == 0)
                $fieldinfo['quickcreate'][$j] = "false";
            else
               $fieldinfo['quickcreate'][$j] = "true"; 
            
            $uitype = $adb->query_result($fldresult,$j,'uitype');
            if($uitype == 2)
                $fieldinfo['typeofdata'][$j] = "string";
            elseif($uitype == 7)
                $fieldinfo['typeofdata'][$j] = "number";
            elseif($uitype == 9)
                $fieldinfo['typeofdata'][$j] = "percentage";
            elseif($uitype == 71)
                $fieldinfo['typeofdata'][$j] = "currency";
            elseif($uitype == 5)
                $fieldinfo['typeofdata'][$j] = "date";
            elseif($uitype == 13)
                $fieldinfo['typeofdata'][$j] = "email";
            elseif($uitype == 14)
                $fieldinfo['typeofdata'][$j] = "time";
            elseif($uitype == 11)
                $fieldinfo['typeofdata'][$j] = "phone";
            elseif($uitype == 15)
                $fieldinfo['typeofdata'][$j] = "picklist";
            elseif($uitype == 17)
                $fieldinfo['typeofdata'][$j] = "url";
            elseif($uitype == 56)
                $fieldinfo['typeofdata'][$j] = "boolean";
            elseif($uitype == 21)
                $fieldinfo['typeofdata'][$j] = "textarea";
            elseif($uitype == 33)
                $fieldinfo['typeofdata'][$j] = "multipicklist";
            elseif($uitype == 85)
                $fieldinfo['typeofdata'][$j] = "skype";
            elseif($uitype == 1)
                $fieldinfo['typeofdata'][$j] = "integer";
            elseif($uitype == 10)
                $fieldinfo['typeofdata'][$j] = "relate";
            
            $typeofdata    = $adb->query_result($fldresult,$j,'typeofdata');
            if (strpos($typeofdata, 'M') !== false) 
                $isMandatory = "true";
            else
                $isMandatory = "false";

            $block         = $adb->query_result($fldresult,$j,'block');
            $fieldlabel    = $adb->query_result($fldresult,$j,'fieldlabel');
            $type          = $fieldinfo['typeofdata'][$j];
            $fieldlength   = $adb->query_result($fldresult,$j,'maximumlength'); 
            $fieldinfo['isfilter'][$j] = $isFilter;
            $fieldid       = $adb->query_result($fldresult,$j,'fieldid');
            
            $plsql = "SELECT vtiger_tks_picklist.tabid, vtiger_tks_picklist.fieldid, picklistvalue, vtiger_tks_picklist.sequence
                        FROM `vtiger_tks_picklist`
                        INNER JOIN vtiger_tks_field ON vtiger_tks_field.fieldid = vtiger_tks_picklist.fieldid
                        WHERE vtiger_tks_picklist.fieldid = ".$fieldid."
                        AND vtiger_tks_picklist.tabid =".$tabid;
            
            $plres         = $adb->pquery($plsql,array());
            $plrow         = $adb->num_rows($plres); 
            $values = array();
            for($m = 0; $m < $plrow; $m++)
            {
                $values[$m] = $adb->query_result($plres,$m,'picklistvalue');
            }
            $pvalues = implode(',', $values);
            
            $picklistvalues = array();
            if($pvalues != '')
            {
                    $p = explode(',',$pvalues);
                    foreach($p as $key => $value)
                    {
                            $picklistvalues[$value] = $value;
                    }

            }
            else
            {
                    $picklistvalues = '';
            }
            $fieldinfo['picklistvalues'][$j] 	=	$picklistvalues;
            
            $fld['tkslabel']                    =	$fieldlabel;
            $fld['tkslength']                   =	$fieldlength;
            $fld['tksdecimal']                  =	"";
            $fld['tkspicklistvalues']           =	$pvalues;
            $fld['tksrelate']                   =	"";
            $fld['tksrequired']                 =	$isMandatory;
            $fld['tksfilterfield']              =	$isFilter;
            
            $responseData = array(
                        'id'				=> $j, 					'blockid'                   => $block, 			
                        'defaultvalue'		=> 'false', 			'isQuickCreateDisabled'  	=> $isMandatory,
                        'isSummaryField' 	=> 'false',             'isSummaryFieldDisabled'	=> 'false',
                        'label'				=> $fld['tkslabel'],	'mandatory'					=> $isMandatory,
                        'masseditable'		=> 'false',				'name'						=> 'tks_'.str_replace(' ','',$fld['tkslabel']),
                        'presence'			=> 'true',				'quickcreate'				=> $isMandatory,
                        'type'				=> $type,				'tksrequired' 	  			=> $isMandatory,
                        'tksfilterfield' 	=> $isFilter,           'customField'           	=> 'true',
                        'deleted' 			=> 'false',									 
                );
            
            if($picklistvalues != '')
            {
                    $responseData['picklistvalues']	= $picklistvalues;
            }
                                
            foreach( $responseData as $key => $value )
            {
                    $fld[$key] = $value;
            }
            
            $fld['tksrelate']           = 	"";
            $fld['tkspickListValues']   = 	$pvalues;
            $fld['tksdecimal']          = 	"";
            
            $fieldCount = $_SESSION['tks_module_builder'][$token]['blocks'][$block]['fieldCount'];
            $_SESSION['tks_module_builder'][$token]['fields'][$j] = $fld;
            //$_SESSION['tks_module_builder'][$token]['blocks'][$block]['fieldCount'] =  $fieldCount + 1;
            $_SESSION['tks_module_builder'][$token]['fields'][$j]['sequence'] = ($fieldCount == '' ? 0 : $fieldCount);
        }
        
        $result = array("blockinfo"=>$blockinfo,"fieldinfo"=>$fieldinfo);
        
        $response = new Vtiger_Response();
        $response->setResult($result);
        $response->emit();
    }
}