<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
require_once('include/entryPoint.php');
require_once('modules/oqc_ExternalContract/oqc_ExternalContract.php');

$externalContract = new oqc_ExternalContract();

if ($externalContract->retrieve($_REQUEST['id'])) {
	$json = getJSONobj();
	$costs = $externalContract->getCostsArray();
	$spendForCategory = array();
	
	foreach ($costs as $cost) {
		$spendForCategory[$cost['category']] += floatval($cost['price']);
	}

	$chartData = array();
	foreach ($spendForCategory as $category=>$price) {
		$chartData[] = array(
			'category' => $category,
			'price' => $price,
		);
	}

	$encoded = $json->encode($chartData); 
	echo($encoded);
} else {
	echo "No External Contract with id='" + $_REQUEST['id'] + "' found."; 
}
?>