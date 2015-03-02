<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings;

if(ACLController::checkAccess('oqc_Offering', 'edit', true))
	$module_menu[] = array(
		"index.php?module=oqc_Offering&action=EditView&return_module=oqc_Offering&return_action=DetailView",
		$mod_strings['LNK_NEW_RECORD'],
		"oqc_Offering",
		'oqc_Offering'
	);

if(ACLController::checkAccess('oqc_Offering', 'list', true))
	$module_menu[] = array(
		"index.php?module=oqc_Offering&action=index&return_module=oqc_Offering&return_action=DetailView",
		$mod_strings['LNK_LIST'],
		"oqc_Offering",
		'oqc_Offering'
	);
?>
