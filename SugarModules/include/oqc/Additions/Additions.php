<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('modules/oqc_Contract/oqc_Contract.php');

function getAdditionsHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}
 	
 	global $mod_strings;
	global $app_list_strings;
	//2.2RC2 translation eroor fix	
	
	$status_list = $app_list_strings["oqc_addition_status_dom"];
	
	$additions = $focus->getAdditions();

	foreach ($additions as &$addition) {
		$addition = $addition->toArray();
		if (isset($status_list[$addition['status']])) {
			$addition['status'] = $status_list[$addition['status']];
	
			}
	}
	global $sugar_version ;
	$smarty = new Sugar_Smarty;
	$smarty->assign('additions', $additions);
	$smarty->assign($mod_strings);
	
	if(substr($sugar_version,0,1) == '6') {
	return $smarty->fetch('include/oqc/Additions/' . $view . '.html');
	}
	else {
		return $smarty->fetch('include/oqc/Additions/' . $view . '52.html');
		}
}
?>
