<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');
require_once('include/oqc/common/common.php');
require_once('modules/oqc_Contract/SimpleTree.php');
require_once('modules/oqc_Category/oqc_Category.php');
require_once('modules/oqc_ProductCatalog/oqc_ProductCatalog.php');
require_once('modules/oqc_Product/oqc_Product.php');

function get_catalog_names() {
	$catalog_names = array();
	
	$bean = new oqc_ProductCatalog();
	$catalogs = $bean->get_full_list();
	
	if (!empty($catalogs)) {
		foreach ($catalogs as $catalog) {
			$catalog_names[$catalog->id] = $catalog->name;
		}
	}

	return $catalog_names;
}
//2.0 Modifications for options and products showup in categories tree
function get_all_linked_product_options_for_catalog($product_id) {
	$optionsIds = explode(' ', trim($product_id));
	$options = array();

	foreach ($optionsIds as $id) {
		$option = new oqc_Product();

		if ($option->retrieve($id)) {
			if ($option->is_latest == 1) {
				if (($option->active == 1) && ($option->publish_state == 'published')) {
				$options[] = $option;
				} 
			} else {
				$option = $option->getLatestRevision();
					if (($option->active == 1) && ($option->publish_state == 'published')) {
					$options[] = $option;	
					}
				}	
		}
	}

	return $options;
}

function oqc_getOptionsArray($sequence, $counter_string, $view, $focus) {
	$optionitems = array();
			
	if (!empty($sequence)) {
		$options = get_all_linked_product_options_for_catalog($sequence);
		$option_counter = range('1', count($options));
		foreach ($options as $option) {
			$new_counter_string = $counter_string.'.'.$option_counter;
			$optionitems[] = array (
			'key' => $option->id,
			'title' => ($view === 'DetailView') ? ($new_counter_string. ' '. $option->name ) : $option->name ,
			'description' => from_html($option->description),
			'isProduct' => false,
			'isOption' => true,
			'children' => oqc_getOptionsArray($option->optionssequence, $new_counter_string),
			'href' => ($view === 'DetailView') ? oqc_getProductLink($option->id) : oqc_getProductEditLink($option->id, $focus),
			);
			next($option_counter);
		}
	}
	return $optionitems;
	
}

function oqc_getProductLink($id) {
	
	$link = "index.php?module=oqc_Product&action=DetailView&record=".$id;
	return $link;
	
	}
	
function oqc_getProductEditLink($id, $focus) {
	
	$link = "index.php?module=oqc_Product&action=EditView&record=".$id."&return_module=oqc_ProductCatalog&return_action=EditView&return_id=".$focus->id;
	return $link;
	
	}

function oqc_compare_catalog_position($a, $b) { 
	return strnatcmp($a['catalog_position'], $b['catalog_position']); 
}


//1.7.7 modification for building tree with products
function insertTreeProducts($category, $view, $focus) {
		
			$bean = new oqc_Product();
			// get all products of the desired category 
		//	$products = $bean->get_full_list("", "relatedcategory_id='{$category->id}' and publish_state = 'published' and oqc_product.active=1 and is_latest=1 and  is_option=0"); //1.7.6 extra conditions active and is_latest since produst are not deleted
			$products = $bean->get_full_list("", "relatedcategory_id='{$category->id}' and publish_state = 'published' and oqc_product.active=1 and is_latest=1 and is_option=0"); //2.2RC1 options as products causes logic troubles
			$productitems = array();
			
				if(!empty($products)) {
					$productsArray = array();
					$counter = range('a', chr(ord('a') + count($products) - 1));
						foreach($products as $product) {
							$productsArray[] = $product->toArray(true);
						}
					usort($productsArray, 'oqc_compare_catalog_position');			
					foreach ($productsArray as $productArray) {
						$optionitems = array();
			
						if (!empty($productArray['optionssequence'])) {
							$options = get_all_linked_product_options_for_catalog($productArray['optionssequence']);
							$option_counter = range('1', count($options));
								foreach ($options as $option) {
									$counter_string = $category->number .'.'. current($counter) . '.'. current($option_counter);
									$children = oqc_getOptionsArray($option->optionssequence, $counter_string, $view, $focus);
									$optionitems[] = array (
									'key' => $option->id,
									'title' => ($view === 'DetailView') ? ($counter_string.' '. $option->name) : $option->name ,
									'children' => $children,
									'isProduct' => false,
									'isOption' => true,
									'isFolder' => !empty($children) ? true :false,
									'icon' => empty($children) ? 'Option_empty.gif' : 'Option_notempty.gif',
									'description' => from_html($option->description),
									'href' => ($view === 'DetailView') ? oqc_getProductLink($option->id) : oqc_getProductEditLink($option->id, $focus),
								);
								next($option_counter);
								}
						}
						$productitems[] = array (
						'key' => $productArray['id'],
						'title' => ($view === 'DetailView') ? ($category->number. '.' . current($counter). ' '. $productArray ['name']) : $productArray ['name'] ,
						'children' => $optionitems,
						'isProduct' => true,
						'isOption' => false,
						'description' => from_html($productArray['description']),
						'isFolder' => !empty($optionitems) ? true :false,
						'icon' => empty($productArray['optionssequence']) ? 'Product_empty.gif' :'Product_notempty.gif',
						'href' => ($view === 'DetailView') ? oqc_getProductLink($productArray['id']) : oqc_getProductEditLink($productArray['id'], $focus),
						);
//			$GLOBALS['log']->error("product catalog: ". var_export($productitems,true));
						next($counter);	
					}
				}
		return $productitems ;
			
		}
// End 2.0 modifications

function getSubCategoriesWithProductsAsJsonFormattedArray($category, $subCategories, $view, $focus) {
	$items = array();
	$productitems = array();
	$finalitems = array();
	$productitems = insertTreeProducts($category, $view, $focus);

	foreach ($subCategories as $c) {
		$items[] = getSubCategoriesWithProductsAsJsonFormattedArray($c['category'], $c['subcategories'], $view, $focus);
		
	}
	$finalitems = array_merge($productitems, $items);
	return array(
		'key' => $category->id,
		'title' => ($view === 'DetailView') ? ($category->number . ' ' . $category->name) : ($category->name), // 'text' => $this->name . " (" . from_html($this->description) . ")",
		'children' => $finalitems,
		'isFolder' => !empty($finalitems) ? true : false,
		'isProduct' => false,
		'isOption' => false,
		'icon' => !empty($finalitems) ? 'Category_notempty.gif' : 'Category_empty.gif',
		'description' => from_html($category->description),
	);
}
//1.7.7 End of modification 

function getSubCategoriesAsJsonFormattedArray($category, $subCategories, $view) {
	$items = array();

	foreach ($subCategories as $c) {
		$items[] = getSubCategoriesAsJsonFormattedArray($c['category'], $c['subcategories'], $view);
	}

	return array(
		'id' => $category->id,
		'text' => ($view === 'DetailView') ? ($category->number . ' ' . $category->name) : ($category->name), // 'text' => $this->name . " (" . from_html($this->description) . ")",
		'item' => $items,
	);
}


function getCategoryJSONData($categoryArray, $view, $focus) {
	$categoryJsonData = array();
	if($view == 'EditView') {
	foreach ($categoryArray as $c) {
		//$categoryJsonData[] = getSubCategoriesAsJsonFormattedArray($c['category'], $c['subcategories'], $view);
		$categoryJsonData[] = getSubCategoriesWithProductsAsJsonFormattedArray($c['category'], $c['subcategories'], $view, $focus);
	}
	}
	// 1.7.7 if DetailView include also products into tree 
	elseif ($view == 'DetailView') {
	foreach ($categoryArray as $c) {
		$categoryJsonData[] = getSubCategoriesWithProductsAsJsonFormattedArray($c['category'], $c['subcategories'], $view, $focus);
	}	
		
		
		
	}
	return $categoryJsonData;
}

function getCategoriesAsList($categoryArray) {
	$list = array();

	foreach ($categoryArray as $c) {
		$list[] = $c['category']->toArray();
		if (array_key_exists('subcategories', $c) && !empty($c['subcategories'])) {
			$list = array_merge($list, getCategoriesAsList($c['subcategories']));
		}
	}

	return $list;
}

function getProductCategoriesHTML($focus, $name, $value, $view) {
	
	global $app_list_strings;
   global $mod_strings;
   global $current_user;
	
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}

	if (empty($focus->id)) {
		$focus->id = ""; // set id to empty string to enable search (getAllCategories)
	}

	$json = getJSONobj();
	$languageStringsJson = $json->encode($mod_strings);
	$smarty = new Sugar_Smarty();
	
	//tinyMCE languege file detection
	$langDefault = 'en';
	$lang = substr($GLOBALS['current_language'], 0, 2);
   if(file_exists('include/oqc/tinymce/langs/'.$lang.'.js')) {
		$langDefault = $lang;
   }
	//directionality detection
	$directionality = SugarThemeRegistry::current()->directionality;
	$productCatalog = new oqc_ProductCatalog();
	$productCatalog->retrieve($focus->id);
	$categoryArray = (empty($focus->id)) ? (array()) : ($productCatalog->getAllCategories());

	$categoryJSONData = getCategoryJSONData($categoryArray, $view, $focus);
	//$GLOBALS['log']->error("product catalog: ". var_export($categoryJSONData,true));	
	
	$smarty->assign("MOD", $mod_strings);
	$smarty->assign("categoryJSONData", $json->encode($categoryJSONData));
	$smarty->assign('lang', $langDefault);
	$smarty->assign("languageStrings", $languageStringsJson);
	$smarty->assign('directionality', $directionality);

	return $smarty->fetch('include/oqc/ProductCatalog/' . $view . '.html');
}


?>
