<?php /* Smarty version Smarty-3.1.7, created on 2022-09-07 15:29:37
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/ModuleBuilder/ModuleBuilderBlocks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12681116946318b8e1790b80-67129908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f05c67988da17d917560605fa773c5674a758161' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/ModuleBuilder/ModuleBuilderBlocks.tpl',
      1 => 1662564516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12681116946318b8e1790b80-67129908',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'LEFTPANELHIDE' => 0,
    'NOOFBLOCK' => 0,
    'TOKEN' => 0,
    'MODULE_LABEL' => 0,
    'TKS_PARENT_MODULE' => 0,
    'PARENTTAB' => 0,
    'PARENTTABNAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6318b8e179d6a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6318b8e179d6a')) {function content_6318b8e179d6a($_smarty_tpl) {?>

<div class="main-container clearfix"><div id="modnavigator" class="module-nav editViewModNavigator"><div class="hidden-xs hidden-sm mod-switcher-container"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("partials/Menubar.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></div><div class="editViewPageDiv viewContent"><div class="col-sm-12 col-xs-12 content-area <?php if ($_smarty_tpl->tpl_vars['LEFTPANELHIDE']->value=='1'){?> full-width <?php }?>"><form class="tks_modulevalidate" name="tks_modulevalidate" id="tks_modulevalidate" novalidate="novalidate" method="post"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="action" value="InitModuleBuilder" /><input type="hidden" name="mode" value="initMB" /><input type="hidden" id="noofblocks" name="noofblocks" value="<?php echo $_smarty_tpl->tpl_vars['NOOFBLOCK']->value;?>
" /><input type="hidden" id="tkssequence" name="tkssequence" value="" /><input type="hidden" id="token" name="token" value="<?php echo $_smarty_tpl->tpl_vars['TOKEN']->value;?>
" /><input type="hidden" id="selectedModuleName" name="selectedModuleName" value="<?php echo $_smarty_tpl->tpl_vars['MODULE_LABEL']->value;?>
" /><div class="editViewHeader"><div class='row'><div class="col-lg-12 col-md-12 col-lg-pull-0"><h4 class="editHeader" style="margin-top:5px;"><?php echo vtranslate('LBL_CREATING_NEW',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h4></div></div></div><div class="editViewBody"><div class="editViewContents"><div name="editContent"><div class='fieldBlockContainer'><h4 class='fieldBlockHeader'><?php echo vtranslate('LBL_BASIC_INFORMATION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h4><hr><table class="table table-borderless"><tr><td class="fieldLabel alignMiddle"><?php echo vtranslate('MODULE_NAME',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<span class="redColor">*</span></td><td class="fieldValue"><input type="text" name="tks_modulename" id="tks_modulename" class="inputElement" data-fieldname="tks_modulename" value="">&nbsp;<a href="#" rel="tooltip" title="" data-original-title="<?php echo vtranslate('LBL_ENTER_MODULENAME',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><i class="fa fa-info-circle"></i></a></td><td class="fieldLabel alignMiddle"><?php echo vtranslate('MODULE_LABEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<span class="redColor">*</span></td><td class="fieldValue"><input type="text" name="tks_modulelabel" id="tks_modulelabel" class="inputElement" data-fieldname="tks_modulelabel" value="" data-fieldtype="string"  data-rule-required="true">&nbsp;<a href="#" rel="tooltip" title="" data-original-title="<?php echo vtranslate('LBL_ENTER_MODULELABEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><i class="fa fa-info-circle"></i></a></td></tr><tr><td class="fieldLabel alignMiddle"><?php echo vtranslate('PARENT_TAB_NAME',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<span class="redColor">*</span></td><td class="fieldValue"><select class="inputElement select2 select2-offscreen" data-fieldtype="picklist" name="tks_parent" id="tks_parent" ><?php  $_smarty_tpl->tpl_vars["PARENTTAB"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["PARENTTAB"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['TKS_PARENT_MODULE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["PARENTTAB"]->key => $_smarty_tpl->tpl_vars["PARENTTAB"]->value){
$_smarty_tpl->tpl_vars["PARENTTAB"]->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['PARENTTAB']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['PARENTTABNAME']->value!=''&&$_smarty_tpl->tpl_vars['PARENTTABNAME']->value==$_smarty_tpl->tpl_vars['PARENTTAB']->value){?> selected='selected' <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['PARENTTAB']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php } ?></select> &nbsp;<a href="#" rel="tooltip" title="" data-original-title="<?php echo vtranslate('SELECT_PARENT_TAB',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><i class="fa fa-info-circle"></i></a></td></tr></table></div></div></div></div><div class='modal-overlay-footer clearfix'><div class="row clearfix"><div class='textAlignCenter col-lg-12 col-md-12 col-sm-12 '><button type='button' id='nextStep' class='btn btn-success saveButton' ><?php echo vtranslate('LBL_NEXT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button>&nbsp;&nbsp;<a class='cancelLink' href="javascript:history.back()" type="reset"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></div></div></div></form></div></div></div><?php }} ?>