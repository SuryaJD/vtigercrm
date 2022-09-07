<?php /* Smarty version Smarty-3.1.7, created on 2022-08-29 13:06:11
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/dashboards/DashBoardWidgetContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1314202861630cb9c3bed888-39513865%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7d8e28e2b43a82e1f82ed462d4340357feddbf2' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/dashboards/DashBoardWidgetContents.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1314202861630cb9c3bed888-39513865',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DATA' => 0,
    'YAXIS_FIELD_TYPE' => 0,
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_630cb9c3bf1b5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630cb9c3bf1b5')) {function content_630cb9c3bf1b5($_smarty_tpl) {?>
<?php if (count($_smarty_tpl->tpl_vars['DATA']->value)>0){?><input class="widgetData" type=hidden value='<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['DATA']->value));?>
' /><input class="yAxisFieldType" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['YAXIS_FIELD_TYPE']->value;?>
" /><div class="row" style="margin:0px 10px;"><div class="col-lg-11"><div class="widgetChartContainer" name='chartcontent' style="height:220px;min-width:300px; margin: 0 auto"></div><br></div><div class="col-lg-1"></div></div><?php }else{ ?><span class="noDataMsg"><?php echo vtranslate('LBL_NO');?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 <?php echo vtranslate('LBL_MATCHED_THIS_CRITERIA');?>
</span><?php }?><?php }} ?>