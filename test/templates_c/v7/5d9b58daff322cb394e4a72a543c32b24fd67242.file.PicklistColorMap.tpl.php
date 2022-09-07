<?php /* Smarty version Smarty-3.1.7, created on 2022-08-29 14:06:50
         compiled from "/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/PicklistColorMap.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1067460746630cc7fa73b749-63854371%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d9b58daff322cb394e4a72a543c32b24fd67242' => 
    array (
      0 => '/home/cleavr/crm.aerem.co/releases/20220829125755046/includes/runtime/../../layouts/v7/modules/Vtiger/PicklistColorMap.tpl',
      1 => 1661777882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1067460746630cc7fa73b749-63854371',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LISTVIEW_HEADERS' => 0,
    'FIELD_MODEL' => 0,
    'FIELD_NAME' => 0,
    'PICKLIST_COLOR_MAP' => 0,
    'PICKLIST_COLOR' => 0,
    'PICKLIST_VALUE' => 0,
    'CONVERTED_PICKLIST_VALUE' => 0,
    'PICKLIST_TEXT_COLOR' => 0,
    'MODULE_NAME' => 0,
    'MODULE_MODEL' => 0,
    'RELATED_MODULE_NAME' => 0,
    'RELATED_MODULE' => 0,
    'SOURCE_MODULE' => 0,
    'STATUS_FIELD' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_630cc7fa74eb2',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_630cc7fa74eb2')) {function content_630cc7fa74eb2($_smarty_tpl) {?>

<style type="text/css">
    <?php  $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['LISTVIEW_HEADERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_MODEL']->key => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value){
$_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELD_NAME']->value = $_smarty_tpl->tpl_vars['FIELD_MODEL']->key;
?>
        <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=='picklist'||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=='multipicklist'){?>
            <?php $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('_name'), null, 0);?>
            <?php if ($_smarty_tpl->tpl_vars['FIELD_NAME']->value==''){?>
                <?php $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName(), null, 0);?>
            <?php }?>
            <?php $_smarty_tpl->tpl_vars['PICKLIST_COLOR_MAP'] = new Smarty_variable(Settings_Picklist_Module_Model::getPicklistColorMap($_smarty_tpl->tpl_vars['FIELD_NAME']->value,true), null, 0);?>
            <?php  $_smarty_tpl->tpl_vars['PICKLIST_COLOR'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_COLOR_MAP']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->key => $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->value){
$_smarty_tpl->tpl_vars['PICKLIST_COLOR']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value = $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->key;
?>
                <?php $_smarty_tpl->tpl_vars['PICKLIST_TEXT_COLOR'] = new Smarty_variable(decode_html(Settings_Picklist_Module_Model::getTextColor($_smarty_tpl->tpl_vars['PICKLIST_COLOR']->value)), null, 0);?>
                <?php $_smarty_tpl->tpl_vars['CONVERTED_PICKLIST_VALUE'] = new Smarty_variable(Vtiger_Util_Helper::convertSpaceToHyphen($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value), null, 0);?>
                    .picklist-<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getId();?>
-<?php echo Vtiger_Util_Helper::escapeCssSpecialCharacters($_smarty_tpl->tpl_vars['CONVERTED_PICKLIST_VALUE']->value);?>
 {
                        background-color: <?php echo $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->value;?>
;
                        color: <?php echo $_smarty_tpl->tpl_vars['PICKLIST_TEXT_COLOR']->value;?>
; 
                    }
            <?php } ?>
        <?php }?>
    <?php } ?>
    <?php if (($_smarty_tpl->tpl_vars['MODULE_NAME']->value=='Calendar'&&$_smarty_tpl->tpl_vars['MODULE_MODEL']->value)||($_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value=='Calendar'&&$_smarty_tpl->tpl_vars['RELATED_MODULE']->value)||($_smarty_tpl->tpl_vars['SOURCE_MODULE']->value=='Calendar')){?>
		<?php $_smarty_tpl->tpl_vars['STATUS_FIELD'] = new Smarty_variable(Vtiger_Field_Model::getInstance('eventstatus',Vtiger_Module_Model::getInstance('Events')), null, 0);?>

        <?php if ($_smarty_tpl->tpl_vars['STATUS_FIELD']->value){?>
            <?php $_smarty_tpl->tpl_vars['PICKLIST_COLOR_MAP'] = new Smarty_variable(Settings_Picklist_Module_Model::getPicklistColorMap('eventstatus',true), null, 0);?>
            <?php  $_smarty_tpl->tpl_vars['PICKLIST_COLOR'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_COLOR_MAP']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->key => $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->value){
$_smarty_tpl->tpl_vars['PICKLIST_COLOR']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value = $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->key;
?>
                <?php $_smarty_tpl->tpl_vars['PICKLIST_TEXT_COLOR'] = new Smarty_variable(Settings_Picklist_Module_Model::getTextColor($_smarty_tpl->tpl_vars['PICKLIST_COLOR']->value), null, 0);?>
                <?php $_smarty_tpl->tpl_vars['CONVERTED_PICKLIST_VALUE'] = new Smarty_variable(Vtiger_Util_Helper::convertSpaceToHyphen($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value), null, 0);?>
                    .picklist-<?php echo $_smarty_tpl->tpl_vars['STATUS_FIELD']->value->getId();?>
-<?php echo Vtiger_Util_Helper::escapeCssSpecialCharacters($_smarty_tpl->tpl_vars['CONVERTED_PICKLIST_VALUE']->value);?>
 {
                        background-color: <?php echo $_smarty_tpl->tpl_vars['PICKLIST_COLOR']->value;?>
;color: <?php echo $_smarty_tpl->tpl_vars['PICKLIST_TEXT_COLOR']->value;?>
;
                    }
            <?php } ?>
        <?php }?>
    <?php }?>
</style>
<?php }} ?>