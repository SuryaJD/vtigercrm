<?php /* Smarty version Smarty-3.1.7, created on 2022-08-29 13:06:11
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/dashboards/TagCloudContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1018098739630cb9c3def2e6-98012474%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6aa0049a5b28a51e759c0bf1ed86c460f65d86c5' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/dashboards/TagCloudContents.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1018098739630cb9c3def2e6-98012474',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TAGS' => 0,
    'TAG_MODEL' => 0,
    'TAG_LABEL' => 0,
    'TAG_ID' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_630cb9c3df3ca',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630cb9c3df3ca')) {function content_630cb9c3df3ca($_smarty_tpl) {?>

<div class="tagsContainer" id="tagCloud"><?php  $_smarty_tpl->tpl_vars['TAG_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TAG_MODEL']->_loop = false;
 $_smarty_tpl->tpl_vars['TAG_ID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['TAGS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TAG_MODEL']->key => $_smarty_tpl->tpl_vars['TAG_MODEL']->value){
$_smarty_tpl->tpl_vars['TAG_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['TAG_ID']->value = $_smarty_tpl->tpl_vars['TAG_MODEL']->key;
?><?php $_smarty_tpl->tpl_vars['TAG_LABEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['TAG_MODEL']->value->getName(), null, 0);?><span class="tag" title="<?php echo $_smarty_tpl->tpl_vars['TAG_LABEL']->value;?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['TAG_MODEL']->value->getType();?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['TAG_ID']->value;?>
"><span class="tagName display-inline-block textOverflowEllipsis cursorPointer" data-tagid="<?php echo $_smarty_tpl->tpl_vars['TAG_ID']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['TAG_LABEL']->value;?>
</span></span><?php } ?></div><?php }} ?>