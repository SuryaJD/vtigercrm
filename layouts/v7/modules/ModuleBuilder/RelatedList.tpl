{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/LayoutEditor/views/Index.php *}

{strip}
	<div class="relatedTabModulesList">
	{assign var=MODULE value='ModuleBuilder'}
							<table class="table table-bordered blockContainer showInlineTable relatedlists">
								<tr>
									<th class="module-title">&nbsp;</th>
									<th class="module-title">{vtranslate('MODULE_NAME', $MODULE)}</th>
									<th class="module-title">
										{vtranslate('SELECT_ACTION', $MODULE)}
										&nbsp;&nbsp;
										<i class="icon-info-sign alignMiddle" data-container="body" data-toggle="popover" 
											data-placement="bottom" data-content="{vtranslate('LBL_SELECT_INFO', $MODULE)}"></i>
									</th>
									<th class="module-title">
									{vtranslate('ADD_ACTION', $MODULE)}
									&nbsp;&nbsp;
										<i class="icon-info-sign alignMiddle" data-container="body" data-toggle="popover" 
											data-placement="bottom" data-content="{vtranslate('LBL_ADD_INFO', $MODULE)}"></i>
									</th>
								</tr>
								<input type="hidden" name="tks_related_mod_cnt" value="{$RELATED_LIST_COUNT}"  />
								{assign var=i value=0}
									
								{foreach from=$RELATED_LIST key=k item=v}
								{assign var=moduletks value=$k|@getTranslatedString:'$MODULE'}
								<tr class="relblock">
									<td><input type="checkbox" tabindex="" value="{$k}" id="{$i}" class="relcheck" name="{$k}"/></td>
									<td>
										{$moduletks}
										{if $k eq 'Leads'}
										&nbsp;&nbsp;
										<i class="icon-info-sign alignMiddle" data-container="body" data-toggle="popover" 
											data-placement="bottom" data-content="{vtranslate('LBL_LEAD_WARNING', $MODULE)}"></i>
										{/if}	
									</td>
									<td><input type="checkbox" tabindex="" name="{$k}_sel" disabled="disabled" class="small relsel"></td>
									<td><input type="checkbox" tabindex="" name="{$k}_add"  disabled="disabled" class="small reladd"></td>
								</tr>
								{assign var=i value=$i+1}
								{/foreach}
							</table><!--class="table table-bordered blockContainer showInlineTable relatedlists"-->
						</div><!--class="relatedTabModulesList"-->
						<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
{/strip}