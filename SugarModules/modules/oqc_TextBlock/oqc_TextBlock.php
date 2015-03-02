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
require_once('modules/oqc_TextBlock/oqc_TextBlock_sugar.php');
class oqc_TextBlock extends oqc_TextBlock_sugar {

	function oqc_TextBlock(){
		parent::oqc_TextBlock_sugar();
	}

	public static function getFromId($id) {
		$textblock = new oqc_TextBlock();
		return $textblock->retrieve($id);
	}

	// retrieve specified record even if deleted by default
	function retrieve($id = -1, $encode = true, $deleted = false) {
		return parent::retrieve($id, $encode, $deleted);
	}

	function save($check_notify = false) {
		unset($this->oqc_textblock_number);
		
		$this->fixDatetimes();
		parent::save();
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
	
	// TODO: this should be done in a SugarField ListView template
	function fill_in_additional_list_fields() {
		parent::fill_in_additional_list_fields();

		$this->description = from_html($this->description);

		// workaround
		if (array_key_exists('module', $_REQUEST) && array_key_exists('action', $_REQUEST)) {
			// unfortunately SugarCRM calls this method even if we are NOT in a listview
			// and therefore cripples textblocks in contracts,
			// so only shorten the description if we are in the textblocks module in index action.
			
			// TODO causes Notice: Undefined property: oqc_TextBlock::$textblock_id in /var/www/ingoSugar1/include/oqc/Textblocks/Textblocks.php
			if ($_REQUEST['module'] == $this->object_name && $_REQUEST['action'] == 'index') {
				$pos = strpos($this->description, '</p>');
				
				if ($pos !== false) {
				//	if($pos > 70) { $pos=15;}
				$this->description = substr($this->description, 0, $pos) . ' ...</p>';
				}
			}
		}
	}
	
	function get_list($order_by = "", $where = "", $row_offset = 0, $limit=PHP_INT_MAX, $max=-99) {
		return parent::get_list($order_by, $where, $row_offset, $limit, $max);
	}
	
	function get_summary_text() {
		return $this->name;
		}
}
?>
