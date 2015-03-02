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
require_once('modules/oqc_ExternalContractPositions/oqc_ExternalContractPositions_sugar.php');
class oqc_ExternalContractPositions extends oqc_ExternalContractPositions_sugar {
	
	function oqc_ExternalContractPositions($name="", $price="", $qty="", $desc="", $type="") {
		parent::oqc_ExternalContractPositions_sugar();
		
		$this->name = $name;
		$this->type = $type;
		$this->price = $price;
		$this->quantity = $qty;
		$this->description = $desc;
	}
	
	// do some conversions like &quot; -> " to display name and description correctly
	function fill_in_additional_detail_fields() {
		parent::fill_in_additional_detail_fields();
		$this->name = html_entity_decode($this->name);
		$this->description = html_entity_decode($this->description);
	}

	function as_plain_text() {
		global $app_list_strings;
		$quantity = $app_list_strings["oqc"]["common"]["quantity"];
		$price = $app_list_strings["oqc"]["common"]["price"];
		$type = $app_list_strings["oqc"]["common"]["type"];
		
		if (empty($this->description)) {
			$description = '';
		} else {
			$description = " ({$this->description})";
		}
		
		return "{$this->name}{$description}; {$quantity}: {$this->quantity}; {$price}: {$this->price}; {$type}: {$this->type}";
	}
	
	function get_list($order_by = "", $where = "", $row_offset = 0, $limit=PHP_INT_MAX, $max=-99) {
		return parent::get_list($order_by, $where, $row_offset, $limit, $max);
	}
	
	function get_summary_text() {
		return $this->name;
		}
}
?>
