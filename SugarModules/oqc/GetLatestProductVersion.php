<?php

session_start();
header("Content-type: application/json");

$jsonArray = array();

if (array_key_exists('id', $_REQUEST)) {
    if(!defined('sugarEntry')) define('sugarEntry', true);
    chdir("..");
    require_once('include/entryPoint.php');
    require_once('include/oqc/common/common.php'); // required for getFormattedCurrencyValue method
    require_once('modules/oqc_Product/oqc_Product.php');
    require_once('modules/Currencies/Currency.php');

    $id = $_REQUEST['id']; // the product id that we search in the packages
    $p = new oqc_Product();

    if ($p->retrieve($id)) {
        $latestVersion = $p->getLatestRevision();
        //2.2RC1 send also currency id of the product, if not set, then default currency 
		  // Convert price to default currency, if currency_id is set
        $currency_id = ($latestVersion->currency_id != '') ? $latestVersion->currency_id : '-99';
		  if ($currency_id != '-99') {
				$currency = new Currency();
				$currency->retrieve($currency_id);
				$latestVersion->price = $latestVersion->price / $currency->conversion_rate;
		//		$latestVersion->price_recurring = $latestVersion->price_recurring / $currency->conversion_rate; 
		  }

        $jsonArray = array(
            'Tax' => ($latestVersion->oqc_vat === '') ? "default" : $latestVersion->oqc_vat,
            'Name' => $latestVersion->name,
            'Unit' => $latestVersion->unit,
            'Price' => empty($latestVersion->is_recurring) ? getFormattedCurrencyValue($latestVersion->price) :'0.00', // send a formatted price to the user.
            'PriceRecurring' => empty($latestVersion->is_recurring) ? '0.00' : getFormattedCurrencyValue($latestVersion->price), // send a formatted price to the user.
            'CancellationPeriod' => $latestVersion->cancellationperiod,
            'MonthsGuaranteed' => $latestVersion->monthsguaranteed,
            'ProductId' => $latestVersion->id,
            'Description' => html_entity_decode($latestVersion->description, ENT_COMPAT, 'UTF-8'), // Dispalays description of products correctly 
				'Attachments' => $latestVersion->getTechnicalDescriptions(), //returns Array of Array with doc_id, doc_name, rev_id 
            // 'Quantity' =>  // do not send quantity because it should not be overriden
            'Currency_id' => '-99',
            'IsUnique' => empty($latestVersion->is_recurring),
        );
    }
}

require_once('include/utils.php');
$json = getJSONobj();
echo $json->encode($jsonArray);
session_write_close();
?>
