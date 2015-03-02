<?php
session_start(); 
header("Content-type: application/json");

$jsonArray = array();

if (array_key_exists('id', $_REQUEST)) {
    if(!defined('sugarEntry')) define('sugarEntry', true);
    chdir("..");
    require_once('include/entryPoint.php');
    require_once('modules/oqc_Product/oqc_Product.php');

    $originatingProduct = new oqc_Product();
    $id = $_REQUEST['id']; // the product id that we search in the packages
    
    if ($originatingProduct->retrieve($id,true,true)) { //Do not proceed for deleted products
      //  $previousVersions = $originatingProduct->getAllPreviousVersions();
      //  $interestingProductIds = array_merge(array($id), $previousVersions);

        $p = new oqc_Product();
        $products = $p->get_list('','is_latest = "1"');
        $products = $products['list'];

       // foreach ($interestingProductIds as $productId) {
            // iterate over all products. add those to the jsonArray that are packages containing the product specified by $id
            for ($i=0; $i<count($products); $i++) {
                if ($products[$i]->containsProductWithId($id)) {
                    // package contains the product with given id
                    // add its name and id to the packages array
                    $jsonArray[] = array(
                        "Name" => $products[$i]->name,
                        "Id" => $products[$i]->id,
                    );
                }
            }
     //   }
    }
}

require_once('include/utils.php');
$json = getJSONobj();
echo $json->encode(array('ResultSet'=>$jsonArray));
session_write_close();
?>
