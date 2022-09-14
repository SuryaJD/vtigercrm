<?php /* Smarty version Smarty-3.1.7, created on 2022-09-13 23:57:22
         compiled from "/home/cleavr/crm.aerem.co/releases/20220913061113341/includes/runtime/../../layouts/v7/modules/Settings/Webforms/ListViewRecordActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:172751223632118e28ec1f6-03238439%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4669192a9943f11665a345960db2f58a99aae478' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220913061113341/includes/runtime/../../layouts/v7/modules/Settings/Webforms/ListViewRecordActions.tpl',
      1 => 1663092683,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '172751223632118e28ec1f6-03238439',
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
  'unifunc' => 'content_632118e291779',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_632118e291779')) {function content_632118e291779($_smarty_tpl) {?>
<!--LIST VIEW RECORD ACTIONS--><div class="table-actions"><?php  $_smarty_tpl->tpl_vars['RECORD_LINK'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RECORD_LINK']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getRecordLinks(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RECORD_LINK']->key => $_smarty_tpl->tpl_vars['RECORD_LINK']->value){
$_smarty_tpl->tpl_vars['RECORD_LINK']->_loop = true;
?><?php $_smarty_tpl->tpl_vars["RECORD_LINK_URL"] = new Smarty_variable($_smarty_tpl->tpl_vars['RECORD_LINK']->value->getUrl(), null, 0);?><span><a <?php if (stripos($_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value,'javascript:')===0){?>onclick="<?php echo substr($_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value,strlen("javascript:"));?>
;"<?php }else{ ?>href='<?php echo $_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value;?>
' <?php }?>><i class="<?php echo $_smarty_tpl->tpl_vars['RECORD_LINK']->value->getIcon();?>
" title="<?php echo vtranslate($_smarty_tpl->tpl_vars['RECORD_LINK']->value->getLabel(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a></span><?php } ?></div><?php }} ?>