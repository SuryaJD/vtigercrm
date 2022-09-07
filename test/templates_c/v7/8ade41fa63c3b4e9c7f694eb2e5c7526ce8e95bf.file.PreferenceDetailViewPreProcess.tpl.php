<?php /* Smarty version Smarty-3.1.7, created on 2022-08-30 07:47:28
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Users/PreferenceDetailViewPreProcess.tpl" */ ?>
<?php /*%%SmartyHeaderCode:787562802630dc090c274e5-84565676%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ade41fa63c3b4e9c7f694eb2e5c7526ce8e95bf' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Users/PreferenceDetailViewPreProcess.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '787562802630dc090c274e5-84565676',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_630dc090c2d71',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630dc090c2d71')) {function content_630dc090c2d71($_smarty_tpl) {?>

<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("SettingsMenuStart.tpl",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="bodyContents"><div class=""><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("PreferenceDetailViewHeader.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>