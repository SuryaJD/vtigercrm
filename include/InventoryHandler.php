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
	$url = "http://crmapi.test/api/v1/webhook";
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
	try{
		$myfile = fopen("curl_entity.txt", "w") or die("Unable to open file!");
		fwrite($myfile, json_encode($entity->getData()));
		fclose($myfile);
	}catch(\Throwable $th){
		$myfile = fopen("curl_entity_errr.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $th->getMessage());
		fclose($myfile);
	}


	try {
		$url = "https://crm-api.aerem.co/api/v1/webhook";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($entity->getData()));
		$contents = curl_exec($ch);
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			$myfile = fopen("curl_error.txt", "w") or die("Unable to open file!");
			fwrite($myfile, $error_msg);
			fclose($myfile);
		}else {
			$myfile = fopen("curl_success.txt", "w") or die("Unable to open file!");
			fwrite($myfile, $contents);
			fclose($myfile);
		}
		curl_close($ch);
	} catch (\Throwable $th) {
			error_log($th->getMessage());
	}



}
