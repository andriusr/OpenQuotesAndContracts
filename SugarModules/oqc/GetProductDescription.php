<?php
session_start(); 
header("Content-type: application/json");

$jsonArray = array();

if (array_key_exists('id', $_REQUEST)) {
    if(!defined('sugarEntry')) define('sugarEntry', true);
    chdir("..");
    require_once('include/entryPoint.php');
    require_once('modules/oqc_Product/oqc_Product.php');

    $product = new oqc_Product();
        
    if ($product->retrieve($_REQUEST['id'])) {
    	// if we would not decode this the html tags in the description field would be outputted in encoded form using entities like &lt; &gt; ..
    	
    	 $jsonArray = array(
    	'Description' => html_entity_decode($product->description, ENT_COMPAT, 'UTF-8'),
    	'Vat' => ($product->oqc_vat === '') ? "default" : $product->oqc_vat,
    	'Attachments' => $product->getTechnicalDescriptions(), //returns Array of Array with doc_id, doc_name, rev_id 
    	);
    }
}

require_once('include/utils.php');
$json = getJSONobj();
echo $json->encode($jsonArray);
session_write_close();	
?>
