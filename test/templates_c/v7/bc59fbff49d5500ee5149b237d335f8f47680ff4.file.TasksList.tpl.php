<?php /* Smarty version Smarty-3.1.7, created on 2022-09-10 11:19:51
         compiled from "D:\xampp7\htdocs\aeremcrm\includes\runtime/../../layouts/v7\modules\Settings\Workflows\TasksList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:691223884631c72d7919d97-86028746%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc59fbff49d5500ee5149b237d335f8f47680ff4' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\aeremcrm\\includes\\runtime/../../layouts/v7\\modules\\Settings\\Workflows\\TasksList.tpl',
      1 => 1662567685,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '691223884631c72d7919d97-86028746',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TASK_LIST' => 0,
    'QUALIFIED_MODULE' => 0,
    'TASK' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_631c72d79bab3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_631c72d79bab3')) {function content_631c72d79bab3($_smarty_tpl) {?>
<div style="padding-left: 15px;"><div id="table-content" class="table-container"><table id="listview-table"  class="table <?php if ($_smarty_tpl->tpl_vars['TASK_LIST']->value=='0'){?>listview-table-norecords <?php }else{ ?> listview-table<?php }?> "><thead><tr class="listViewContentHeader"><th width="20%"><?php echo vtranslate('LBL_ACTIVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th><th width="30%"><?php echo vtranslate('LBL_TASK_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th><th><?php echo vtranslate('LBL_TASK_TITLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th></tr></thead><tbody><?php  $_smarty_tpl->tpl_vars['TASK'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TASK']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['TASK_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TASK']->key => $_smarty_tpl->tpl_vars['TASK']->value){
$_smarty_tpl->tpl_vars['TASK']->_loop = true;
?><tr class="listViewEntries"><td><div class="pull-left actions"><span class="actionImages"><a data-url="<?php echo $_smarty_tpl->tpl_vars['TASK']->value->getEditViewUrl();?>
"><i class="fa fa-pencil alignMiddle" title="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a>&nbsp;&nbsp;<a class="deleteTask" data-deleteurl="<?php echo $_smarty_tpl->tpl_vars['TASK']->value->getDeleteActionUrl();?>
"><i class="fa fa-trash alignMiddle" title="<?php echo vtranslate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a></span></div>&nbsp;&nbsp;<input style="opacity: 0;" type="checkbox" data-on-color="success" class="taskStatus" data-statusurl="<?php echo $_smarty_tpl->tpl_vars['TASK']->value->getChangeStatusUrl();?>
" <?php if ($_smarty_tpl->tpl_vars['TASK']->value->isActive()){?> checked="" value="on" <?php }else{ ?> value="off" <?php }?> /></td><td class="listViewEntryValue"><?php echo vtranslate($_smarty_tpl->tpl_vars['TASK']->value->getTaskType()->getLabel(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</td><td><span class="pull-left"><?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['TASK']->value->getName());?>
</span></td><tr><?php } ?><tr class="listViewEntries hide taskTemplate"><td><div class="pull-left actions"><span class="actionImages"><a class="editTask"><i class="fa fa-pencil alignMiddle" ></i></a>&nbsp;&nbsp;<a class="deleteTaskTemplate"><i class="fa fa-trash alignMiddle"></i></a></span></div>&nbsp;&nbsp;<input style="opacity: 0;" type="checkbox" data-on-color="success" class="tmpTaskStatus" checked="" value="on"/></td><td class="listViewEntryValue taskType"></td><td><span class="pull-left taskName"></span></td></tr></tbody></table><?php if (empty($_smarty_tpl->tpl_vars['TASK_LIST']->value)){?><table class="emptyRecordsDiv"><tbody><tr><td><?php echo vtranslate('LBL_NO_TASKS_ADDED',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</td></tr></tbody></table><?php }?></div></div><?php }} ?>