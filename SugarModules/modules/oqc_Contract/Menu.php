<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings;

if(ACLController::checkAccess('oqc_Contract', 'edit', true))
	$module_menu[] = array(
		"index.php?module=oqc_Contract&action=EditView&return_module=oqc_Contract&return_action=DetailView",
		$mod_strings['LNK_NEW_RECORD'],
		"oqc_Contract",
		'oqc_Contract'
	);

if(ACLController::checkAccess('oqc_Contract', 'list', true))
	$module_menu[] = array(
		"index.php?module=oqc_Contract&action=index&return_module=oqc_Contract&return_action=DetailView",
		$mod_strings['LNK_LIST'],
		"oqc_Contract",
		'oqc_Contract'
	);
?>
