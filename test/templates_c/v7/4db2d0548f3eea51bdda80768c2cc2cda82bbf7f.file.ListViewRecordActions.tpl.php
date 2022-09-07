<?php /* Smarty version Smarty-3.1.7, created on 2022-08-30 05:59:26
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Settings/Webforms/ListViewRecordActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:760302399630da73e47e6e5-68753797%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4db2d0548f3eea51bdda80768c2cc2cda82bbf7f' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Settings/Webforms/ListViewRecordActions.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '760302399630da73e47e6e5-68753797',
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
  'unifunc' => 'content_630da73e48710',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630da73e48710')) {function content_630da73e48710($_smarty_tpl) {?>
<!--LIST VIEW RECORD ACTIONS--><div class="table-actions"><?php  $_smarty_tpl->tpl_vars['RECORD_LINK'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RECORD_LINK']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getRecordLinks(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RECORD_LINK']->key => $_smarty_tpl->tpl_vars['RECORD_LINK']->value){
$_smarty_tpl->tpl_vars['RECORD_LINK']->_loop = true;
?><?php $_smarty_tpl->tpl_vars["RECORD_LINK_URL"] = new Smarty_variable($_smarty_tpl->tpl_vars['RECORD_LINK']->value->getUrl(), null, 0);?><span><a <?php if (stripos($_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value,'javascript:')===0){?>onclick="<?php echo substr($_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value,strlen("javascript:"));?>
;"<?php }else{ ?>href='<?php echo $_smarty_tpl->tpl_vars['RECORD_LINK_URL']->value;?>
' <?php }?>><i class="<?php echo $_smarty_tpl->tpl_vars['RECORD_LINK']->value->getIcon();?>
" title="<?php echo vtranslate($_smarty_tpl->tpl_vars['RECORD_LINK']->value->getLabel(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a></span><?php } ?></div><?php }} ?>