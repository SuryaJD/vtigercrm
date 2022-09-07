<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModuleBuilder_ImportModule_Action extends Settings_Vtiger_Index_Action 
{
    function __construct() {
		parent::__construct();
		$this->exposeMethod('importUserModule');
	}
	
	function checkPermission(Vtiger_Request $request) {
		//Return true as WebUI.php is already checking for module permission
		return true;
	}
    
    function process(Vtiger_Request $request) {
        $mode = $request->getMode();
        if(!empty($mode)) {
                echo $this->invokeExposedMethod($mode, $request);
                return;
        }
    }

    public function importUserModule(Vtiger_Request $request) 
    {
        $importModuleName = $request->get('module_import_name');
        $uploadFile = $request->get('module_import_file');
        //$uploadDir = Settings_ModuleManager_Extension_Model::getUploadDirectory();
        //$uploadFileName = "$uploadDir/$uploadFile";
        //checkFileAccess($uploadFile);
		
        $this->import($uploadFile);
        
        //checkFileAccessForDeletion($uploadFileName);
        //unlink($uploadFileName);
        $result = array('success'=>true, 'importModuleName'=> $importModuleName);
        $response = new Vtiger_Response();
        $response->setResult($result);
        $response->emit();
    }
    
    function __parseManifestFile() {
        $module = $_REQUEST['module_import_name'];
        $source = 'manifest.xml';
        $get = file_get_contents($source);
        $this->_modulexml = new SimpleXMLElement($get);
        //echo "<pre>";print_r($this);exit;
    }
    
    function getModuleNameFromZip($zipfile) {
        if(!$this->checkZip($zipfile)) return null;

            return (string)$this->_modulexml->name;
    }
    
    function getDependentVtigerVersion() {
       return $this->viewer->tpl_vars["VTIGER_VERSION"]->value;
    }
    
    function checkZip($zipfile) {
        $module = $_REQUEST['module_import_name'];
        $zip = new ZipArchive;
        $unzip = $zip->open($zipfile);
        //$zip->extractTo("storage/".$module);
        global $root_directory;
        $path = rtrim($root_directory, "/");
        $zip->extractTo($path);
        
        $filelist = array(
                "manifest.xml" => array
                        (
                                "filename" => "manifest.xml",
                                "compression_method" => 8,
                                "version_needed" => 20,
                                "lastmod_datetime" => 1479905355,
                                "crc-32" => "445a4231",
                                "compressed_size" => 980,
                                "uncompressed_size" => 2354,
                                "extra_field" => "",
                                "contents-startOffset" => 42
                        ),
				
                "modules/$module/$module.php" => array
                        (
                                "file_name" => "modules/$module/$module.php",
                                "compression_method" => 8,
                                "version_needed" => 10,
                                "lastmod_datetime" => 1479361036,
                                "crc-32" => "fb8dd2ab",
                                "compressed_size" => 893,
                                "uncompressed_size" => 2732,
                                "extra_field" => "", 
                                "contents-startOffset" => 43501
                        ),
		
                "languages/en_us/$module.php" => Array
                        (
                                "file_name" => "languages/en_us/$module.php",
                                "compression_method" => 8,
                                "version_needed" => 20,
                                "lastmod_datetime" => 1480505899,
                                "crc-32" => "787218ee",
                                "compressed_size" => 7904,
                                "uncompressed_size" => 25824,
                                "extra_field" => "",
                                "contents-startOffset" => 127695
                        )
        );
		
        //echo "<pre>";print_r($filelist);exit;//echo "<pre>";print_r($filelist);*/
        //$filelist = $unzip->getList();//echo "<pre>";print_r($this);
        $manifestxml_found = false;
        $languagefile_found = false;
        $layoutfile_found = false;
        $vtigerversion_found = false;

        $modulename = null;
        $language_modulename = null;

        foreach($filelist as $filename=>$fileinfo) {
                $matches = Array();
                preg_match('/manifest.xml/', $filename, $matches);
                if(count($matches)) {
                        $manifestxml_found = true;
                        $this->__parseManifestFile();
                        $modulename = $this->_modulexml->name;
                        $isModuleBundle = (string)$this->_modulexml->modulebundle;

                        if($isModuleBundle === 'true' && (!empty($this->_modulexml)) &&
                                        (!empty($this->_modulexml->dependencies)) &&
                                        (!empty($this->_modulexml->dependencies->vtiger_version))) {
                                $languagefile_found = true;
                                break;
                        }
                }
        }
        if($unzip) $zip->close();
        
        return true;
    }
    
    function import($zipfile) {
        $module = $this->getModuleNameFromZip($zipfile);
        if($module != null) { 
            $tabname = $this->_modulexml->name;
            $tablabel= $this->_modulexml->label;
            $parenttab=(string)$this->_modulexml->parent;
            $tabversion=$this->_modulexml->version;

            $isextension= false;
            if(!empty($this->_modulexml->type)) {
                    $type = strtolower($this->_modulexml->type);
                    if($type == 'extension' || $type == 'language')
                            $isextension = true;
            }
            
            $vtigerMinVersion = $this->_modulexml->dependencies->vtiger_version;
            $vtigerMaxVersion = $this->_modulexml->dependencies->vtiger_max_version;

            $moduleInstance = new Vtiger_Module();
            $moduleInstance->name = $tabname;
            $moduleInstance->label= $tablabel;
            $moduleInstance->parent=$parenttab;
            $moduleInstance->isentitytype = ($isextension != true);
            $moduleInstance->version = (!$tabversion)? 0 : $tabversion;
            $moduleInstance->minversion = (!$vtigerMinVersion)? false : $vtigerMinVersion;
            $moduleInstance->maxversion = (!$vtigerMaxVersion)?  false : $vtigerMaxVersion;
            $moduleInstance->save();
            
            if(!empty($parenttab)) {
                $menuInstance = Vtiger_Menu::getInstance($parenttab);
                $menuInstance->addModule($moduleInstance);
            }

            $this->import_Tables($this->_modulexml);
            $this->import_Blocks($this->_modulexml, $moduleInstance);
            $this->import_CustomViews($this->_modulexml, $moduleInstance);
            $this->import_Events($this->_modulexml, $moduleInstance);
            $this->import_Actions($this->_modulexml, $moduleInstance);
            $this->import_RelatedLists($this->_modulexml, $moduleInstance);
            $this->import_CustomLinks($this->_modulexml, $moduleInstance);
            $this->import_CronTasks($this->_modulexml);
            //$this->import_SharingAccess($this->_modulexml, $moduleInstance);
            Vtiger_Module::fireEvent($moduleInstance->name,
			Vtiger_Module::EVENT_MODULE_POSTINSTALL);

            $moduleInstance->initWebservice();
            $this->delete_file();
        }
    }
    
    function delete_file() {
        global $root_directory;
        $path = rtrim($root_directory, "/");
        $path .= "\manifest.xml";
        unlink($path);
    }
    
    function import_Tables($modulenode) {
        if(empty($modulenode->tables) || empty($modulenode->tables->table)) return;
               
        if(file_exists("modules/$modulenode->name")){
            $fileToOpen = "modules/$modulenode->name/schema.xml";
        } else if(file_exists("modules/Settings/$modulenode->name")){
            $fileToOpen = "modules/Settings/$modulenode->name/schema.xml";
        }
        $schemafile = fopen($fileToOpen, 'w');
        if($schemafile) {
                fwrite($schemafile, "<?xml version='1.0'?>\n");
                fwrite($schemafile, "<schema>\n");
                fwrite($schemafile, "\t<tables>\n");
        }
        
        // Import the table via queries
        foreach($modulenode->tables->table as $tablenode) {
            $tablename = $tablenode->name;
            $tablesql  = "$tablenode->sql"; // Convert to string format

            // Save the information in the schema file.
            fwrite($schemafile, "\t\t<table>\n");
            fwrite($schemafile, "\t\t\t<name>$tablename</name>\n");
            fwrite($schemafile, "\t\t\t<sql><![CDATA[$tablesql]]></sql>\n");
            fwrite($schemafile, "\t\t</table>\n");

            // Avoid executing SQL that will DELETE or DROP table data
            if(Vtiger_Utils::IsCreateSql($tablesql)) {
                    if(!Vtiger_Utils::checkTable($tablename)) {
                            //self::log("SQL: $tablesql ... ", false);
                            Vtiger_Utils::ExecuteQuery($tablesql);
                            //self::log("DONE");
                    }
            } else {
                    if(Vtiger_Utils::IsDestructiveSql($tablesql)) {
                            //self::log("SQL: $tablesql ... SKIPPED");
                    } else {
                            //self::log("SQL: $tablesql ... ", false);
                            Vtiger_Utils::ExecuteQuery($tablesql);
                            //self::log("DONE");
                    }
            }
        }
        if($schemafile) {
                fwrite($schemafile, "\t</tables>\n");
                fwrite($schemafile, "</schema>\n");
                fclose($schemafile);
        }
    }
    
    function import_Blocks($modulenode, $moduleInstance) {
        if(empty($modulenode->blocks) || empty($modulenode->blocks->block)) return;
        foreach($modulenode->blocks->block as $blocknode) {
                $blockInstance = $this->import_Block($modulenode, $moduleInstance, $blocknode);
                $this->import_Fields($blocknode, $blockInstance, $moduleInstance);
        }
    }
    
    function import_Block($modulenode, $moduleInstance, $blocknode) {
        $blocklabel = $blocknode->label;

        $blockInstance = new Vtiger_Block();
        $blockInstance->label = $blocklabel;
        $moduleInstance->addBlock($blockInstance);
        return $blockInstance;
    }

    function import_Fields($blocknode, $blockInstance, $moduleInstance) {
        if(empty($blocknode->fields) || empty($blocknode->fields->field)) return;

        foreach($blocknode->fields->field as $fieldnode) {
                $fieldInstance = $this->import_Field($blocknode, $blockInstance, $moduleInstance, $fieldnode);
        }
    }
    
    function import_Field($blocknode, $blockInstance, $moduleInstance, $fieldnode) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name         = $fieldnode->fieldname;
        $fieldInstance->label        = $fieldnode->fieldlabel;
        $fieldInstance->table        = $fieldnode->tablename;
        $fieldInstance->column       = $fieldnode->columnname;
        $fieldInstance->uitype       = $fieldnode->uitype;
        $fieldInstance->generatedtype= $fieldnode->generatedtype;
        $fieldInstance->readonly     = $fieldnode->readonly;
        $fieldInstance->presence     = $fieldnode->presence;
        $fieldInstance->defaultvalue = $fieldnode->defaultvalue;
        $fieldInstance->maximumlength= $fieldnode->maximumlength;
        $fieldInstance->sequence     = $fieldnode->sequence;
        $fieldInstance->quickcreate  = $fieldnode->quickcreate;
        $fieldInstance->quicksequence= $fieldnode->quickcreatesequence;
        $fieldInstance->typeofdata   = $fieldnode->typeofdata;
        $fieldInstance->displaytype  = $fieldnode->displaytype;
        $fieldInstance->info_type    = $fieldnode->info_type;

        if(!empty($fieldnode->helpinfo))
                $fieldInstance->helpinfo = $fieldnode->helpinfo;

        if(isset($fieldnode->masseditable))
                $fieldInstance->masseditable = $fieldnode->masseditable;

        if(isset($fieldnode->columntype) && !empty($fieldnode->columntype))
                $fieldInstance->columntype = $fieldnode->columntype;

        $blockInstance->addField($fieldInstance);

        // Set the field as entity identifier if marked.
        if(!empty($fieldnode->entityidentifier)) {
                $moduleInstance->entityidfield = $fieldnode->entityidentifier->entityidfield;
                $moduleInstance->entityidcolumn= $fieldnode->entityidentifier->entityidcolumn;
                $moduleInstance->setEntityIdentifier($fieldInstance);
        }

        // Check picklist values associated with field if any.
        if(!empty($fieldnode->picklistvalues) && !empty($fieldnode->picklistvalues->picklistvalue)) {
                $picklistvalues = Array();
                foreach($fieldnode->picklistvalues->picklistvalue as $picklistvaluenode) {
                        $picklistvalues[] = $picklistvaluenode;
                }
                $fieldInstance->setPicklistValues( $picklistvalues );
        }

        // Check related modules associated with this field
        if(!empty($fieldnode->relatedmodules) && !empty($fieldnode->relatedmodules->relatedmodule)) {
                $relatedmodules = Array();
                foreach($fieldnode->relatedmodules->relatedmodule as $relatedmodulenode) {
                        $relatedmodules[] = $relatedmodulenode;
                }
                $fieldInstance->setRelatedModules($relatedmodules);
        }

        // Set summary field if marked in xml
        if(!empty($fieldnode->summaryfield)) {
            $fieldInstance->setSummaryField($fieldnode->summaryfield);
        }

        $this->__AddModuleFieldToCache($moduleInstance, $fieldnode->fieldname, $fieldInstance);
        return $fieldInstance;
    }
    
    function __AddModuleFieldToCache($moduleInstance, $fieldname, $fieldInstance) {
	$this->_modulefields_cache["$moduleInstance->name"]["$fieldname"] = $fieldInstance;
    }
    
    function import_CustomViews($modulenode, $moduleInstance) {
        if(empty($modulenode->customviews) || empty($modulenode->customviews->customview)) return;
        foreach($modulenode->customviews->customview as $customviewnode) {
                $filterInstance = $this->import_CustomView($modulenode, $moduleInstance, $customviewnode);

        }
    }

    function import_CustomView($modulenode, $moduleInstance, $customviewnode) {
        $viewname = $customviewnode->viewname;
        $setdefault=$customviewnode->setdefault;
        $setmetrics=$customviewnode->setmetrics;

        $filterInstance = new Vtiger_Filter();
        $filterInstance->name = $viewname;
        $filterInstance->isdefault = $setdefault;
        $filterInstance->inmetrics = $setmetrics;

        $moduleInstance->addFilter($filterInstance);

        foreach($customviewnode->fields->field as $fieldnode) {
                $fieldInstance = $this->__GetModuleFieldFromCache($moduleInstance, $fieldnode->fieldname);
                $filterInstance->addField($fieldInstance, $fieldnode->columnindex);

                if(!empty($fieldnode->rules->rule)) {
                        foreach($fieldnode->rules->rule as $rulenode) {
                                $filterInstance->addRule($fieldInstance, $rulenode->comparator, $rulenode->value, $rulenode->columnindex);
                        }
                }
        }
    }
    
    function __GetModuleFieldFromCache($moduleInstance, $fieldname) {
	return $this->_modulefields_cache["$moduleInstance->name"]["$fieldname"];
    }
    
    function import_Events($modulenode, $moduleInstance) {
        if(empty($modulenode->events) || empty($modulenode->events->event))	return;

        if(Vtiger_Event::hasSupport()) {
                foreach($modulenode->events->event as $eventnode) {
                        $this->import_Event($modulenode, $moduleInstance, $eventnode);
                }
        }
    }

    function import_Event($modulenode, $moduleInstance, $eventnode) {
        $event_condition = '';
        $event_dependent = '[]';
        if(!empty($eventnode->condition)) $event_condition = "$eventnode->condition";
        if(!empty($eventnode->dependent)) $event_dependent = "$eventnode->dependent";
        Vtiger_Event::register($moduleInstance,
                (string)$eventnode->eventname, (string)$eventnode->classname,
                (string)$eventnode->filename, (string)$event_condition, (string)$event_dependent
        );
    }
    
    function import_Actions($modulenode, $moduleInstance) {
        if(empty($modulenode->actions) || empty($modulenode->actions->action)) return;
        foreach($modulenode->actions->action as $actionnode) {
                $this->import_Action($modulenode, $moduleInstance, $actionnode);
        }
    }

    function import_Action($modulenode, $moduleInstance, $actionnode) {
        $actionstatus = $actionnode->status;
        if($actionstatus == 'enabled')
                $moduleInstance->enableTools($actionnode->name);
        else
                $moduleInstance->disableTools($actionnode->name);
    }
    
    function import_RelatedLists($modulenode, $moduleInstance) {
        if(empty($modulenode->relatedlists) || empty($modulenode->relatedlists->relatedlist)) return;
        foreach($modulenode->relatedlists->relatedlist as $relatedlistnode) {
                $relModuleInstance = $this->import_Relatedlist($modulenode, $moduleInstance, $relatedlistnode);
        }
    }

    function import_Relatedlist($modulenode, $moduleInstance, $relatedlistnode) {
        $relModuleInstance = Vtiger_Module::getInstance($relatedlistnode->relatedmodule);
        $label = $relatedlistnode->label;
        $actions = false;
        if(!empty($relatedlistnode->actions) && !empty($relatedlistnode->actions->action)) {
                $actions = Array();
                foreach($relatedlistnode->actions->action as $actionnode) {
                        $actions[] = "$actionnode";
                }
        }
        if($relModuleInstance) {
                $moduleInstance->setRelatedList($relModuleInstance, "$label", $actions, "$relatedlistnode->function");
        }
        return $relModuleInstance;
    }
    
    function import_CustomLinks($modulenode, $moduleInstance) {
        if(empty($modulenode->customlinks) || empty($modulenode->customlinks->customlink)) return;

        foreach($modulenode->customlinks->customlink as $customlinknode) {
                $handlerInfo = null;
                if(!empty($customlinknode->handler_path)) {
                        $handlerInfo = array();
                        $handlerInfo = array("$customlinknode->handler_path",
                                                "$customlinknode->handler_class",
                                                "$customlinknode->handler");
                }
                $moduleInstance->addLink(
                        "$customlinknode->linktype",
                        "$customlinknode->linklabel",
                        "$customlinknode->linkurl",
                        "$customlinknode->linkicon",
                        "$customlinknode->sequence",
                        $handlerInfo
                );
        }
    }

    function import_CronTasks($modulenode){
        if(empty($modulenode->crons) || empty($modulenode->crons->cron)) return;
        foreach ($modulenode->crons->cron as $cronTask){
                if(empty($cronTask->status)){
                    $cronTask->status = Vtiger_Cron::$STATUS_DISABLED;
                } else {
                    $cronTask->status = Vtiger_Cron::$STATUS_ENABLED;
                } 
                if((empty($cronTask->sequence))){
                        $cronTask->sequence=Vtiger_Cron::nextSequence();
                }
                Vtiger_Cron::register("$cronTask->name","$cronTask->handler", "$cronTask->frequency", "$modulenode->name","$cronTask->status","$cronTask->sequence","$cronTask->description");
        }
    }
    
    function import_SharingAccess($modulenode, $moduleInstance) {
        if(empty($modulenode->sharingaccess)) return;

        if(!empty($modulenode->sharingaccess->default)) {
                foreach($modulenode->sharingaccess->default as $defaultnode) {
                        $moduleInstance->setDefaultSharing($defaultnode);
                }
        }
    }
}