<?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2007 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/oqc_Category/oqc_Category_sugar.php');
require_once('modules/oqc_Contract/SimpleTree.php');

class oqc_Category extends oqc_Category_sugar {
	public function getSubCategories() {
		$subcategories = array();
		$ids = explode(" ", trim($this->subcategories));

		foreach ($ids as $id) {
			$c = new oqc_Category();
			if ($c->retrieve($id)) {
				$subcategories[] = array(
					'category' => $c,
					'subcategories' => $c->getSubCategories(),
				);
			}
		}

		return $subcategories;
	}
	
	public static function getFromId($id) {
		$category = new oqc_Category();
		return $category->retrieve($id);
	}
	
	function get_list($order_by = "", $where = "", $row_offset = 0, $limit=PHP_INT_MAX, $max=-99) {
		return parent::get_list($order_by, $where, $row_offset, $limit, $max);
	}
	
	/*public static function deleteCategoryIdGlobally($categoryId, $where) {
		$categories = oqc_Category::getAllCategories($where);

		// remove the given id from the subcategories field of all categories
		foreach ($categories as $category) {
			$category->subcategories = preg_replace('/$categoryId/g', '//', $category->subcategories);
			$category->save();
		}
	}

	public function deleteCategoryRecursively() {
		// make sure that this bean is correctly initialized and exists
		if (!empty($this->id) && (oqc_Category::getFromId($this->id)) != null) {
			// delete the category
			$this->mark_deleted($this->id);
			
			// set related product category_ids to null
			$bean = new oqc_Product();
			$products = $bean->get_full_list("", "relatedcategory_id='{$this->id}'");
		
			foreach ($products as $product) {
				$product->relatedcategory_id = null;
				$product->save();
			}
				
			// delete all subcategories
			$subCategories = $this->getValidSubCategories();
			foreach ($subCategories as $subCategory) {
				$subCategory->deleteCategoryRecursively();
			}
		}
	}

	public function getSubCategoriesAsSmartyArray() {
		$items = array();

		$subCategories = $this->getValidSubCategories();
		foreach ($subCategories as $subCategory) {
			$items[] = array(
				'id' => $subCategory->id,
				'name' => $subCategory->name,
				// 'description' => 'description',
				'description' => $subCategory->description,
				'subCategories' => $subCategory->getSubCategoriesAsSmartyArray(),
			);
		}

		return $items;
	}

	public function getSubCategoriesAsJsonFormattedArray() {
		$items = array();

		$subCategories = $this->getValidSubCategories();
		foreach ($subCategories as $subCategory) {
			$items[] = $subCategory->getSubCategoriesAsJsonFormattedArray();
		}

		$a = array(
			'id' => $this->id,
			'text' => $this->name,
		// 'text' => $this->name . " (" . from_html($this->description) . ")",
			'item' => $items,
		);

		return $a;
	}

	public static function getAllCategories($where) {
		$category = new oqc_Category();
		$categoryArray = $category->get_list("", $where);
		$categoryArray = $categoryArray['list'];

		return $categoryArray;
	}

	public static function getAllCategoryIds($where) {
		$categoryIds = array();

		$categoryArray = oqc_Category::getAllCategories($where);
		foreach ($categoryArray as $category) {
			$categoryIds[] = $category->id;
		}

		return $categoryIds;
	}

	public static function getRootCategories($where) {
		$rootCategoryArray = array();
		$rootCategoryIds = self::getRootCategoryIds($where);

		foreach ($rootCategoryIds as $id) {
			$rootCategoryArray[] = oqc_Category::getFromId($id);
		}

		return $rootCategoryArray;
	}

	public static function getRootCategoryIds($where) {
		$allCategoryIds = oqc_Category::getAllCategoryIds($where);
		$rootCategoryIds = $allCategoryIds;

		// each category that does not appear as a subcategory is a subcategory
		// iterate over all categories
		foreach ($allCategoryIds as $id) {
			$category = oqc_Category::getFromId($id);
			// remove the ids of the categories that appear as subcategories from the
			// array containing the root category ids
			$rootCategoryIds = array_diff($rootCategoryIds, preg_split("/\s+/", $category->subcategories));
		}

		return $rootCategoryIds;
	}

	public function getValidSubCategories() {
		$storedSubCategoryIds = explode(" ", trim($this->subcategories));
		$validSubCategories = array();

		foreach ($storedSubCategoryIds as $categoryId) {
			if (($subCategory = oqc_Category::getFromId($categoryId)) != null) {
				$validSubCategories[] = $subCategory;
			} else {
				$GLOBALS['log']->debug("category ('" + $this->id + "') references a nonexisting category ('$categoryId')");
			}
		}

		return $validSubCategories;
	}

	public function getSubCategoriesTree() {
		if (empty($this->id)) {
			return NULL;
		} else {
			$tree = new SimpleTree($this->id);
			$subcategories = $this->getValidSubCategories();

			foreach ($subcategories as $subCategory) {
				$tree->addChild($subCategory->getSubCategoriesTree());
			}

			return $tree;
		}
	}*/

	function oqc_Category($name="", $description="") {
		parent::oqc_Category_sugar();
		$this->name = $name;
		$this->description = $description;
	}

	function fill_in_additional_list_fields() {
		parent::fill_in_additional_list_fields();

		$this->description = from_html($this->description);

		// unfortunately SugarCRM calls this method even if we are NOT in a listview
		// and therefore cripples textblocks in contracts,
		// so only shorten the description if we are in the textblocks module in index action.
		if ($_REQUEST['module'] == $this->object_name && ($_REQUEST['action'] == 'index' || $_REQUEST['action'] == 'Popup')) {
			// NOTE:	removed the 3rd argument (it is the offset) because an offset of the value "true" makes no sense..
			//			this removes an error that occures of the description is empty and so does not contain a </p> tag..
			// $pos = strpos($this->description, '</p>', true);

			// TODO define as a constant somewhere..
			if (!empty($this->description) && 100 < strlen($this->description)) {
				if (0 != preg_match("/^<p>(.*?)<\/p>.*(<p>.*?<\/p>)*/", $this->description, $matches)) {
					$this->description = $matches[0];
				}
			
				if (100 < strlen($this->description)) {
					$this->description = substr($this->description, 0, 100);
					$this->description .= "...";
				}
			}
			
			// TODO put some string in front of the category name to describe the hierarchy 
		}
	}
	
	function get_summary_text() {
		return $this->name;
		}
		
	function save($check_notify = false) {
		global $timedate;
		//$GLOBALS['log']->error("Processed tag is ". var_export($this->processed_dates_times['date_entered'],true)); 
		if (!empty($this->date_entered) && !isset($this->processed_dates_times['date_entered'])) {
			$this->date_entered = $timedate->to_db($this->date_entered);
			}
		if (!empty($this->date_modified) && !isset($this->processed_dates_times['date_modified'])) {	
			$this->date_modified = $timedate->to_db($this->date_modified);
		}
     

		$return_id = parent::save($check_notify);
		//After first save we set the flag
		$this->processed_dates_times['date_entered'] = '1'; 
		$this->processed_dates_times['date_modified'] = '1';
		return $return_id;
	}
}
?>
