<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings;


if(ACLController::checkAccess('oqc_ProductCatalog', 'edit', true))
	$module_menu[] = array(
		"index.php?module=oqc_ProductCatalog&action=EditView&return_module=oqc_ProductCatalog&return_action=DetailView",
		$mod_strings['LNK_NEW_RECORD'],
		"oqc_ProductCatalog",
		'oqc_ProductCatalog'
	);

if(ACLController::checkAccess('oqc_ProductCatalog', 'list', true))
	$module_menu[] = array(
		"index.php?module=oqc_ProductCatalog&action=index&return_module=oqc_ProductCatalog&return_action=DetailView",
		$mod_strings['LNK_LIST'],
		"oqc_ProductCatalog",
		'oqc_ProductCatalog'
	);

?>
