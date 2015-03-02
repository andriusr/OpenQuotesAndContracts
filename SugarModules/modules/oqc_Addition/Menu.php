<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings;
// 2.0 Disable creation of Additions- they can be created only from Contract

/* if(ACLController::checkAccess('oqc_Addition', 'edit', true))
	$module_menu[] = array(
		"index.php?module=oqc_Addition&action=EditView&return_module=oqc_Addition&return_action=DetailView",
		$mod_strings['LNK_NEW_RECORD'],
		"oqc_Addition",
		'oqc_Addition'
	);
// Disable also Listview - each Addition should be accessed only from related Contract
if(ACLController::checkAccess('oqc_Addition', 'list', true))
	$module_menu[] = array(
		"index.php?module=oqc_Addition&action=index&return_module=oqc_Addition&return_action=DetailView",
		$mod_strings['LNK_LIST'],
		"oqc_Addition",
		'oqc_Addition'
	);
	*/
?>
