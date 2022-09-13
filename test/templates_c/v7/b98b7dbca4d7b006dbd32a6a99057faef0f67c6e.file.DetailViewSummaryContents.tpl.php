<?php /* Smarty version Smarty-3.1.7, created on 2022-09-13 14:17:27
         compiled from "D:\xampp7\htdocs\aeremcrm\includes\runtime/../../layouts/v7\modules\Leads\DetailViewSummaryContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:602219598632090f7a06034-82593213%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b98b7dbca4d7b006dbd32a6a99057faef0f67c6e' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\aeremcrm\\includes\\runtime/../../layouts/v7\\modules\\Leads\\DetailViewSummaryContents.tpl',
      1 => 1662567685,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '602219598632090f7a06034-82593213',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_632090f7a0a81',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_632090f7a0a81')) {function content_632090f7a0a81($_smarty_tpl) {?>

<form id="detailView" class="clearfix" method="POST" style="position: relative"><div class="col-lg-12 resizable-summary-view"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewWidgets.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></form><?php }} ?>