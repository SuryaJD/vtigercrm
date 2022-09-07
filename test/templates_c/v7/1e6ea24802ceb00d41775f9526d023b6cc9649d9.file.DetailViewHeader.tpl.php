<?php /* Smarty version Smarty-3.1.7, created on 2022-08-29 17:10:15
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/DetailViewHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:381045081630cf2f74d5885-99011011%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e6ea24802ceb00d41775f9526d023b6cc9649d9' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/DetailViewHeader.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '381045081630cf2f74d5885-99011011',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_630cf2f74da16',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630cf2f74da16')) {function content_630cf2f74da16($_smarty_tpl) {?>
<div class=" detailview-header-block"><div class="detailview-header"><div class="row"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("DetailViewHeaderTitle.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("DetailViewActions.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></div><?php }} ?>