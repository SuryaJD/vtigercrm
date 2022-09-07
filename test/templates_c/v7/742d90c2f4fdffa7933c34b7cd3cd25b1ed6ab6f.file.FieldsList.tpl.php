<?php /* Smarty version Smarty-3.1.7, created on 2022-09-07 17:20:18
         compiled from "D:\xampp7\htdocs\aeremcrm\includes\runtime/../../layouts/v7\modules\ModuleBuilder\FieldsList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20744901366318d2d230d272-93537984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '742d90c2f4fdffa7933c34b7cd3cd25b1ed6ab6f' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\aeremcrm\\includes\\runtime/../../layouts/v7\\modules\\ModuleBuilder\\FieldsList.tpl',
      1 => 1662571163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20744901366318d2d230d272-93537984',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SELECTED_MODULE_MODEL' => 0,
    'QUALIFIED_MODULE' => 0,
    'IS_SORTABLE' => 0,
    'BLOCKS' => 0,
    'BLOCK_LABEL_KEY' => 0,
    'BLOCK_MODEL' => 0,
    'BLOCK_ID' => 0,
    'MODULE' => 0,
    'TKSMODULE' => 0,
    'IN_ACTIVE_FIELDS' => 0,
    'HEADER_FIELDS_COUNT' => 0,
    'HEADER_FIELDS_META' => 0,
    'HEADER_TITLE' => 0,
    'CLEAN_FIELD_MODEL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6318d2d233bd8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6318d2d233bd8')) {function content_6318d2d233bd8($_smarty_tpl) {?>

<?php $_smarty_tpl->tpl_vars['IS_SORTABLE'] = new Smarty_variable($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->isSortableAllowed(), null, 0);?><?php $_smarty_tpl->tpl_vars['ALL_BLOCK_LABELS'] = new Smarty_variable(array(), null, 0);?><form class="form-horizontal saveModuleData" id="saveModuleData"><div class="editViewBody" ><div class="row" style="padding:1% 0"><div class="col-sm-6"><button class="btn btn-default addButton addCustomBlock" type="button"><i class="fa fa-plus"></i>&nbsp;<?php echo vtranslate('LBL_ADD_CUSTOM_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></div><div class="col-sm-6"><?php if ($_smarty_tpl->tpl_vars['IS_SORTABLE']->value){?><span class="pull-right"><button class="btn btn-success hide" id="saveModule" type="button"><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></span><?php }?></div><!--<div class="col-sm-6"><?php if ($_smarty_tpl->tpl_vars['IS_SORTABLE']->value){?><span class="pull-right"><button class="btn btn-success saveFieldSequence" type="button"><?php echo vtranslate('LBL_SAVE_LAYOUT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></span><?php }?></div>--></div><div class="row"><div class="col-sm-12" ><div id="moduleBlocks" style="margin-top:17px;"><div class="tksfirstblock" ></div><!--<div class="tksfirstblock" ></div>--><?php  $_smarty_tpl->tpl_vars['BLOCK_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['BLOCK_MODEL']->_loop = false;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['BLOCKS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['BLOCK_MODEL']->key => $_smarty_tpl->tpl_vars['BLOCK_MODEL']->value){
$_smarty_tpl->tpl_vars['BLOCK_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value = $_smarty_tpl->tpl_vars['BLOCK_MODEL']->key;
?><?php $_smarty_tpl->tpl_vars['IS_BLOCK_SORTABLE'] = new Smarty_variable($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->isBlockSortableAllowed($_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['FIELDS_LIST'] = new Smarty_variable($_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->getLayoutBlockActiveFields(), null, 0);?><?php $_smarty_tpl->tpl_vars['BLOCK_ID'] = new Smarty_variable(0, null, 0);?><?php if ($_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value!='LBL_INVITE_USER_BLOCK'){?><?php $_smarty_tpl->createLocalArrayVariable('ALL_BLOCK_LABELS', null, 0);
$_smarty_tpl->tpl_vars['ALL_BLOCK_LABELS']->value[$_smarty_tpl->tpl_vars['BLOCK_ID']->value] = $_smarty_tpl->tpl_vars['BLOCK_MODEL']->value;?><?php }?><?php } ?><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="action" value="BuildModule" /><input type="hidden" name="mode" value="saveModule" /><input type="hidden" id="token" name="token" value="<?php echo $_REQUEST['token'];?>
" /><input type="hidden" id="tks_modulename" name="tks_modulename" value="<?php echo $_smarty_tpl->tpl_vars['TKSMODULE']->value;?>
" /><input type="hidden" id="tks_entity" name="tks_entity" value="<?php echo $_smarty_tpl->tpl_vars['TKSMODULE']->value;?>
" /><input type="hidden" class="inActiveFieldsArray" value='<?php echo Vtiger_Functions::jsonEncode($_smarty_tpl->tpl_vars['IN_ACTIVE_FIELDS']->value);?>
' /><input type="hidden" id="headerFieldsCount" value="<?php echo $_smarty_tpl->tpl_vars['HEADER_FIELDS_COUNT']->value;?>
"><input type="hidden" id="nameFields" value='<?php echo Vtiger_Functions::jsonEncode($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->getNameFields());?>
'><input type="hidden" id="headerFieldsMeta" value='<?php echo Vtiger_Functions::jsonEncode($_smarty_tpl->tpl_vars['HEADER_FIELDS_META']->value);?>
'><input type = 'hidden' name = 'tksblockid' value ='0' id = 'tksblockid' /><input type = 'hidden' name = 'tksblocklabel' value ='' id = 'tksblocklabel' /><div id="" class="newCustomBlockCopy hide marginBottom10px border1px blockSortable" data-block-id="" data-sequence=""><div class="layoutBlockHeader" ><div class="col-sm-5 blockLabel padding5 marginLeftZero" style="word-break: break-all;"><img class="alignMiddle" src="<?php echo vimage_path('drag.png');?>
" />&nbsp;&nbsp;</div><div class="col-sm-7 padding10 marginLeftZero"><div class="blockActions" style="float: right !important;"><!--<span><i class="fa fa-info-circle" title="<?php echo vtranslate('LBL_COLLAPSE_BLOCK_DETAIL_VIEW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i>&nbsp; <?php echo vtranslate('LBL_COLLAPSE_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
&nbsp;<input style="opacity: 0;" type="checkbox"<?php if ($_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->isHidden()){?> checked value='0' <?php }else{ ?> value='1' <?php }?> class ='cursorPointer' id="hiddenCollapseBlock" name=""data-on-text="<?php echo vtranslate('LBL_YES',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-off-text="<?php echo vtranslate('LBL_NO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-on-color="primary" data-block-id="<?php echo $_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->get('id');?>
"/></span>-->&nbsp;<button class="btn btn-default addButton addCustomField" type="button"><i class="fa fa-plus"></i>&nbsp;<?php echo vtranslate('LBL_ADD_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button>&nbsp;&nbsp;<!--<button class="inActiveFields addButton btn btn-default btn-sm"><?php echo vtranslate('LBL_SHOW_HIDDEN_FIELDS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button>-->&nbsp;&nbsp;<button class="deleteCustomBlock addButton btn btn-default btn-sm" type="button"><?php echo vtranslate('LBL_DELETE_CUSTOM_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></div></div></div><div class="blockFieldsList row blockFieldsSortable" ><ul class="connectedSortable col-sm-6 ui-sortable"name="sortable1"><li class="row dummyRow"><span class="dragUiText col-sm-8"><?php echo vtranslate('LBL_ADD_NEW_FIELD_HERE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><span class="col-sm-4" style="margin-top: 7%;margin-left: -15%;"><button class="btn btn-default btn-sm addButton" style="padding: 2px 15px;" type="button"><i class="fa fa-plus"></i>&nbsp;<?php echo vtranslate('LBL_ADD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></span></li></ul><ul class="connectedSortable col-sm-6 ui-sortable" name="sortable2"></ul></div></div></div></div></div><hr><!--<div class="container-fluid hide" id="layoutEditorContainer">--><!--<div class="contents tabbable">--><div class="tab-content layoutContent padding20 themeTableColor overflowVisible"><div class="tab-pane" id="detailViewLayout"><div class="btn-toolbar padding20"><span class="pull-right"><button class="btn btn-success saveFieldSequence hide" type="button"data-container="body" data-toggle="popover" data-placement="left" data-content="<?php echo vtranslate('LBL_SAVE_SEQUENCE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><i class="icon-align-justify"></i>&nbsp;&nbsp;<strong><?php echo vtranslate('LBL_SAVE_FIELD_SEQUENCE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></span></div><!--class="btn-toolbar padding20"--><!--<div id="moduleBlocks"></div>-->	<!--id="moduleBlocks"--></div><!--class="tab-content layoutContent padding20 themeTableColor overflowVisible"--><div class="blockFieldsList  blockFieldsSortable  row"><ul name="sortable1" class="connectedSortable col-sm-6 ui-sortable"><li class="newCustomFieldCopy hide"><div class="row border1px"><div class="col-sm-4"><div class="marginLeftZero" data-field-id="" data-sequence="" style="min-height: 138px; !important;"><div class="row"><span class="col-sm-1">&nbsp;<?php if ($_smarty_tpl->tpl_vars['IS_SORTABLE']->value){?><img src="<?php echo vimage_path('drag.png');?>
" class="dragImage" border="0" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/><?php }?></span><div class="col-sm-9" style="word-wrap: break-word;"><div class="fieldLabelContainer row"><span class="fieldLabel fieldLabels"><b></b>&nbsp;</span><div><span class="pull-right fieldTypeLabel" style="opacity:0.6;"></span></div></div></div></div></div></div><div class="col-sm-8 fieldPropertyContainer"><div class="row " style="padding:10px 0px"><div class="fieldProperties col-sm-10" data-field-id=""><span class="mandatory switch text-capitalize"><i class="fa fa-exclamation-circle" data-name="mandatory"data-enable-value="M" data-disable-value="O"title="<?php echo vtranslate('LBL_MANDATORY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i>&nbsp;<?php echo vtranslate('LBL_PROP_MANDATORY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="quickCreate switch"><i class="fa fa-plus" data-name="quickcreate"data-enable-value="1" data-disable-value="0"title="<?php echo vtranslate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i>&nbsp;<?php echo vtranslate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><br><br><span class="massEdit switch" ><img src="<?php echo vimage_path('MassEdit.png');?>
" data-name="masseditable"data-enable-value="1" data-disable-value="2" title="<?php echo vtranslate('LBL_MASS_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" height=14 width=14/>&nbsp;<?php echo vtranslate('LBL_MASS_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="header switch"><i class="fa fa-flag-o" data-name="headerfield"data-enable-value="1" data-disable-value="0"title="<?php echo vtranslate('LBL_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i>&nbsp;<?php echo vtranslate('LBL_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><br><br><span class="summary switch"><i class="fa fa-key" data-name="summaryfield"data-enable-value="1" data-disable-value="0"title="<?php echo vtranslate('LBL_KEY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i>&nbsp;<?php echo vtranslate('LBL_KEY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><br><br><div class="defaultValue col-sm-12"></div></div><span class="col-sm-2 actions"><a href="javascript:void(0)" class="editFieldDetails"><i class="fa fa-pencil" title="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a><a href="javascript:void(0)" class="deleteCustomField pull-right"><i class="fa fa-trash" title="<?php echo vtranslate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a></span></div></div></div></li></ul></div></div></form><!--add BLOCK pop up START--><div class="modal-dialog modal-content addBlockModal hide"><?php ob_start();?><?php echo vtranslate('LBL_ADD_CUSTOM_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['HEADER_TITLE'] = new Smarty_variable($_tmp1, null, 0);?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("ModalHeader.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('TITLE'=>$_smarty_tpl->tpl_vars['HEADER_TITLE']->value), 0);?>
<form class="form-horizontal addCustomBlockForm"><div class="modal-body"><div class="form-group"><label class="control-label fieldLabel col-sm-5"><span><?php echo vtranslate('LBL_BLOCK_NAME',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span><span class="redColor">*</span></label><div class="controls col-sm-6"><input type="text" name="label" class="col-sm-3 inputElement" data-rule-required='true' data-rule-illegal='true' style='width: 75%'/></div></div><div class="form-group"><label class="control-label fieldLabel col-sm-5"><?php echo vtranslate('LBL_ADD_AFTER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><div class="controls col-sm-6"><select class="span8" name="beforeBlockId"><option value="0"><?php echo vtranslate('SELECT_BLOCK',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option></select></div><!--class="controls"--></div><!--class="control-group"--></div><!--class="modal-body"--><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form><!--class="form-horizontal addCustomBlockForm"--></div><!--class="modal addBlockModal hide"--><!--add BLOCK pop up END--><div class="hide defaultValueIcon"><img src="<?php echo vimage_path('DefaultValue.png');?>
" height=14 width=14></div><?php $_smarty_tpl->tpl_vars['FIELD_INFO'] = new Smarty_variable($_smarty_tpl->tpl_vars['CLEAN_FIELD_MODEL']->value->getFieldInfo(), null, 0);?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('FieldCreate.tpl','ModuleBuilder'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('FIELD_MODEL'=>$_smarty_tpl->tpl_vars['CLEAN_FIELD_MODEL']->value,'IS_FIELD_EDIT_MODE'=>false), 0);?>
<div class="modal-dialog inactiveFieldsModal hide"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3><?php echo vtranslate('LBL_INACTIVE_FIELDS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><div class="modal-content"><form class="form-horizontal inactiveFieldsForm"><div class="modal-body"><div class="inActiveList row"><div class="col-sm-1"></div><div class="list col-sm-10"></div><div class="col-sm-1"></div></div></div><div class="modal-footer"><div class="pull-right cancelLinkContainer"><a class="cancelLink" type="reset" data-dismiss="modal"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></div><button class="btn btn-success" type="submit" name="reactivateButton"><strong><?php echo vtranslate('LBL_REACTIVATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div></form></div></div>
<?php }} ?>