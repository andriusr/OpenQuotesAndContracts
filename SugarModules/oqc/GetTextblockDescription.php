<?php
session_start(); 
header("Content-type: application/json");
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
require_once('include/entryPoint.php');
require_once('modules/oqc_TextBlock/oqc_TextBlock.php');
if (array_key_exists('id', $_REQUEST)) {
	
$textblock = new oqc_TextBlock();
	if ($textblock->retrieve($_REQUEST['id'])) {

		require_once('include/utils.php');
		$json = getJSONobj();
		$jsonArray = array ( 0 =>
		array(
		"id" => $textblock->id,
		"title" => $textblock->name,
		"description" => html_entity_decode($textblock->description, ENT_COMPAT, 'UTF-8'),
						 ));
		$encoded = $json->encode($jsonArray);
		echo($encoded);
	}
}
session_write_close();

?>