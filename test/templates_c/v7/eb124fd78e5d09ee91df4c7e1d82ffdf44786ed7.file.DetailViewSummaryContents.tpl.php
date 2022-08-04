<?php /* Smarty version Smarty-3.1.7, created on 2022-08-03 12:12:20
         compiled from "D:\xampp7\htdocs\vtigercrm\includes\runtime/../../layouts/v7\modules\Project\DetailViewSummaryContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:155611446462ea66245015e0-60359792%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb124fd78e5d09ee91df4c7e1d82ffdf44786ed7' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\vtigercrm\\includes\\runtime/../../layouts/v7\\modules\\Project\\DetailViewSummaryContents.tpl',
      1 => 1659339391,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155611446462ea66245015e0-60359792',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_62ea662459f44',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62ea662459f44')) {function content_62ea662459f44($_smarty_tpl) {?>
<form id="detailView" method="POST"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewWidgets.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form><?php }} ?>