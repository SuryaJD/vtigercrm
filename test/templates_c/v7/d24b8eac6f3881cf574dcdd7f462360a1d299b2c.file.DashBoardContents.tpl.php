<?php /* Smarty version Smarty-3.1.7, created on 2022-09-07 16:25:58
         compiled from "D:\xampp7\htdocs\aeremcrm\includes\runtime/../../layouts/v7\modules\Vtiger\dashboards\DashBoardContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16310870686318c616e29b65-54984845%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd24b8eac6f3881cf574dcdd7f462360a1d299b2c' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\aeremcrm\\includes\\runtime/../../layouts/v7\\modules\\Vtiger\\dashboards\\DashBoardContents.tpl',
      1 => 1662567686,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16310870686318c616e29b65-54984845',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DASHBOARD_TABS' => 0,
    'TAB_DATA' => 0,
    'SELECTED_TAB' => 0,
    'MODULE' => 0,
    'DASHBOARD_TABS_LIMIT' => 0,
    'TABID' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_6318c616e4464',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6318c616e4464')) {function content_6318c616e4464($_smarty_tpl) {?>

    
<div class="dashBoardContainer clearfix"><div class="tabContainer"><ul class="nav nav-tabs tabs sortable container-fluid"><?php  $_smarty_tpl->tpl_vars['TAB_DATA'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TAB_DATA']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['DASHBOARD_TABS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TAB_DATA']->key => $_smarty_tpl->tpl_vars['TAB_DATA']->value){
$_smarty_tpl->tpl_vars['TAB_DATA']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['TAB_DATA']->key;
?><li class="<?php if ($_smarty_tpl->tpl_vars['TAB_DATA']->value["id"]==$_smarty_tpl->tpl_vars['SELECTED_TAB']->value){?>active<?php }?> dashboardTab" data-tabid="<?php echo $_smarty_tpl->tpl_vars['TAB_DATA']->value["id"];?>
" data-tabname="<?php echo $_smarty_tpl->tpl_vars['TAB_DATA']->value["tabname"];?>
"><a data-toggle="tab" href="#tab_<?php echo $_smarty_tpl->tpl_vars['TAB_DATA']->value["id"];?>
"><div><span class="name textOverflowEllipsis" value="<?php echo $_smarty_tpl->tpl_vars['TAB_DATA']->value["tabname"];?>
" style="width:10%"><strong><?php echo $_smarty_tpl->tpl_vars['TAB_DATA']->value["tabname"];?>
</strong></span><span class="editTabName hide"><input type="text" name="tabName"/></span><?php if ($_smarty_tpl->tpl_vars['TAB_DATA']->value["isdefault"]==0){?><i class="fa fa-close deleteTab"></i><?php }?><i class="fa fa-bars moveTab hide"></i></div></a></li><?php } ?><div class="moreSettings pull-right"><div class="dropdown dashBoardDropDown"><button class="btn btn-default reArrangeTabs dropdown-toggle" type="button" data-toggle="dropdown"><?php echo vtranslate('LBL_MORE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
&nbsp;&nbsp;<span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right moreDashBoards"><li id="newDashBoardLi"<?php if (count($_smarty_tpl->tpl_vars['DASHBOARD_TABS']->value)==$_smarty_tpl->tpl_vars['DASHBOARD_TABS_LIMIT']->value){?>class="disabled"<?php }?>><a class = "addNewDashBoard" href="#"><?php echo vtranslate('LBL_ADD_NEW_DASHBOARD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></li><li><a class = "reArrangeTabs" href="#"><?php echo vtranslate('LBL_REARRANGE_DASHBOARD_TABS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></li></ul></div><button class="btn-success updateSequence pull-right hide"><?php echo vtranslate('LBL_SAVE_ORDER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button></div></ul><div class="tab-content"><?php  $_smarty_tpl->tpl_vars['TAB_DATA'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TAB_DATA']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['DASHBOARD_TABS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TAB_DATA']->key => $_smarty_tpl->tpl_vars['TAB_DATA']->value){
$_smarty_tpl->tpl_vars['TAB_DATA']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['TAB_DATA']->key;
?><div id="tab_<?php echo $_smarty_tpl->tpl_vars['TAB_DATA']->value["id"];?>
" data-tabid="<?php echo $_smarty_tpl->tpl_vars['TAB_DATA']->value["id"];?>
" data-tabname="<?php echo $_smarty_tpl->tpl_vars['TAB_DATA']->value["tabname"];?>
" class="tab-pane fade <?php if ($_smarty_tpl->tpl_vars['TAB_DATA']->value["id"]==$_smarty_tpl->tpl_vars['SELECTED_TAB']->value){?>in active<?php }?>"><?php if ($_smarty_tpl->tpl_vars['TAB_DATA']->value["id"]==$_smarty_tpl->tpl_vars['SELECTED_TAB']->value){?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/DashBoardTabContents.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('TABID'=>$_smarty_tpl->tpl_vars['TABID']->value), 0);?>
<?php }?></div><?php } ?></div></div></div><?php }} ?>