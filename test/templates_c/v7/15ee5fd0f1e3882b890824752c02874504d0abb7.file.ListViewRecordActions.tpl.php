<?php /* Smarty version Smarty-3.1.7, created on 2022-09-13 17:59:41
         compiled from "/home/cleavr/crm.aerem.co/releases/20220907041739858/includes/runtime/../../layouts/v7/modules/Settings/Webforms/ListViewRecordActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1709496826320c50d6bd327-93989350%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '15ee5fd0f1e3882b890824752c02874504d0abb7' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220907041739858/includes/runtime/../../layouts/v7/modules/Settings/Webforms/ListViewRecordActions.tpl',
      1 => 1662567467,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1709496826320c50d6bd327-93989350',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LISTVIEW_ENTRY' => 0,
    'RECORD_LINK' => 0,
    'RECORD_LINK_URL' => 0,
    'QUALIFIED_MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6320c50d72b03',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6320c50d72b03')) {function content_6320c50d72b03($_smarty_tpl) {?>
<!--LIST VIEW RECORD ACTIONS--><div class="table-actions"><?php  $_smarty_tpl->tpl_vars['RECORD_LINK'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RECORD_LINK']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getRecordLinks(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RECORD_LINK']->key => $_smarty_tpl->tpl_vars['RECORD_LINK']->value){
$_smarty_tpl->tpl_vars['RECORD_LINK']->_loop = true;
?><?php $_smarty_tpl->tpl_vars["RECORD_LINK_URL"] = new Smarty_variable($_smarty_tpl->tpl_vars['RECORD_LINK']->value->getUrl(), null, 0);?><span><a <?php if (stripos($_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value,'javascript:')===0){?>onclick="<?php echo substr($_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value,strlen("javascript:"));?>
;"<?php }else{ ?>href='<?php echo $_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value;?>
' <?php }?>><i class="<?php echo $_smarty_tpl->tpl_vars['RECORD_LINK']->value->getIcon();?>
" title="<?php echo vtranslate($_smarty_tpl->tpl_vars['RECORD_LINK']->value->getLabel(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a></span><?php } ?></div><?php }} ?>