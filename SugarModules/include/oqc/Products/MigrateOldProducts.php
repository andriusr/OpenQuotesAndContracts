<?php
if(!defined('sugarEntry')) define('sugarEntry', true);

chdir("../../..");
require_once('include/entryPoint.php');
require_once('modules/oqc_Product/oqc_Product.php');

$p = new oqc_Product();

$field = "oqc_product.packaged_product_ids";
$where = "$field IS NOT NULL AND NOT $field = ''";

$all = $p->get_list("", $where);
$all = $all['list'];

$url = 'https://' . $sugar_conf['host_name'] . '/index.php?module=oqc_Product&action=DetailView&record=';

foreach ($all as $packet) {
	if ("oqc_Product" === get_class($packet)) {
	// now we can be sure we look on a product instance..
	echo "Paket {$packet->name} <br />";
	
	$pairs = explode(' ', $packet->packaged_product_ids);
	$newPackagedProductValue = "";
	
	foreach ($pairs as $pair) {
		list($count, $id) = explode(':', $pair);

		$referencedProduct = new oqc_Product();
		if ($referencedProduct->retrieve($id)) {
			$unique = $referencedProduct->price > 0;
			$recurring = $referencedProduct->price_recurring > 0;
			
			$append = '';
			
			if ($unique && $recurring) {
				$packetUrl = $url . $packet->id;
				echo "Paket {$packet->name} muss nochmals angefasst werden, da bereits laufende und einmalige Kosten festgelegt sind, siehe $packetUrl <br />";
				continue;
			} else if ($unique) {
				$append = "1"; 
			} else if ($recurring) {
				$append = "0";	
			}

			$newPackagedProductValue .= $count . ":" . $id . ":" . $append . " ";
			
		}
	}
	
	echo "Setze Wert von '{$packet->packaged_product_ids}' auf '$newPackagedProductValue' <br />";
	$packet->packaged_product_ids = $newPackagedProductValue;
	// TODO
	// $packet->save();
	}
}

?>
