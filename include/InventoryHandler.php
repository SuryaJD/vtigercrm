<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

function handleInventoryProductRel($entity){
	require_once("include/utils/InventoryUtils.php");
	updateInventoryProductRel($entity);
}


function notifySnsLeadCreation($entity)
{
	$url = "http://crm-api.aerem.co/api/v1/webhook";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($entity->getData()));
	$contents = curl_exec($ch);
	curl_close($ch);
}

function NotifySnsAboutStatusChange($entity)
{
	$url = "http://crm-api.aerem.co/api/v1/webhook";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($entity->getData()));
	$contents = curl_exec($ch);
	curl_close($ch);
}



?>
