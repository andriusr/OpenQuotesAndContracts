<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings;

if(ACLController::checkAccess('oqc_Task', 'edit', true))
	$module_menu[] = array(
		"index.php?module=oqc_Task&action=EditView&return_module=oqc_Task&return_action=DetailView",
		$mod_strings['LNK_NEW_RECORD'],
		"oqc_Task",
		'oqc_Task'
	);

if(ACLController::checkAccess('oqc_Task', 'list', true))
	$module_menu[] = array(
		"index.php?module=oqc_Task&action=index&return_module=oqc_Task&return_action=DetailView",
		$mod_strings['LNK_LIST'],
		"oqc_Task",
		'oqc_Task'
	);

?>
