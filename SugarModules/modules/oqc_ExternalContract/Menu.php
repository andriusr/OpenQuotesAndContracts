<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings;

if(ACLController::checkAccess('oqc_ExternalContract', 'edit', true))
	$module_menu[] = array(
		"index.php?module=oqc_ExternalContract&action=EditView&return_module=oqc_ExternalContract&return_action=DetailView",
		$mod_strings['LNK_NEW_RECORD'],
		"oqc_ExternalContract",
		'oqc_ExternalContract'
	);

if(ACLController::checkAccess('oqc_ExternalContract', 'list', true))
	$module_menu[] = array(
		"index.php?module=oqc_ExternalContract&action=index&return_module=oqc_ExternalContract&return_action=DetailView",
		$mod_strings['LNK_LIST'],
		"oqc_ExternalContract",
		'oqc_ExternalContract'
	);
?>
