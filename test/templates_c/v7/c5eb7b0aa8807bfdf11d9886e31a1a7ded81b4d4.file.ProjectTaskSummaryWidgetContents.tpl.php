<?php /* Smarty version Smarty-3.1.7, created on 2022-08-03 12:14:42
         compiled from "D:\xampp7\htdocs\vtigercrm\includes\runtime/../../layouts/v7\modules\Vtiger\ProjectTaskSummaryWidgetContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:116527539562ea66b230b171-14942836%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5eb7b0aa8807bfdf11d9886e31a1a7ded81b4d4' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\vtigercrm\\includes\\runtime/../../layouts/v7\\modules\\Vtiger\\ProjectTaskSummaryWidgetContents.tpl',
      1 => 1520586669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '116527539562ea66b230b171-14942836',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RELATED_HEADERS' => 0,
    'HEADER' => 0,
    'MODULE_NAME' => 0,
    'RELATED_RECORDS' => 0,
    'RELATED_MODULE' => 0,
    'RELATED_RECORD' => 0,
    'MODULE' => 0,
    'RELATED_MODULE_MODEL' => 0,
    'FIELD_MODEL' => 0,
    'TASK_PROGRESS_HEADER' => 0,
    'PERMISSIONS' => 0,
    'PICKLIST_VALUES' => 0,
    'PICKLIST_VALUE' => 0,
    'TASK_STATUS_HEADER' => 0,
    'NUMBER_OF_RECORDS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_62ea66b240c27',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62ea66b240c27')) {function content_62ea66b240c27($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['HEADER'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['HEADER']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_HEADERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['HEADER']->key => $_smarty_tpl->tpl_vars['HEADER']->value){
$_smarty_tpl->tpl_vars['HEADER']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['HEADER']->value->get('label')=="Project Task Name"){?><?php ob_start();?><?php echo vtranslate($_smarty_tpl->tpl_vars['HEADER']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['TASK_NAME_HEADER'] = new Smarty_variable($_tmp1, null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['HEADER']->value->get('label')=="Progress"){?><?php $_smarty_tpl->tpl_vars['TASK_PROGRESS_HEADER'] = new Smarty_variable(vtranslate($_smarty_tpl->tpl_vars['HEADER']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value), null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['HEADER']->value->get('label')=="Status"){?><?php $_smarty_tpl->tpl_vars['TASK_STATUS_HEADER'] = new Smarty_variable(vtranslate($_smarty_tpl->tpl_vars['HEADER']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE_NAME']->value), null, 0);?><?php }?><?php } ?><?php  $_smarty_tpl->tpl_vars['RELATED_RECORD'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RELATED_RECORD']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_RECORDS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RELATED_RECORD']->key => $_smarty_tpl->tpl_vars['RELATED_RECORD']->value){
$_smarty_tpl->tpl_vars['RELATED_RECORD']->_loop = true;
?><?php $_smarty_tpl->tpl_vars['PERMISSIONS'] = new Smarty_variable(Users_Privileges_Model::isPermitted($_smarty_tpl->tpl_vars['RELATED_MODULE']->value,'EditView',$_smarty_tpl->tpl_vars['RELATED_RECORD']->value->get('id')), null, 0);?><div class="recentActivitiesContainer"><ul class="unstyled"><li><div><div class="textOverflowEllipsis width27em"><a href="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDetailViewUrl();?>
" id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['RELATED_MODULE']->value;?>
_Related_Record_<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->get('id');?>
" title="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('projecttaskname');?>
"><strong><?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('projecttaskname');?>
</strong></a></div><div class="row"><?php $_smarty_tpl->tpl_vars['RELATED_MODULE_MODEL'] = new Smarty_variable(Vtiger_Module_Model::getInstance('ProjectTask'), null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['RELATED_MODULE_MODEL']->value->getField('projecttaskprogress'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isViewableInDetailView()){?><div class="col-lg-6"><div class="row"><span class="col-lg-6"><?php echo $_smarty_tpl->tpl_vars['TASK_PROGRESS_HEADER']->value;?>
 :</span><?php if ($_smarty_tpl->tpl_vars['PERMISSIONS']->value&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditable()){?><span class="col-lg-6"><div class="dropdown pull-left"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="fieldValue"><?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('projecttaskprogress');?>
</span>&nbsp;<b class="caret"></b></a><ul class="dropdown-menu widgetsList" data-recordid="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getId();?>
" data-fieldname="projecttaskprogress"data-old-value="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('projecttaskprogress');?>
" data-mandatory="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory();?>
"><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><li class="editTaskDetails emptyOption"><a><?php echo vtranslate('LBL_SELECT_OPTION',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a></li><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><li class="editTaskDetails"><a><?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
</a></li><?php } ?></ul></div></span><?php }else{ ?><span class="col-lg-7"><strong>&nbsp;<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('projecttaskprogress');?>
</strong></span><?php }?></div></div><?php }?><?php $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['RELATED_MODULE_MODEL']->value->getField('projecttaskstatus'), null, 0);?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isViewableInDetailView()){?><div class="col-lg-6"><div class="row"><span class="col-lg-6"><?php echo $_smarty_tpl->tpl_vars['TASK_STATUS_HEADER']->value;?>
 :</span><?php if ($_smarty_tpl->tpl_vars['PERMISSIONS']->value&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditable()){?><span class="col-lg-6 nav nav-pills"><div class="dropdown pull-left"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="fieldValue"><?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('projecttaskstatus');?>
</span>&nbsp;<b class="caret"></b></a><ul class="dropdown-menu widgetsList pull-right" data-recordid="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getId();?>
" data-fieldname="projecttaskstatus"data-old-value="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('projecttaskstatus');?>
" data-mandatory="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory();?>
" style="max-height: 200px; left: -64px;"><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><li class="editTaskDetails emptyOption" value=""><a><?php echo vtranslate('LBL_SELECT_OPTION',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a></li><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><li class="editTaskDetails" value="<?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
"><a><?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
</a></li><?php } ?></ul></div></span><?php }else{ ?><span class="col-lg-7"><strong>&nbsp;<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('projecttaskstatus');?>
</strong></span><?php }?></div></div><?php }?></div></div></li></ul></div><?php } ?><?php $_smarty_tpl->tpl_vars['NUMBER_OF_RECORDS'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['RELATED_RECORDS']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['NUMBER_OF_RECORDS']->value==5){?><div class=""><div class="pull-right"><a class="moreRecentTasks cursorPointer"><?php echo vtranslate('LBL_MORE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a></div></div><?php }?><?php }} ?>