<?php /* Smarty version Smarty-3.1.7, created on 2022-08-30 07:00:05
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Settings/Workflows/ListViewRecordActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:631430154630db575498943-28605590%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbf046e248d034dc53cb82c06bd09834e8c4c905' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Settings/Workflows/ListViewRecordActions.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '631430154630db575498943-28605590',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'LISTVIEW_ENTRY' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_630db5754a4bd',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630db5754a4bd')) {function content_630db5754a4bd($_smarty_tpl) {?>
<!--LIST VIEW RECORD ACTIONS--><div style="width:80px ;"><a class="deleteRecordButton" style=" opacity: 0; padding: 0 5px;"><i title="<?php echo vtranslate('LBL_DELETE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" class="fa fa-trash alignMiddle"></i></a><input style="opacity: 0;" <?php if ($_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->get('status')){?> checked value="on" <?php }else{ ?> value="off"<?php }?> data-on-color="success"  data-id="<?php echo $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getId();?>
" type="checkbox" name="workflowstatus" id="workflowstatus"></div><?php }} ?>