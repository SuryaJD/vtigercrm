<?php /* Smarty version Smarty-3.1.7, created on 2022-09-02 11:48:46
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/uitypes/BooleanFieldSearchView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11805110866311ed9e2f3232-11609441%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a02858df278a137780cd3e890df2476f674b532d' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/uitypes/BooleanFieldSearchView.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11805110866311ed9e2f3232-11609441',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELD_MODEL' => 0,
    'SEARCH_INFO' => 0,
    'FIELD_INFO' => 0,
    'SEARCH_VALUES' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6311ed9e2fb89',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6311ed9e2fb89')) {function content_6311ed9e2fb89($_smarty_tpl) {?>
<?php $_smarty_tpl->tpl_vars["FIELD_INFO"] = new Smarty_variable(Zend_Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo()), null, 0);?><?php $_smarty_tpl->tpl_vars['SEARCH_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['SEARCH_INFO']->value['searchValue'], null, 0);?><div class=""><select class="select2 listSearchContributor" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
" style="width:90px;" data-fieldinfo='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD_INFO']->value, ENT_QUOTES, 'UTF-8', true);?>
'><option value=""><?php echo vtranslate('LBL_SELECT_OPTION','Vtiger');?>
</option><option value="1" <?php if ($_smarty_tpl->tpl_vars['SEARCH_VALUES']->value==1){?> selected<?php }?>><?php echo vtranslate('LBL_YES',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><option value="0" <?php if ($_smarty_tpl->tpl_vars['SEARCH_VALUES']->value=='0'){?> selected<?php }?>><?php echo vtranslate('LBL_NO',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option></select></div><?php }} ?>