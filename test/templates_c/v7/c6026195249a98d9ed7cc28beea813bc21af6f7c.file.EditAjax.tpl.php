<?php /* Smarty version Smarty-3.1.7, created on 2022-08-03 12:31:01
         compiled from "D:\xampp7\htdocs\vtigercrm\includes\runtime/../../layouts/v7\modules\Settings\CronTasks\EditAjax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:112078524962ea6a855fd925-94133632%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c6026195249a98d9ed7cc28beea813bc21af6f7c' => 
    array (
      0 => 'D:\\xampp7\\htdocs\\vtigercrm\\includes\\runtime/../../layouts/v7\\modules\\Settings\\CronTasks\\EditAjax.tpl',
      1 => 1520586669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112078524962ea6a855fd925-94133632',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD_MODEL' => 0,
    'QUALIFIED_MODULE' => 0,
    'MODULE' => 0,
    'HEADER_TITLE' => 0,
    'RECORD' => 0,
    'VALUES' => 0,
    'FIELD_VALUE' => 0,
    'FIELD_INFO' => 0,
    'MINUTES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_62ea6a856c14b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62ea6a856c14b')) {function content_62ea6a856c14b($_smarty_tpl) {?>
<div class="modal-dialog modelContainer"><?php ob_start();?><?php echo vtranslate($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('name'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['HEADER_TITLE'] = new Smarty_variable($_tmp1, null, 0);?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("ModalHeader.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('TITLE'=>$_smarty_tpl->tpl_vars['HEADER_TITLE']->value), 0);?>
<div class="modal-content"><form class="form-horizontal" id="cronJobSaveAjax" method="post" action="index.php"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="parent" value="Settings" /><input type="hidden" name="action" value="SaveAjax" /><input type="hidden" name="record" value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value;?>
" /><input type="hidden" name="cronjob" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('name');?>
" /><input type="hidden" name="oldstatus" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('status');?>
" /><input type="hidden" id="minimumFrequency" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getMinimumFrequency();?>
" /><input type="hidden" name="frequency" id="frequency" value="" /><div class="modal-body"><div class="form-group"><label class="control-label fieldLabel col-xs-5"><?php echo vtranslate('LBL_STATUS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="controls fieldValue col-xs-5"><select class="select2 inputElement" name="status"><option <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('status')==1){?> selected="" <?php }?> value="1"><?php echo vtranslate('LBL_ACTIVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option <?php if ($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('status')==0){?> selected="" <?php }?> value="0"><?php echo vtranslate('LBL_INACTIVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option></select></div></div><div class="form-group"><label class="control-label fieldLabel col-xs-5"><?php echo vtranslate('Frequency',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><?php $_smarty_tpl->tpl_vars['VALUES'] = new Smarty_variable(explode(':',$_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getDisplayValue('frequency')), null, 0);?><?php if ($_smarty_tpl->tpl_vars['VALUES']->value[0]=='00'&&$_smarty_tpl->tpl_vars['VALUES']->value[1]=='00'){?><?php $_smarty_tpl->tpl_vars['MINUTES'] = new Smarty_variable("true", null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_VALUE'] = new Smarty_variable($_smarty_tpl->tpl_vars['VALUES']->value[1], null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['VALUES']->value[0]=='00'){?><?php $_smarty_tpl->tpl_vars['MINUTES'] = new Smarty_variable("true", null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_VALUE'] = new Smarty_variable($_smarty_tpl->tpl_vars['VALUES']->value[1], null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['VALUES']->value[1]=='00'){?><?php $_smarty_tpl->tpl_vars['MINUTES'] = new Smarty_variable("false", null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_VALUE'] = new Smarty_variable(($_smarty_tpl->tpl_vars['VALUES']->value[0]), null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars['MINUTES'] = new Smarty_variable("true", null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_VALUE'] = new Smarty_variable(($_smarty_tpl->tpl_vars['VALUES']->value[0]*60)+$_smarty_tpl->tpl_vars['VALUES']->value[1], null, 0);?><?php }?><div class="controls fieldValue col-xs-2"><input type="text" class="inputElement" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_VALUE']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD_INFO']->value["mandatory"]==true){?> data-rule-required="true" <?php }?> id="frequencyValue"/>&nbsp;</div><div class="controls fieldValue col-xs-3" style="padding-left: 0px;"><select class="select2 inputElement" id="time_format"><option value="mins" <?php if ($_smarty_tpl->tpl_vars['MINUTES']->value=='true'){?> selected="" <?php }?>><?php echo vtranslate('LBL_MINUTES',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option value="hours" <?php if ($_smarty_tpl->tpl_vars['MINUTES']->value=='false'){?>selected="" <?php }?>><?php echo vtranslate('LBL_HOURS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option></select></div></div><div class="form-group" style="text-align: center;"><div class="col-xs-2"></div><div class="col-xs-8"><div class="alert alert-info"><?php echo vtranslate($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('description'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div></div></div></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form></div></div>	
<?php }} ?>