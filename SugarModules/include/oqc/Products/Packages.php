<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function getPackagesHtml($focus, $name, $value, $view) {
    if ('EditView' != $view && 'DetailView' != $view) {
        return ""; // skip the rest of the method if another view calls this method
    }
    require_once('include/utils.php');
	 require_once('include/Sugar_Smarty.php');
	 global $app_strings;
	 $oqcYUI = array();
	 $oqcYUI['LBL_NO_RECORDS_MESSAGE'] = $app_strings['LBL_NO_RECORDS_MESSAGE'];
	 $oqcYUI['LBL_DATA_ERROR_MESSAGE'] = $app_strings['LBL_DATA_ERROR_MESSAGE'];
	 $oqcYUI['LBL_LOADING_MESSAGE'] = $app_strings['LBL_LOADING_MESSAGE'];
	 $json = getJSONobj();
	 $oqcYUIjson = $json->encode($oqcYUI);
    
    $smarty = new Sugar_Smarty;
    $smarty->assign('id', $focus->id);
	 $smarty->assign('oqcYUIMessages', $oqcYUIjson);
    return $smarty->fetch('include/oqc/Products/Packages.' . $view . '.html');
}
?>