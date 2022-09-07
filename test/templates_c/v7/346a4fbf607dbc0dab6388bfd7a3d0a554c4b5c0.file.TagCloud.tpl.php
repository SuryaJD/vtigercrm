<?php /* Smarty version Smarty-3.1.7, created on 2022-08-29 13:06:11
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/dashboards/TagCloud.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1613590798630cb9c3de7d48-18760558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '346a4fbf607dbc0dab6388bfd7a3d0a554c4b5c0' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/dashboards/TagCloud.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1613590798630cb9c3de7d48-18760558',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_630cb9c3dec99',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630cb9c3dec99')) {function content_630cb9c3dec99($_smarty_tpl) {?>
<div class="dashboardWidgetHeader"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/WidgetHeader.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><div class="dashboardWidgetContent" style='padding:5px'><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/TagCloudContents.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><div class="widgeticons dashBoardWidgetFooter"><div class="footerIcons pull-right"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/DashboardFooterIcons.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></div>	 <?php }} ?>