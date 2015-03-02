<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('modules/oqc_Contract/oqc_Contract.php');

function getLinkToContract($focus, $name, $value, $view) {
	if (empty($focus->contractid)) {
		return "-";
	}
	
	$id = $focus->contractid;
	$module = 'oqc_Contract';
	$contract = new oqc_Contract();
	
	if ($contract->retrieve($id)) {
		if (! $contract->deleted) {
			$name = $contract->name;
			return "<a href='index.php?module=$module&action=DetailView&record=$id'>$name</a>";
		} else {
			return "-";
		}
	} else {
		// TODO handle exception
		return "-";
	}
}
?>