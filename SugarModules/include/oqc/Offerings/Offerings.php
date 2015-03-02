<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('modules/oqc_Offering/oqc_Offering.php');

function getLinkToOffering($focus, $name, $value, $view) {
	if (empty($focus->offeringid)) {
		return "-";
	}
	
	$id = $focus->offeringid;
	$module = 'oqc_Offering';
	$offering = new oqc_Offering();
	
	if ($offering->retrieve($id, true, true)) { //2.2RC1 do not show link if it is deleted
		$name = $offering->name;
		return "<a href='index.php?module=$module&action=DetailView&record=$id'>$name</a>";
	} else {
		// TODO handle exception
		return "-";
	}
}

?>