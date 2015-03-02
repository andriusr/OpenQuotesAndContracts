<?php

session_start(); //1.7.6 avoids concurrent script execution since this might cause server errors; this results in longer rendering, but avoids 'Data error'!
$jsonArray = array();
global $app_strings;

if (array_key_exists('m', $_REQUEST)) {
	$moduleName = $_REQUEST['m'];

	if ('oqc_Product' === $moduleName) {
		if (array_key_exists('id', $_REQUEST)) {
			if(!defined('sugarEntry')) define('sugarEntry', true);
			 
			chdir("..");
			require_once('include/entryPoint.php');
			require_once('include/oqc/common/common.php'); // required for getFormattedCurrencyValue method
			require_once('modules/oqc_Service/oqc_Service.php');
			require_once("modules/{$moduleName}/{$moduleName}.php");
			require_once('modules/Currencies/Currency.php');

			$product = new oqc_Product();
			if ($product->retrieve($_REQUEST['id'])) {
				if (!empty($product->packaged_product_ids)) {
					$packaged_product_counts_and_ids = explode(' ', $product->packaged_product_ids);
					foreach ($packaged_product_counts_and_ids as $packaged_product_count_and_id) {
						list($packaged_product_count, $packaged_product_id, $isUnique) = explode(':', $packaged_product_count_and_id);

						$packaged_product = new oqc_Product();

						if ($packaged_product->retrieve($packaged_product_id)) {
							$currency_id = ($packaged_product->currency_id != '') ? $packaged_product->currency_id : '-99';
							//2.2RC1 send also currency id of the product, if not set, then default currency 
							// Convert price to default currency, if currency_id is set
							if ($currency_id != '-99') {
								$currency = new Currency();
								$currency->retrieve($currency_id);
								$packaged_product->price = $packaged_product->price / $currency->conversion_rate;
						//		$packaged_product->price_recurring = $packaged_product->price_recurring / $currency->conversion_rate; 
								}
							if ($packaged_product->deleted) {
								$packaged_product->name .= '<br>'. $app_strings['LBL_OQC_PRODUCT_DELETE']; }
							if (!$packaged_product->active) {
								$packaged_product->name .= '<br>'. $app_strings['LBL_OQC_PRODUCT_INACTIVE'];}
							$jsonArray[] = array(
							'Tax' => ($packaged_product->oqc_vat === '') ? "default" : $packaged_product->oqc_vat,
							'Quantity' => $packaged_product_count,
							'Name' => $packaged_product->name,
							'Unit' => $packaged_product->unit,
							'Price' => empty($packaged_product->is_recurring) ? getFormattedCurrencyValue($packaged_product->price) : '0.00', // send a formatted price to the user.
							'PriceRecurring' => empty($packaged_product->is_recurring) ? '0.00' : getFormattedCurrencyValue($packaged_product->price), // send a formatted price to the user.
							'CancellationPeriod' => $packaged_product->cancellationperiod,
							'MonthsGuaranteed' => $packaged_product->monthsguaranteed,
							'ProductId' => $packaged_product->deleted ? '' : $packaged_product_id,
							'UpdatedVersionAvailable' => (!$packaged_product->is_latest && !$packaged_product->deleted),
							// True if this product has been added as unique instead of recurring.
							// This is important for setting the correct column in the packaged products table zero
							'IsUnique' => empty($packaged_product->is_recurring),
							'Currency_id' => '-99' ,
						);
					}
				}
				
				}
			}
		}
	}
}

require_once('include/utils.php');
$json = getJSONobj();
header("Content-type: application/json");
echo $json->encode(array('ResultSet'=>$jsonArray));
session_write_close();
?>
