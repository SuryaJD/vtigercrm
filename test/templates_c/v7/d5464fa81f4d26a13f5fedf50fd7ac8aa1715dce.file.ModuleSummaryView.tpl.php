<?php /* Smarty version Smarty-3.1.7, created on 2022-09-08 04:41:12
         compiled from "/home/cleavr/crm.aerem.co/releases/20220907041739858/includes/runtime/../../layouts/v7/modules/Leads/ModuleSummaryView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12915509996319726833e540-60525666%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd5464fa81f4d26a13f5fedf50fd7ac8aa1715dce' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220907041739858/includes/runtime/../../layouts/v7/modules/Leads/ModuleSummaryView.tpl',
      1 => 1662567467,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12915509996319726833e540-60525666',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6319726834229',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6319726834229')) {function content_6319726834229($_smarty_tpl) {?>
<div class="recordDetails"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewContents.tpl',$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php }} ?>