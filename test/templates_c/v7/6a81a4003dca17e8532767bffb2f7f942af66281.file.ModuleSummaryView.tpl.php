<?php /* Smarty version Smarty-3.1.7, created on 2022-09-13 14:17:27
         compiled from "D:\xampp7\htdocs\aeremcrm\includes\runtime/../../layouts/v7\modules\Leads\ModuleSummaryView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:497402602632090f795e197-09276512%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a81a4003dca17e8532767bffb2f7f942af66281' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\aeremcrm\\includes\\runtime/../../layouts/v7\\modules\\Leads\\ModuleSummaryView.tpl',
      1 => 1662567685,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '497402602632090f795e197-09276512',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_632090f79632f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_632090f79632f')) {function content_632090f79632f($_smarty_tpl) {?>
<div class="recordDetails"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewContents.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php }} ?>