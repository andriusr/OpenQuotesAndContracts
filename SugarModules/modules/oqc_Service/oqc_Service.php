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

require_once('include/oqc/common/common.php'); // required for getFormattedCurrencyValue method
require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/oqc_Service/oqc_Service_sugar.php');
require_once('modules/Currencies/Currency.php');

class oqc_Service extends oqc_Service_sugar {
	function oqc_Service($productId='', $price = 0.0, $quantity = 1, $name='', $description='', $vat = false, $zeitbezug="once", $unit="pieces", $discountValue = 0, $discountSelect="rel", $position='', $currency=''){
	
		parent::oqc_Service_sugar();

		// falling back to default values when some of the values are null. this should avoid mysql error occuring when fields are empty (null).
		$this->description = (null == $description) ? '' : $description;
		$this->product_id = (null == $productId) ? '' : $productId;
		$this->quantity = (null == $quantity) ? 1 : $quantity;
		$this->price = (null == $price) ? 0.0 : $price;
		$this->name = (null == $name) ? '' : $name;
		$this->vat = (true == $vat) ? true : false;
		$this->oqc_vat = (true !== $vat && false !== $vat) ? $vat : null;
		$this->zeitbezug = (null == $zeitbezug) ? 'once' : $zeitbezug;
		$this->unit = (null == $unit) ? 'pieces' : $unit;
		$this->discount_value = $discountValue;
		$this->discount_select = $discountSelect;
		$this->position = $position; //1.7.7 adds position of service in the table
		$this->service_currency_id = $currency; //1.7.8 adds currency 

	}

	/* TODO: avoid insertion of duplicate rows in oqc_ContractController
	 * this declaration avoids insertion of duplicate rows into the contracts-services relation table:
	 * oqc_Service::save() calls SugarBean::save() which calls SugarBean::save_relationship_changes()
	 * SugarBean::save_relationship_changes() will insert a already existing link between a contract and a service into the tables storing the links
	 * we declare an empty implementation of save_relationship_changes to override SugarBean::save_relationship_changes() so that no already existing link is inserted into the table
	 * this is to make sure that oqc_Contract::get_linked_beans does not return duplicate services
	 */
	function save_relationship_changes($is_update, $exclude=array()) {
		// do nothing
	}

        function getDiscountedPrice($vat) {
            $discountedPrice = $this->getDiscountedPriceTaxFree();
                
            if ($vat) {
                return $discountedPrice*(1+$vat);
            } else {
                return $discountedPrice;
            }
        }

        function getDiscountedPriceTaxFree() {
            return ('rel' === $this->discount_select) ?
                    (1-$this->discount_value/100)*$this->price :
                    ($this->price-$this->discount_value);
        }

	
	// this is used for viewing changes between versions
	function as_plain_text() {
		
		global $locale;
		$default_currency = new Currency();
		$default_currency->retrieve($this->service_currency_id);
		$currencySymbol = $default_currency->symbol;
			
		$vatStr = 'VAT '. floatval($this->oqc_vat)*100; 
		$formattedPrice = getFormattedCurrencyValue($this->price); 
		$description = from_html($this->description);

		return "$this->name ({$description}), $this->quantity $this->unit $currencySymbol $formattedPrice Discount: $this->discount_value $this->discount_select " . $vatStr . ' %';
	}
	
	function get_list($order_by = "", $where = "", $row_offset = 0, $limit=PHP_INT_MAX, $max=-99) {
		return parent::get_list($order_by, $where, $row_offset, $limit, $max);
	}
	
	//2.0 extra functions for arrangement of service beans according position value    
   static function oqc_service_compare_position($a, $b) { 
	return strnatcmp($a->position, $b->position); 
	} 
	
	function get_summary_text() {
		return $this->name;
		}
	
	
}
?>
