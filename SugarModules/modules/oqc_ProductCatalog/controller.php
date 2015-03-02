<?php
require_once('include/utils.php');
require_once('include/MVC/Controller/SugarController.php');
require_once('modules/oqc_ProductCatalog/oqc_ProductCatalog.php');
require_once('modules/oqc_Category/oqc_Category.php');
require_once('modules/oqc_ProductCatalog/ProductCatalogPdfCreator.php');
require_once('modules/oqc_Product/oqc_Product.php');

class oqc_ProductCatalogController extends SugarController {
	
	function action_CreatePdf() {
		if (isset($_REQUEST['record']) && $_REQUEST['record'] != '') {
		$pdfCreator = new ProductCatalogPdfCreator();
		$productCatalog = new oqc_ProductCatalog();
		if ($productCatalog->retrieve($_REQUEST['record'])) {
		$pdfCreator->createPdf($productCatalog);
		} else { $this->post_save();
			}
		}
	}
	
	function action_save() {
		
		if (empty($this->bean->id)) {
			parent::action_save();
		}
		
		$this->removeCategories();
		

		// NOTE: call from_html _before_ calling $json->decode... WTF!
		$json = getJSONobj();
		// workaround for #276
		
		$hiddenFieldContent	= $_POST['categoryHiddenField'];
		if (!empty($hiddenFieldContent)) {
		$categoryHiddenField = $json->decode(from_html($hiddenFieldContent));
		//$GLOBALS['log']->error("product catalog tree structure: ". var_export($categoryHiddenField,true));	
		// for each category store its subcategories in the subcategories attribute (saveCategories()) and store the ids of the root categories in the category_ids fields of the product catalog 
				$this->bean->category_ids = implode(' ', $this->saveCategories($categoryHiddenField));
		}
		else {
			$GLOBALS['log']->warn("field 'item' which is neccessary for creating category structure does not exist");
		}
		
		parent::action_save();
	}
	
	// call set_redirect to make sure that we are redirected to the new product catalog after saving
	function post_save() {
		$module = (!empty($this->return_module) ? $this->return_module : $this->module);
		$action = (!empty($this->return_action) ? $this->return_action : 'DetailView');
		$id = $this->bean->id;
		
		$url = "index.php?module=".$module."&action=".$action."&record=".$id;
		$this->set_redirect($url);
	}
	
	private function removeCategories() {
		$deletedCategoryIds = explode(' ', trim($_POST['deletedCategories']));
		$deletedCategoryIds = array_diff($deletedCategoryIds, array(" ", "")); // remove empty elements from the array
		$category = new oqc_Category();
		
		foreach ($deletedCategoryIds as $id) {
			if ($category->retrieve($id)) {
				$category->mark_deleted($id);
			}
		}
	}
	
	function saveOptions($optionsArray, $productId, &$updateDescription) {
		$optionIds = array();
		$sequenceIds = array();
		
		foreach ($optionsArray as $key => $optionItem) {
			if ($optionItem['isOption']) {
				$optionIds[] = $optionItem['key'];
							
			}
			if (isset($optionItem['wasActive']) && $optionItem['wasActive']) {
				if (array_search($optionItem['key'], $updateDescription) === false) {
					
				$updateDescription[] = $optionItem['key']; }
							
			}
			if ($optionItem['children'] != '' && ! array_key_exists($optionItem['key'], $sequenceIds)) {
				$sequenceIds[$optionItem['key']] = $this->saveOptions($optionItem['children'], $optionItem['key'], $updateDescription);
			}
		}
		if ( ! array_key_exists($productId, $sequenceIds)) {
		$sequenceIds[$productId] = implode(' ', $optionIds);
	//	$sequenceIds = array_merge(array($productId, implode(' ', $optionIds)), $sequenceIds);
		}
		return $sequenceIds;

		}
	
	
	

	private function saveCategories($subCategoryArray, $prefix = '', $masterCategory = '') {
		if (empty($subCategoryArray)) {
			return array();
		} else {
			//decode tree array into actions that we need to do after tree save
			$subCategoryIds = array();
			$productIds = array();
			$optionSequenceIds = array();
			$updateDescriptionsIds = array();
			foreach ($subCategoryArray as $number => $subCategoryItem) {
			
				if ($subCategoryItem['isProduct'] && $masterCategory) {
					$productIds[] = array(
									//	 $masterCategory,
										 $subCategoryItem['key'],
										 $subCategoryItem['title'],
										 isset($subCategotyItem['wasActive']) ? true : false,
										 );
					if ($subCategoryItem['children'] != '') {
						$optionSequenceIds = array_merge($this->saveOptions($subCategoryItem['children'], $subCategoryItem['key'], $updateDescriptionsIds), $optionSequenceIds) ;
					}
						
				continue;		
				}
				
				// initialize the category correctly if it does not exist yet
				if (($subCategory = oqc_Category::getFromId($subCategoryItem['key'])) == null) {
					$subCategory = new oqc_Category();
				}
				
				$subCategory->number = $prefix . ($number+1);
				$subCategory->name = $subCategoryItem['title'];
				$subCategory->description = isset($_POST['categoryDescription_' . $subCategoryItem['key']]) ? $_POST['categoryDescription_' . $subCategoryItem['key']] : "";
				
				if ($subCategoryItem['children'] != '') { 
					$subCategory->subcategories = implode(" ", $this->saveCategories($subCategoryItem['children'], $prefix . ($number+1) . '.', $subCategoryItem['key']));
				} else {
					$subCategory->subcategories = "";
				}
				
				$subCategory->catalog_id = $this->bean->id;

				$subCategory->save();
				
				// put id of this subcategory into the array $subCategoryIds
				if (array_search($subCategory->id, $subCategoryIds) === FALSE) {
					$subCategoryIds[] = $subCategory->id;
				}
			}
			//2.2RC1 now process Products and options that are in this particular tree level
			//1. update Product descriptions if was Active, update ordering of Products, update title of products is was Active, update Product category (it might be changed is was Active
			//2. For options update ordering string and description if wasActive
			//$GLOBALS['log']->error("product catalog subcategories: ". var_export($subCategoryIds,true));
			//$GLOBALS['log']->error("product catalog products: ". var_export($productIds,true));
			//$GLOBALS['log']->error("product catalog options sequences: ". var_export($optionSequenceIds,true));
			//$GLOBALS['log']->error("product catalog descriptions: ". var_export($updateDescriptionsIds,true));
			
			if (!empty(	$productIds)) {
				foreach ($productIds as $number=>$productId ) {
					$product = new oqc_Product();
					if ($product->retrieve($productId[0])) {
						$product->name = $productId[1];
						$product->description = isset($_POST['categoryDescription_' . $productId[0]]) ? $_POST['categoryDescription_' . $productId[0]] : "";
						if (array_key_exists($productId[0], $optionSequenceIds)) {
							$product->optionssequence = $optionSequenceIds[$productId[0]];
							unset($optionSequenceIds[$productId[0]]);
						}
						$product->catalog_position = $number+1;
						$product->relatedcategory_id = $masterCategory;
						$product->save();
					}
				}
			}
			if (!empty($optionSequenceIds)) {
				foreach ($optionSequenceIds as $key => $optionSequenceId) {
					$option = new oqc_Product();
					if ($option->retrieve($key)) {
						if (isset($_POST['categoryDescription_' . $key]) && array_search($key ,$updateDescriptionsIds) ) {
							$option->description = $_POST['categoryDescription_' . $key];
							unset($updateDescriptionsIds[array_search($key ,$updateDescriptionsIds)]);
						}
						if (array_key_exists($key, $optionSequenceIds)) {
							$option->optionssequence = $optionSequenceIds[$key];
							unset($optionSequenceIds[$key]);
						}
					//	$option->catalog_position = $number+1;
					//	$option->relatedcategory_id = $key;
						$option->save();
					}
				
				
				}
			}
			if (!empty($updateDescriptionsIds )) {
				foreach ($updateDescriptionsIds as $updateDescriptionsId) {
					if (isset($_POST['categoryDescription_' . $updateDescriptionsId])) {
						$option = new oqc_Product();
						if ($option->retrieve($updateDescriptionsId)) {
							$option->description = $_POST['categoryDescription_' . $updateDescriptionsId];
				//			unset($updateDescriptionsIds[array_search($key ,$updateDescriptionsIds)];
							$option->save();
						}	
					}
				}
			}
			
			
			return $subCategoryIds;
		}
	}
}

?>
