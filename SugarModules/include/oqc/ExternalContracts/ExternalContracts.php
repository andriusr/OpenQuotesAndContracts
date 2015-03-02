<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');
require_once('include/oqc/common/common.php');
require_once('modules/Currencies/Currency.php');
require_once('include/QuickSearchDefaults.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('modules/oqc_ExternalContract/oqc_ExternalContract.php');
require_once('modules/oqc_ExternalContractPositions/oqc_ExternalContractPositions.php');
require_once('modules/oqc_ExternalContractCosts/oqc_ExternalContractCosts.php');

// TODO Remove?
function getSVNumberQuicksearch($name, $idName) {
	global $app_strings;

	$sqsObjects = array(
		'svnumber' => array(  	'method' => 'query',
						'modules' => array('oqc_Contract'),
						'field_list' => array('svnumber', 'id'),
						'populate_list' => array($name, $idName),
						'group' => 'or',
						'conditions' => array(
							array('name'=>'svnumber','op'=>'like_custom','end'=>'%','value'=>''),
						),
						'limit' => '30',
						'order'=>'svnumber',
						'no_match_text' => $app_strings['ERR_SQS_NO_MATCH'])
	);
	
	$json = getJSONobj();
	$qsd = new QuickSearchDefaults();
	$sqsJavascript = $qsd->getQSScripts();
	//$sqsJavascript .= '<script type="text/javascript" language="javascript">sqs_objects = ' . $json->encode($sqsObjects) . ';';
	$sqsJavascript .= '<script type="text/javascript" language="javascript">sqs_objects = {};';
	$sqsJavascript .= '</script>';
	
	return $sqsJavascript;
}

function getSVNumbersHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}

	global $app_list_strings;
	global $sugar_config;
	$json = getJSONobj();
	
	$svnumbersSmartyArray = $focus->getSVNumbersArray();
	
	$svnumberQuicksearch = getSVNumberQuicksearch('svnumber', 'svnumber_id');
	
	$smarty = new Sugar_Smarty;
	$smarty->assign('sugarDateFormat', getSugarCrmLocale('datef'));
	//$smarty->assign('sugarDateFormat', $sugar_config['default_date_format']);
	$smarty->assign('sqsJavaScript', $svnumberQuicksearch);
	$smarty->assign('svnumbersArray', $svnumbersSmartyArray);
	$smarty->assign('languageStringsCommon', getLanguageStrings("common"));
	
	if ('DetailView' === $view) {
		// transfer ide into ajvascript code so that we can determine the urls in the ajax call
		$smarty->assign('id', $focus->id);
//		$smarty->assign('languageStringsDocuments', getLanguageStrings('Documents'));
	}
	
	$sep = get_number_seperators();
	$smarty->assign('sugarDecimalSeperator', $sep[1]);
	
	return $smarty->fetch('include/oqc/ExternalContracts/SVNumbers.' . $view . '.html');
}

function getCostsHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}

	global $app_list_strings;
	$costsArray = $focus->getCostsArray();
 	
	$smarty = new Sugar_Smarty;
	$smarty->assign('costsArray', $costsArray);
	$smarty->assign('externalContractId', $focus->id);
	$smarty->assign('getExpensesUrl', 'oqc/GetExpenses.php?id=' . $focus->id);
	$smarty->assign('expensesExternalContractsUrl', 'oqc/GetExpensesOfExternalContractsPerYear.php');
	$smarty->assign('infinityHint', $app_list_strings["oqc"]["ExternalContracts"]["infinityHint"]);
	if ('DetailView' === $view) {
		$smarty->assign('startdate', $focus->startdate);
		$smarty->assign('enddate', $focus->enddate);	
	}
	global $sugar_version ;
	if(substr($sugar_version,0,1) == '5') {
		return $smarty->fetch('include/oqc/ExternalContracts/Costs.' . $view . '52.html');
	}
	else {
		return $smarty->fetch('include/oqc/ExternalContracts/Costs.' . $view . '.html');
	}
}

function getPositionsHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}

	$positionSmartyArray = $focus->getPositionsArray();
	
	$smarty = new Sugar_Smarty;
	$smarty->assign('positionsArray', $positionSmartyArray);
	return $smarty->fetch('include/oqc/ExternalContracts/Positions.' . $view . '.html');
}

// TODO remove
function getVersionsHtml($focus, $name, $value, $view) {
	return "versions";
}

?>
