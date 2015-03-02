<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings;

if(ACLController::checkAccess('oqc_Product', 'edit', true))
	$module_menu[] = array(
		"index.php?module=oqc_Product&action=EditView&return_module=oqc_Product&return_action=DetailView",
		$mod_strings['LNK_NEW_RECORD'],
		"oqc_Product",
		'oqc_Product'
	);

if(ACLController::checkAccess('oqc_Product', 'list', true))
	$module_menu[] = array(
		"index.php?module=oqc_Product&action=index&return_module=oqc_Product&return_action=DetailView",
		$mod_strings['LNK_LIST'],
		"oqc_Product",
		'oqc_Product'
	);

if(ACLController::checkAccess('oqc_Product', 'import', true))
	$module_menu[]= array(
	"index.php?module=Import&action=Step1&import_module=oqc_Product&return_module=oqc_Product&return_action=index",
	 $app_strings['LBL_IMPORT'],
	 "Import",
	  'oqc_Product'
	  );

?>
