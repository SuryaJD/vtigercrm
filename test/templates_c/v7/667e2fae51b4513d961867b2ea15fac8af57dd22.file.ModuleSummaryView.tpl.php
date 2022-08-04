<?php /* Smarty version Smarty-3.1.7, created on 2022-08-03 12:12:20
         compiled from "D:\xampp7\htdocs\vtigercrm\includes\runtime/../../layouts/v7\modules\Project\ModuleSummaryView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:138854261862ea66240ad841-63678215%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '667e2fae51b4513d961867b2ea15fac8af57dd22' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\vtigercrm\\includes\\runtime/../../layouts/v7\\modules\\Project\\ModuleSummaryView.tpl',
      1 => 1659339391,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138854261862ea66240ad841-63678215',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_62ea662414e9e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62ea662414e9e')) {function content_62ea662414e9e($_smarty_tpl) {?>
<div class="recordDetails"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewContents.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div>
<?php }} ?>