<?php /* Smarty version Smarty-3.1.7, created on 2022-09-07 17:20:34
         compiled from "D:\xampp7\htdocs\aeremcrm\includes\runtime/../../layouts/v7\modules\ModuleBuilder\RelatedList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10412048896318d2e2d27658-26713568%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '781287a7dc67308ce9b829e913250121eb122706' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\aeremcrm\\includes\\runtime/../../layouts/v7\\modules\\ModuleBuilder\\RelatedList.tpl',
      1 => 1662571163,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10412048896318d2e2d27658-26713568',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'RELATED_LIST_COUNT' => 0,
    'RELATED_LIST' => 0,
    'k' => 0,
    'i' => 0,
    'moduletks' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6318d2e2d5059',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6318d2e2d5059')) {function content_6318d2e2d5059($_smarty_tpl) {?>


<div class="relatedTabModulesList"><?php $_smarty_tpl->tpl_vars['MODULE'] = new Smarty_variable('ModuleBuilder', null, 0);?><table class="table table-bordered blockContainer showInlineTable relatedlists"><tr><th class="module-title">&nbsp;</th><th class="module-title"><?php echo vtranslate('MODULE_NAME',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</th><th class="module-title"><?php echo vtranslate('SELECT_ACTION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
&nbsp;&nbsp;<i class="icon-info-sign alignMiddle" data-container="body" data-toggle="popover"data-placement="bottom" data-content="<?php echo vtranslate('LBL_SELECT_INFO',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></i></th><th class="module-title"><?php echo vtranslate('ADD_ACTION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
&nbsp;&nbsp;<i class="icon-info-sign alignMiddle" data-container="body" data-toggle="popover"data-placement="bottom" data-content="<?php echo vtranslate('LBL_ADD_INFO',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></i></th></tr><input type="hidden" name="tks_related_mod_cnt" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_LIST_COUNT']->value;?>
"  /><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, 0);?><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['RELATED_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><?php $_smarty_tpl->tpl_vars['moduletks'] = new Smarty_variable(getTranslatedString($_smarty_tpl->tpl_vars['k']->value,'$MODULE'), null, 0);?><tr class="relblock"><td><input type="checkbox" tabindex="" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="relcheck" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"/></td><td><?php echo $_smarty_tpl->tpl_vars['moduletks']->value;?>
<?php if ($_smarty_tpl->tpl_vars['k']->value=='Leads'){?>&nbsp;&nbsp;<i class="icon-info-sign alignMiddle" data-container="body" data-toggle="popover"data-placement="bottom" data-content="<?php echo vtranslate('LBL_LEAD_WARNING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></i><?php }?></td><td><input type="checkbox" tabindex="" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_sel" disabled="disabled" class="small relsel"></td><td><input type="checkbox" tabindex="" name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
_add"  disabled="disabled" class="small reladd"></td></tr><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?><?php } ?></table><!--class="table table-bordered blockContainer showInlineTable relatedlists"--></div><!--class="relatedTabModulesList"--><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><?php }} ?>