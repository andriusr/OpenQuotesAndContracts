<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings;

if(ACLController::checkAccess('oqc_TextBlock', 'edit', true))
	$module_menu[] = array(
		"index.php?module=oqc_TextBlock&action=EditView&return_module=oqc_TextBlock&return_action=DetailView",
		$mod_strings['LNK_NEW_RECORD'],
		"oqc_TextBlock",
		'oqc_TextBlock'
	);

if(ACLController::checkAccess('oqc_TextBlock', 'list', true))
	$module_menu[] = array(
		"index.php?module=oqc_TextBlock&action=index&return_module=oqc_TextBlock&return_action=DetailView",
		$mod_strings['LNK_LIST'],
		"oqc_TextBlock",
		'oqc_TextBlock'
	);
	
if(ACLController::checkAccess('oqc_TextBlock', 'import', true))
	$module_menu[]= array(
	"index.php?module=Import&action=Step1&import_module=oqc_TextBlock&return_module=oqc_TextBlock&return_action=index",
	 $app_strings['LBL_IMPORT'],
	 "Import",
	  'oqc_TextBlock'
	  );
?>
