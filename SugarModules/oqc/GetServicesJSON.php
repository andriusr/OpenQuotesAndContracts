<?php

function compare_position($a, $b) { 

return strnatcmp($a['Position'], $b['Position']); 
} 
session_start(); //1.7.6 avoids concurrent script execution since this might cause server errors; this results in longer rendering, but avoids 'Data error'! 
$jsonArray = array();
header("Content-type: application/json");
if (array_key_exists('m', $_REQUEST)) {
	$moduleName = $_REQUEST['m'];

	if ('oqc_Offering' === $moduleName || 'oqc_Contract' === $moduleName || 'oqc_Addition' === $moduleName) {
		if (array_key_exists('id', $_REQUEST)) {
			if(!defined('sugarEntry')) define('sugarEntry', true);

			chdir("..");
			require_once('include/entryPoint.php');
			require_once('include/oqc/common/common.php'); // required for getFormattedCurrencyValue method
			require_once('modules/oqc_Service/oqc_Service.php');
			require_once('modules/oqc_Product/oqc_Product.php');
			
			require_once("modules/{$moduleName}/{$moduleName}.php");
				
			$contract = new $moduleName();
				
			$isUniqueServices = true;
				
			if (array_key_exists('u', $_REQUEST)) {
				$isUniqueServices = '1' === $_REQUEST['u'];
			}
				
			if ($contract->retrieve($_REQUEST['id'])) {
				if (!$contract->load_relationship('oqc_service')) {
					trigger_error("could not load relationship to oqc_service. cannot return the services related to this offering/contract!");
				} else {
					$services = $contract->get_linked_beans('oqc_service', 'oqc_Service');
						
					foreach ($services as $service) {
						if (($isUniqueServices && 'once' === $service->zeitbezug) || (!$isUniqueServices && 'once' != $service->zeitbezug)) {
							$productDeleted = true;
							if (!empty($service->product_id)) {
								$product = new oqc_Product() ;
								
								if ($product->retrieve($service->product_id,true,true)) { //2.2RC1 do not retrieve deleted product here
									$productDeleted = false;
								}
								$updateable = (!$product->is_latest && !$productDeleted);	
								}
								else {$updateable = false;}
							//check if currency id is correct one
							
							$jsonArray[] = array(
								'Id' => $service->id,
								'Position' => $service->position, //1.7.7 position in the table
								'Tax' => ($service->oqc_vat === '') ? "default" : $service->oqc_vat, 
								'Name' => $service->name,
								'Description' => html_entity_decode($service->description), // Dispalays description of products correctly 
								'Unit' => $service->unit,
								'Price' => getFormattedCurrencyValue($service->price), // send a formatted price to the user.
								'Quantity' => $service->quantity,
								'Recurrence' => $service->zeitbezug,
								'ProductId' => $productDeleted ? '' : $service->product_id,
								'Discount' => $service->discount_select,
								'DiscountValue' => $service->discount_value,
								'Updateable' => $updateable, //1.7.7 Indicate whether this is latest version of product
                        'isSumRow' => false, // this is a service and no sum row in the table.
                        'Currency' => $service->service_currency_id ? $service->service_currency_id : "-99"
							);
						}
					}
					// 1.7.7 Do json array reordering according position value
					usort($jsonArray, 'compare_position');
				}
			}
		}
	}
}

if (array_key_exists('callback', $_REQUEST)) {

require_once('include/utils.php');
$json = getJSONobj();

echo $_REQUEST['callback'].'('.$json->encode(array('ResultSet'=>$jsonArray)).')';
}
else {
	require_once('include/utils.php');
	$json = getJSONobj();

	echo $json->encode(array('ResultSet'=>$jsonArray));
}
session_write_close();


?>
