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
require_once('modules/oqc_ExternalContractCosts/oqc_ExternalContractCosts_sugar.php');
require_once('include/oqc/common/Cache.php');

class oqc_ExternalContractCosts extends oqc_ExternalContractCosts_sugar {
	public static $cache = array();

	var $detailedCostsArray = 0;
	
	function oqc_ExternalContractCosts($price="", $desc="", $category="", $year="", $payment="") {
		parent::oqc_ExternalContractCosts_sugar();
		
		$this->price = $price;
		$this->description = $desc;
		$this->category = $category;
		$this->year = $year;
		$this->paymentinterval = $payment;
	}

	// do some conversions like &quot; -> " to display name and description correctly
	function fill_in_additional_detail_fields() {
		parent::fill_in_additional_detail_fields();
		$this->name = html_entity_decode($this->name);
		$this->description = html_entity_decode($this->description);
	}

	function get_name() {
		$costs = translate('LBL_COSTS');
		$category = translate('externalcontractmatter_list', '', $this->category);
		return "{$costs} {$category} {$this->year}";
	}

	function as_plain_text() {
		$paymentInterval = translate('paymentinterval_list', '', $this->paymentinterval);
		if (empty($this->description)) {
			$description = '';
		} else {
			$description = " ({$this->description})";
		}
		
		return "{$this->price} {$paymentInterval}{$description}";
	}
	
	// TODO Cache this since this is called 1700 times..
	function getDetailedCostsArray() {
		if (!$this->detailedCostsArray) { // lookup the cached value
			$detailedCostsArray = array();
			$trimmedDetailedCostIds = trim($this->detailedcost_ids);
	
			if (!empty($trimmedDetailedCostIds)) { // this field is empty for 50% of the rows in the db
				$ids = explode(' ', $trimmedDetailedCostIds); 

				require_once('modules/oqc_ExternalContractDetailedCosts/oqc_ExternalContractDetailedCosts.php');
				$detailedCost = new oqc_ExternalContractDetailedCosts();
				
				foreach ($ids as $id) {
					/*if (Cache::contains($id)) {
						if (Cache::get($id)) {
							$detailedCostsArray[] = Cache::get($id);
						}
					} else {*/
						if ($detailedCost->retrieve($id)) {
							// 	$detailedCostsArray[] = Cache::put($id, $detailedCost->toArray());
							$detailedCostsArray[] = $detailedCost->toArray();
						}/* else {
							Cache::put($id, false);
						}
					}*/
				}
			}
			
			// insert value into cache. subsequent requests should immediately return this cached value.
			$this->detailedCostsArray = $detailedCostsArray;
		}
		
		return $this->detailedCostsArray;
	}

	// get list 1% of overall performance
	// retrieves 34% of overall performance
	public static function fillCache() {
		if (empty(self::$cache)) {
			$c = new oqc_ExternalContractCosts();
			$all = $c->get_list();
			$all = $all['list'];
	
			foreach ($all as $cost) {
				self::$cache[$cost->id] = $cost;
			}
		}
	}
	
	//
	// IMPORTANT NOTE
	// have to set huge limit value AND set maxPerPage argument to magic -99 to receive all values.
	// note that this may be changed in future versions of sugarcrm.. (see get_list implementation..) 
	// if you do not do it this way you will only receive 20 items..
	//
	function get_list($order_by = "", $where = "", $row_offset = 0, $limit=PHP_INT_MAX, $max=-99) {
		return parent::get_list($order_by, $where, $row_offset, $limit, $max);
	}
	
	function get_summary_text() {
		return $this->name;
		}
}
?>
