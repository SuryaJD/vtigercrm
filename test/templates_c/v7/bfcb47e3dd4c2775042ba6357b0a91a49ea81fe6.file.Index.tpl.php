<?php /* Smarty version Smarty-3.1.7, created on 2022-08-29 11:57:59
         compiled from "D:\xampp7\htdocs\vtigercrm\includes\runtime/../../layouts/v7\modules\ModuleBuilder\Index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:619402044630ca9c7359f94-20957497%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bfcb47e3dd4c2775042ba6357b0a91a49ea81fe6' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\vtigercrm\\includes\\runtime/../../layouts/v7\\modules\\ModuleBuilder\\Index.tpl',
      1 => 1661774217,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '619402044630ca9c7359f94-20957497',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'SELECTED_MODULE_NAME' => 0,
    'TKSMODULE' => 0,
    'QUALIFIED_MODULE' => 0,
    'MODULE_NAME' => 0,
    'USER_MODEL' => 0,
    'UNINSTALLURL' => 0,
    'MODULE_LABEL' => 0,
    'FIELDS_INFO' => 0,
    'NEW_FIELDS_INFO' => 0,
    'REQUEST_INSTANCE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_630ca9c75253f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630ca9c75253f')) {function content_630ca9c75253f($_smarty_tpl) {?>


<?php echo $_smarty_tpl->getSubTemplate ("modules/Vtiger/partials/Topbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="container-fluid app-nav"><div class="row"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("partials/SidebarHeader.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("ModuleHeader.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></div><div class="main-container main-container-ModuleBuilder"><div id="modnavigator" class="module-nav editViewModNavigator"><div class="hidden-xs hidden-sm mod-switcher-container"><?php echo $_smarty_tpl->getSubTemplate ("modules/Vtiger/partials/Menubar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></div><div class="container-fluid" id="layoutEditorContainer"><input id="selectedModuleName" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
" /><input type="hidden" id="selectedModuleLabel" value="<?php echo vtranslate($_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
" /><input type="hidden" id="token" name="token" value="<?php echo $_REQUEST['token'];?>
" /><input type="hidden" id="current_module" name="current_module" value="<?php echo $_smarty_tpl->tpl_vars['TKSMODULE']->value;?>
" /><div class="widget_header row"><label class="col-sm-2 textAlignCenter" style="padding-top: 8px;"><?php echo vtranslate('LBL_ADD_FIELD_TO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['TKSMODULE']->value;?>
</label><!--<div class="col-sm-6"><select class="select2 col-sm-6" name="layoutEditorModules"><option value=''><?php echo vtranslate('LBL_SELECT_OPTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value==$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value){?> selected <?php }?>><?php if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value=='Calendar'){?><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }else{ ?><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
<?php }?></option></select></div>--></div><span class="pull-right"><button class="btn btn-success hide download" type="button" id="download"data-container="body" data-toggle="popover" data-placement="left" data-content="<?php echo vtranslate('LBL_CLICK_DOWNLOAD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><i class="icon-download"></i>&nbsp;&nbsp;<strong><?php echo vtranslate('LBL_DOWNLOAD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><!--<button class="btn btn-success hide import" type="button" id="import"data-container="body" data-toggle="popover" data-placement="left" data-content="<?php echo vtranslate('LBL_CLICK_INSTALL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><strong><?php echo vtranslate('LBL_INSTALL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>			--></span><?php if ($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('is_admin')=='on'){?><span class="btn-group pull-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-wrench" alt="<?php echo vtranslate('LBL_SETTINGS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" title="<?php echo vtranslate('LBL_SETTINGS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"></i>&nbsp;&nbsp;<i class="caret"></i></button><ul class="dropdown-menu"><li><a href='<?php echo $_smarty_tpl->tpl_vars['UNINSTALLURL']->value;?>
'><?php echo vtranslate('LBL_UNINSTALL_MODULE_BUILDER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></li></ul></span><?php }?><br><br><?php if ($_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value){?><div class="contents tabbable" style="margin-left: 40px !important;overflow-y:scroll;height:500px"><ul class="nav nav-tabs layoutTabs massEditTabs"><li class="active detailviewTab"><a data-toggle="tab" href="#detailViewLayout"><strong><?php echo vtranslate('LBL_DETAILVIEW_LAYOUT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><li class="relatedListTab"><a data-toggle="tab" href="#relatedTabOrder"><strong><?php echo vtranslate('LBL_RELATION_SHIPS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li></ul><div class="tab-content layoutContent themeTableColor overflowVisible" ><div class="tab-pane active ibbb" id="detailViewLayout"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('FieldsList.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></div><div class="tab-pane active" id="relatedTabOrder"><div class="clear relatedListContainer"></div><!--class="relatedTabModulesList"--></div></div><form class="tks_modulevalidatetks" name="tks_moduleentityvalidate" id="tks_moduleentityvalidate" novalidate="novalidate" method="post"><div class='modal-overlay-footer clearfix'><div class="row clearfix"><div class='textAlignCenter col-lg-12 col-md-12 col-sm-12 '><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="action" value="BuildModule" /><input type="hidden" name="mode" value="saveModule" /><input type="hidden" id="noofblocks" name="noofblocks" value="1" /><input type="hidden" id="tkssequence" name="tkssequence" value="" /><input type="hidden" id="token" name="token" value="<?php echo $_REQUEST['token'];?>
" /><input type="hidden" id="selectedModuleName" name="selectedModuleName" value="<?php echo $_smarty_tpl->tpl_vars['MODULE_LABEL']->value;?>
" /><button type='submit' id='tks_moduleentityvalidate' class='btn btn-success saveButton' data-content='Click to build the module & zip' ><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button>&nbsp;&nbsp;<a class='cancelLink' href="javascript:history.back()" type="reset"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></div></div></div></form></div><?php }?></div><?php if ($_smarty_tpl->tpl_vars['FIELDS_INFO']->value!='[]'){?><script type="text/javascript">var uimeta = (function () {var fieldInfo = <?php echo $_smarty_tpl->tpl_vars['FIELDS_INFO']->value;?>
;var newFieldInfo = <?php echo $_smarty_tpl->tpl_vars['NEW_FIELDS_INFO']->value;?>
;return {field: {get: function (name, property) {if (name && property === undefined) {return fieldInfo[name];}if (name && property) {return fieldInfo[name][property]}},isMandatory: function (name) {if (fieldInfo[name]) {return fieldInfo[name].mandatory;}return false;},getType: function (name) {if (fieldInfo[name]) {return fieldInfo[name].type}return false;},getNewFieldInfo: function () {if (newFieldInfo['newfieldinfo']) {return newFieldInfo['newfieldinfo']}return false;}}};})();</script><?php }?><?php if (!$_smarty_tpl->tpl_vars['REQUEST_INSTANCE']->value->isAjax()){?><script type="text/javascript">
				jQuery(document).ready(function () {
					var instance = new ModuleBuilder_LayoutEditor_Js();
					instance.registerEvents();
				});
			</script><?php }?><?php }} ?>