<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
require_once('include/entryPoint.php');
require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/oqc_Category/oqc_Category.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('modules/oqc_ProductCatalog/oqc_ProductCatalog.php');

function getProductUsage($id) {
	$productCatalog = new oqc_ProductCatalog();
	
	if ($productCatalog->retrieve($id)) {
		$frequency = array();
		
		$json = getJSONobj();
		
		$c = new oqc_Contract();
		$result = $c->get_list('', 'deleted=0');
		$allContracts = $result['list'];
		
		foreach ($allContracts as $contract) {
			// services of this contract
			$services = $contract->get_linked_beans('oqc_service', 'oqc_Service');
			
			foreach ($services as $service) {
				$product = new oqc_Product();
				// if the service refers to an existing product that is defined in this product catalog ...
				if ($product->retrieve($service->product_id) && $product->catalog_id == $id) {
					// increase the frequency of the appearance of this product 
					$frequency[$product->name]['rate'] += $service->quantity;
					
					if (!array_key_exists('category', $frequency[$product->name])) {
						$category = new oqc_Category();
						if ($category->retrieve($product->relatedcategory_id)) {
							$frequency[$product->name]['category'] = $category->name;	
						}
					}
				}
			}
		}
		
		$chartData = array();
		foreach ($frequency as $name=>$frequencyArray) {
			$chartData[] = array(
				'name' => $name,
				'frequency' => $frequencyArray['rate'],
				'category' => $frequencyArray['category'],
			);
		}
	
		$encoded = $json->encode($chartData); 
		echo($encoded);
	} else {
		echo "No Product Catalog with id='" + $id + "' found."; 
	}
}

if (!empty($_REQUEST) && array_key_exists('id', $_REQUEST)) {
	getProductUsage($_REQUEST['id']);
}

?>