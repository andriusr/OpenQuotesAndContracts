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
require_once('modules/oqc_ProductCatalog/oqc_ProductCatalog_sugar.php');
require_once('modules/oqc_Category/oqc_Category.php');
require_once('modules/Documents/Document.php');

class oqc_ProductCatalog extends oqc_ProductCatalog_sugar {
	
	public function getAllCategories() {
		$categories = array();
		$ids = explode(" ", trim($this->category_ids));

		foreach ($ids as $id) {
			$c = new oqc_Category();
			if ($c->retrieve($id)) {
				$categories[] = array(
					'category' => $c,
					'subcategories' => $c->getSubCategories(),
				);
			}
		}

		return $categories;
	}
	
	public static function activeCatalogId() {
		$bean = new oqc_ProductCatalog();
		$catalog = $bean->get_full_list("", 'active=1');

		if (count($catalog) < 1) {
			trigger_error("no active catalog found!", E_USER_WARNING);
			return null;
		} else {
			if (count($catalog) > 1) {
				trigger_error("more than one active catalog found!", E_USER_WARNING);
			}
			return $catalog[0]->id;
		}
	}

	public static function activeCatalog() {
		$bean = new oqc_ProductCatalog();
		$catalog = $bean->get_full_list("", 'active=1');

		if (count($catalog) < 1) {
			trigger_error("no active catalog found!", E_USER_WARNING);
			return null;
		} else {
			if (count($catalog) > 1) {
				trigger_error("more than one active catalog found!", E_USER_WARNING);
			}
			return $catalog[0];
		}
	}
	
/*	function fill_in_additional_detail_fields() {
		parent::fill_in_additional_detail_fields();

		// set this product catalog active if we enter the edit view and no other product catalog exists
		if ($_REQUEST['action'] == 'EditView') {
			$p = new oqc_ProductCatalog();
			$allCatalogs = $p->get_full_list();
			if (empty($allCatalogs)) {
				$this->active = true;
			}
		}
	}
*/	
	function fill_in_relationship_fields() {
		/*
		 * work around a SugarCRM bug. Document relate fields dont work,
		 * because Documents have no name attribute.
		 */
		
		parent::fill_in_relationship_fields();
		
		if (!empty($this->frontpage_id)) {
			$document = new Document();
			if ($document->retrieve($this->frontpage_id)) {
				$this->frontpage = $document->document_name;				
			}
		}

		if (!empty($this->attachment_id)) {
			$document = new Document();
			if ($document->retrieve($this->attachment_id)) {
				$this->attachment = $document->document_name;				
			}
		}
	}
		
	function oqc_ProductCatalog(){
		parent::oqc_ProductCatalog_sugar();
	}
	

	function get_list($order_by = "", $where = "", $row_offset = 0, $limit=PHP_INT_MAX, $max=-99) {
		return parent::get_list($order_by, $where, $row_offset, $limit, $max);
	}
	
	function get_summary_text() {
		return $this->name;
		}
		
	function save($check_notify = false) {
		
		$this->fixDatetimes();
		$return_id = parent::save($check_notify);
		
		return $return_id;
	}
	
	//2.1 avoid annoying depracated warnings and date conversion errors in sugarlog
	function fixDatetimes() {
		global $timedate;
		$date_array = array(
		array('datetime', 'date_modified'),
		array('datetime', 'date_entered'),
	//	array('date', 'startdate'),
	//	array('date', 'enddate'),
	//	array('date', 'signedon'),
		);
		
		foreach ($date_array as $field) {
			
            if ( !isset($this->$field[1]) || empty($this->$field[1]) ) {
                continue;
                }
            
            switch($field[0]) {
                case 'datetime':
                case 'datetimecombo':
                    if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$this->$field[1]) ) {
                        // This appears to be formatted in user date/time
                        $this->$field[1] = $timedate->to_db($this->$field[1]);
                    }
                    break;
                case 'date':
                    if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$this->$field[1]) ) {
                        // This date appears to be formatted in the user's format
                        $this->$field[1] = $timedate->to_db_date($this->$field[1], false);
                    }
                    break;
                case 'time':
                    if ( preg_match('/(am|pm)/i',$this->$field[1]) ) {
                        // This time appears to be formatted in the user's format
                        $this->$field[1] = $timedate->fromUserTime($this->$field[1])->format(TimeDate::DB_TIME_FORMAT);
                    }
                    break;
                default:
                	  break;
               }
			}
	}
	
	
}
?>