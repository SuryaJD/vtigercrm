<?php /* Smarty version Smarty-3.1.7, created on 2022-09-01 06:02:31
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Users/ListViewHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:161266471163104af79f2ba1-27672711%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4f6bcf6771d0aa72b76ae34e1d5514eda0fc1c1d' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Users/ListViewHeader.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161266471163104af79f2ba1-27672711',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'LISTVIEW_ENTRIES_COUNT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_63104af79fd68',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_63104af79fd68')) {function content_63104af79fd68($_smarty_tpl) {?>

<div class="listViewPageDiv" id="listViewContent"><div class="col-sm-12 col-xs-12 full-height"><div id="listview-actions" class="listview-actions-container"><div class = "row"><div class="btn-group col-md-2"></div><div class='col-md-7' style="padding-top: 5px;text-align: center;"><div class="btn-group userFilter" style="text-align: center;"><button class="btn btn-default btn-primary" id="activeUsers" data-searchvalue="Active"><?php echo vtranslate('LBL_ACTIVE_USERS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button><button class="btn btn-default" id="inactiveUsers" data-searchvalue="Inactive"><?php echo vtranslate('LBL_INACTIVE_USERS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button></div></div><div class="col-md-3"><?php $_smarty_tpl->tpl_vars['RECORD_COUNT'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTVIEW_ENTRIES_COUNT']->value, null, 0);?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("Pagination.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('SHOWPAGEJUMP'=>true), 0);?>
</div></div><div class="list-content">
<?php }} ?>