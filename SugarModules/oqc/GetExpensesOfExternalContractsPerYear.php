<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
require_once('include/entryPoint.php');
require_once('modules/oqc_ExternalContract/oqc_ExternalContract.php');
require_once('modules/oqc_ExternalContractCosts/oqc_ExternalContractCosts.php');

$expenses = array();

$e = new oqc_ExternalContract();
$result  = $e->get_list('', 'deleted=0');
$externalContracts = $result['list'];

foreach ($externalContracts as $externalContract) {
	$costIds = explode(' ', $externalContract->costs);
	$c = new oqc_ExternalContractCosts();
	
	foreach ($costIds as $id) {
		if ($c->retrieve($id)) {
			if (!array_key_exists($c->year, $expenses)) {
				$expenses[$c->year] = array();
			}
			$expenses[$c->year][$c->category] += $c->price;
		}
	}
}

$chartData = array();

foreach ($expenses as $year=>$categories) {
	$chartData[] = array_merge(
		array(
			'year' => $year,
		),
		$categories
	);	
}

$json = getJSONobj();
$encoded = $json->encode($chartData);
echo($encoded);
?>