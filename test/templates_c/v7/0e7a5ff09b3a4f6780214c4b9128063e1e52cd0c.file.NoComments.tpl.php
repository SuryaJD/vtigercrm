<?php /* Smarty version Smarty-3.1.7, created on 2022-09-13 14:17:33
         compiled from "D:\xampp7\htdocs\aeremcrm\includes\runtime/../../layouts/v7\modules\Vtiger\NoComments.tpl" */ ?>
<?php /*%%SmartyHeaderCode:904494383632090fd87f8e3-39822371%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e7a5ff09b3a4f6780214c4b9128063e1e52cd0c' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\aeremcrm\\includes\\runtime/../../layouts/v7\\modules\\Vtiger\\NoComments.tpl',
      1 => 1662567686,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '904494383632090fd87f8e3-39822371',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_632090fd88248',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_632090fd88248')) {function content_632090fd88248($_smarty_tpl) {?>
<div class="noCommentsMsgContainer noContent"><p class="textAlignCenter"> <?php echo vtranslate('LBL_NO_COMMENTS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</p></div><?php }} ?>