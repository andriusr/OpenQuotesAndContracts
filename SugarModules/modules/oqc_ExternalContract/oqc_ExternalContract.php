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
require_once('modules/oqc_ExternalContract/oqc_ExternalContract_sugar.php');
require_once('modules/oqc_ExternalContractPositions/oqc_ExternalContractPositions.php');
require_once('modules/oqc_ExternalContractCosts/oqc_ExternalContractCosts.php');
require_once('include/oqc/common/common.php');
require_once('include/oqc/common/Configuration.php');
require_once('include/oqc/common/Cache.php');
require_once('modules/oqc_ExternalContractCosts/oqc_ExternalContractCosts.php');

class oqc_ExternalContract extends oqc_ExternalContract_sugar {
	var $svnumber_sep = '?*+*?';

	var $basic_field_names = array('', 'recordtoken', 'contractnumber', 'dmsnumber', 'name', 'contractnumberclient', 'svnumbers', 'abbreviation', 'kst', 'productnumber', 'externalcontracttype', 'account', 'clientcontactperson', 'technicalcontactperson', 'contactperson', 'deliveryaddress', 'completionaddress', 'startdate', 'endperiod', 'cancellationperiod', 'minimumduration', 'warranteedeadline', 'monthsguaranteed', 'finalcosts');
	
	function oqc_ExternalContract(){	
		parent::oqc_ExternalContract_sugar();
	}
	
	function getSVNumbersArray() {
		$contract = new oqc_Contract();
		$svnumbersArray = array();
		$svnumbers = explode($this->svnumber_sep, $this->svnumbers);
		// iterate over svnumbers
		foreach ($svnumbers as $svnumber) {
			// check if svnumber is id of an existing contract
			if ($contract->retrieve($svnumber)) {
				// svnumber is the id of an existing contract
				$svnumbersArray[] = array(
					'id' => $svnumber, // set id of svnumber to the id of the contract
					'name' => $contract->svnumber, // set name of svnumber to content of svnumber field
				);
			} else {
				// svnumber is not the id of an existing contract
				$svnumbersArray[] = array(
					'id' => false, // set id to false to indicate that we do not reference an existing contract
					// do some conversions like &quot; -> " to display name correctly
					'name' => html_entity_decode($svnumber), // set name of svnumber item to svnumber :)
				);
			}
		}

		return $svnumbersArray;
	}

	function getPositionsArray() {
		$positionsArray = array();

		$positionIds = explode(' ', $this->positions);
		foreach ($positionIds as $id) {
			$position = new oqc_ExternalContractPositions();

			if ($position->retrieve($id)) {
				$positionsArray[] = $position->toArray();
			} else {
				$GLOBALS['log']->warn('external contract references invalid position entity.');
			}
		}

		return $positionsArray;
	}

	// TODO Cache this since this is called 400 times..
	// 40% of the export time are spend in $cost->retrieve($id)
	
	// assumption: get_list() is cheaper than a lot separated retrieve() calls
	// instead build a cache of all costs beforehand and access items in 
	// do that before doCosts array is called on all external contract instances
	function getCostsArray($withDetailedCosts = true) {
		$trimmedCosts = trim($this->costs);
		$costsArray = array();
		
		if (!empty($trimmedCosts)) {
			$ids = explode(' ', $this->costs);
		
			foreach ($ids as $id) {
				if (!array_key_exists($id, oqc_ExternalContractCosts::$cache)) {
				    $cost = new oqc_ExternalContractCosts();

				    if ($cost->retrieve($id)) {
						oqc_ExternalContractCosts::$cache[$id] = $cost;
						$costsArray[] = $this->getCostFromCache($id, $withDetailedCosts);
				    } else {
						$GLOBALS['log']->warn("external contract references invalid cost entity '$id'.");
				    }
				} else {
					$costsArray[] = $this->getCostFromCache($id, $withDetailedCosts);
				}
			}
		}

		return $costsArray;
	}

	function getCostFromCache($id, $withDetailedCosts = true) {
	    $cost = oqc_ExternalContractCosts::$cache[$id];
	    $costAsArray = $cost->toArray();
	    if ($withDetailedCosts) { // do this only if necessary since it is _very_ expensive because each external contracts has about 100 detailed cost positions. and loading sugarbeans is very expensive in sugar in general (see profiling..)
			$costAsArray['detailedCosts'] = $cost->getDetailedCostsArray(); // we need this additional field in the array in the edit view of the external contracts module 
	    }
	    return $costAsArray; 
	}

	function fill_in_additional_list_fields() {
		parent::fill_in_additional_list_fields();

		$moduleName = get_class($this);
		
		$isExport = array_key_exists('entryPoint', $_REQUEST) && $_REQUEST['entryPoint'] === 'export';

		if (array_key_exists('module', $_REQUEST) && $_REQUEST['module'] == $moduleName && array_key_exists('action', $_REQUEST) && $_REQUEST['action'] == 'index' && !$isExport) {
			// only truncate name of contract if we are in the list view of the module
			$conf = Configuration::getInstance();
			$max = $conf->get('maximumNameLength');
	
			if ($max < strlen($this->name)) {
				$this->name = truncateAtWordBoundaries($this->name, $max) . " ...";
			}
		}
	}
	
	
	function fill_in_additional_detail_fields() {
		parent::fill_in_additional_detail_fields();
		
		if (array_key_exists('action', $_REQUEST) && $_REQUEST['action'] == 'DetailView') {
			// display proper links to documents on network share
			$fieldNames = array('quote', 'contract', 'specialproperties', 'service_description');
			
			foreach ($fieldNames as $field) {
				$value = trim($this->$field);
				
				if (!empty($value)) {
					// $filename = substr($value, 1+strrpos($value, '/')); // only display filename without path
					// $filename = $value; // display filename with path
					$filename = str_replace('/', ' / ', $value); // display filename with path with spaces around slashes
					$this->$field = "<a href='include/oqc/common/Download.php?f=" . urlencode($value) . "'>" . $filename . "</a>";

					// we want to check if a file exists asynchronously.
					// if we detect that the file does not exist anymore we display a 
					// warning advice here.
					$this->$field .= "<span id='{$field}FileExistance' />";
				}
			}
		}
	}

	function fill_in_relationship_fields() {
		/*
		 * work around a SugarCRM bug. Document relate fields dont work,
		 * because Documents have no name attribute.
		 */
		
		parent::fill_in_relationship_fields();
		// TODO this has been fixed in 5.2.0k (?) has it??
	
		if (array_key_exists('action', $_REQUEST) && $_REQUEST['action'] == 'DetailView') { // Do this only in detailview
			$document_id_names = array('contract_id', 'quote_id', 'service_description_id', 'specialproperties_id', 'installation_hw_agreement_id', 'installation_sw_agreement_id', 'phone_support_id', 'assistance_id');
	
			foreach ($document_id_names as $document_id_name) {
				if (!empty($this->{$document_id_name})) {
					$document = new Document();
					if ($document->retrieve($this->{$document_id_name})) {
						$document_name = substr($document_id_name, 0, -3);
						$this->{$document_name} = $document->document_name;				
					}
				}
			}
		}
	}
	
	function get_exportable_fields_header($beans) {
	global $sugar_config;
	$lang = $sugar_config['default_language'];
        $mod_strings = return_module_language($lang, $this->module_dir);

        $basic_field_names = array();
		foreach ($this->basic_field_names as $field_name) {
			$basic_field_names[] = $mod_strings['LBL_' . strtoupper($field_name)];
		}
		$basic_field_names[] = $mod_strings['LBL_EXTERNALCONTRACTMATTER'];
			
		$years = array();

		// before iterating over external contract beans we fill the external contract costs cache to
		// speedup the getCostsArray() call
		oqc_ExternalContractCosts::fillCache();

		foreach ($beans as $bean) {
			// before you call this on all bean instances make sure you instantiated the cache containing
			// all EC-Costs collected with one get_list statement (instead of several retrieves..)
			$costs = $bean->getCostsArray(false);
			foreach ($costs as $cost) {
				if(!in_array($cost['year'], $years)) {
					$years[] = $cost['year'];
				}
			}
		}

		sort($years);

		// add empty columns
		$additional_field_names = array();
		$startYear = false; // this should contain the proper start year
		
		foreach ($years as $year) {
			// set start year to the first year entry that is no garbage (e.g., empty / 0).
			// this is necessary because the years array sometimes contains empty strings at the beginning. these would then be interpreted as a startYear value of null.
			// if this bad start year value is used lateron, the number of columns cannot be calculated properly. this will result in >4000 columns in the csv file.
			if (FALSE === $startYear && $year > 0) {
				$startYear = $year;
			}
			
			$additional_field_names[] = $year;
			$additional_field_names[] = '';
		}
		
		return array(array_merge($basic_field_names, $additional_field_names), $startYear);
	}
	
	function get_exportable_content($beans, $delimiter, $aggregate, $additional_info) {
		$content = '';
		$sum = 0;
		if (count($beans) > 0) {
			$prevBean = $beans[0];
		}
		
		$useComma = ',' === getSugarCrmLocale('default_decimal_seperator');

		global $sugar_config;
		$lang = $sugar_config['default_language'];
        	$mod_strings = return_module_language($lang, $this->module_dir);
		$sumLabel = $mod_strings['LBL_EXPORT_SUM'];
		
		foreach ($beans as $bean) {
			// if no column has been selected for aggregation aggreate will be false
			// then we must prevent $bean->$aggregate to be accessed because it will raise an error.
			if (FALSE !== $aggregate && $bean->$aggregate != $prevBean->$aggregate) {
				// only generate final cost sum line if we summed more than one line
				if ($sum != $prevBean->finalcosts) {
					// generate final cost sum
					$costLine = '';
					$emptyFieldCount = array_search("finalcosts", $this->basic_field_names) + 1;
					$emptyFields = array_fill(0, $emptyFieldCount, '');
					$emptyFields[0] = $sumLabel . ' ' . $prevBean->$aggregate;

					if ($useComma) { $sum = str_replace('.', ',', $sum); }
					if (strpos($sum, ',') !== FALSE) { $sum = substr($sum, 0, strpos($sum, ',')+3); }
					$costLine .= implode("\"". $delimiter ."\"", $emptyFields) . $sum;
					$costLine = "\"" .$costLine;
					$costLine .= "\"\r\n";
					$content .= $costLine;
				}
				
				// insert a newline after each aggregation
				$content .= "\r\n";
				$sum = 0;
			}
		
			$sum += $bean->finalcosts;
			if ($useComma) { $bean->finalcosts = str_replace('.', ',', $bean->finalcosts); }
			if (strpos($bean->finalcosts, ',') !== FALSE) { $bean->finalcosts = substr($bean->finalcosts, 0, strpos($bean->finalcosts, ',')+3); }
			$lines = $bean->get_exportable_fields($additional_info);
			foreach ($lines as $lineArray) {
				foreach ($lineArray as &$value) {
					$value = preg_replace("/\"/","\"\"", $value);
 				}
				$line = implode("\"". $delimiter ."\"", $lineArray);
				$line = "\"" .$line;
				$line .= "\"\r\n";
 				$content .= $line;
			}
			
			$prevBean = $bean;
		}
		
		// generate the costs summary line
		// only generate final cost sum line if we summed more than one line
		if ($sum != $prevBean->finalcosts) {
			// generate final cost sum at the end of the whole table
			$costLine = '';
			$emptyFieldCount = array_search("finalcosts", $this->basic_field_names) + 1;
			$emptyFields = array_fill(0, $emptyFieldCount, '');
			$emptyFields[0] = $sumLabel . ' ' . $prevBean->$aggregate;

			if ($useComma) { $sum = str_replace('.', ',', $sum); }
			if (strpos($sum, ',') !== FALSE) { $sum = substr($sum, 0, strpos($sum, ',')+3); }
			$costLine .= implode("\"". $delimiter ."\"", $emptyFields) . $sum;
			$costLine = "\"" .$costLine;
			$costLine .= "\"\r\n";
			$content .= $costLine;
		}

		return $content;
	}
	
	function get_exportable_fields($start_year) {
		$line = array();

		global $timedate;
		global $sugar_config;
		$lang = $sugar_config['default_language'];
		$app_list_strings = return_app_list_strings_language($lang);
				
		foreach ($this->basic_field_names as $field_name) {
			if (empty($field_name)) {
				$line[] = '';
			}
			// resolve relate fields
			else if (isset($this->field_name_map[$field_name]['type']) && $this->field_name_map[$field_name]['type'] == 'relate') {
				$id = $this->{$this->field_name_map[$field_name]['id_name']};

				if (empty($id)) {
					$line[] = '';
				} else {
					// Bean is either an instance of contact or account
					global $beanList;
					global $beanFiles;
					
					$type = $beanList[$this->field_name_map[$field_name]['module']];
					require_once($beanFiles[$type]);
					$bean = new $type;
					
					/*if (Cache::contains($id)) {
						$line[] = Cache::get($id);
					} else {
						// Just use name for now; using rname of field would be more correct
						$line[] = Cache::put($id, ($bean->retrieve($id)) ? $bean->name : '');
					}*/
					
					$line[] = ($bean->retrieve($id)) ? $bean->name : '';
				}
			}
			else if ($field_name == 'endperiod') {
				if ($this->endperiod == 'other') {
					$line[] = $timedate->to_display_date($this->enddate);
				}
				else {
					$line[] = $app_list_strings['endperiod_list'][$this->endperiod];
				}
			}
			else if ($field_name == 'cancellationperiod') {
				if ($this->cancellationperiod == 'other') {
					$line[] = $timedate->to_display_date($this->cancellationdate);
				}
				else {
					$line[] = $app_list_strings['cancellationperiod_list'][$this->cancellationperiod];
				}
			}
/*			else if ($field_name == 'finalcosts') {
				global $sugar_config;
				$line[] = $sugar_config['default_currency_symbol'] . ' ' . $value;
			}
*/
			else {
				$value = parent::decode_exportable_field($field_name);
				
				// fix for #548
				if (strpos($value, "\r\n")) {
					$line[] = str_replace("\r\n", ' ', $value);
				} else if (strpos($value, "\n")) {
					$line[] = str_replace("\n", ' ', $value);
				} else {
					$line[] = $value;
				}
			}
		}

		$costLines = array();		
		$costs = $this->getCostsArray(false);

		if (0 == $start_year) {
			die('Cannot create correct number of columns in csv export because start year could not be determined.');
		}
		
		// TODO test for the case if all external contracts are in same year.
		$year_diff = ($costs[0]['year']*1 - $start_year*1) * 2;
		
		// This check avoids massive warnings being printed out that slow down export.
		// PHP logs a E_WARNING if year_diff is not >= 1, see http://php.net/manual/en/function.array-fill.php
		$emptySpace = ($year_diff > 0) ? array_fill(0, $year_diff, '') : $emptySpace = array();

		foreach ($costs as $cost) {
			if (empty($costLines[$cost['category']])) {
				$translatedCategory =  $app_list_strings['externalcontractmatter_list'][$cost['category']];
				$costLines[$cost['category']] = array_merge(array($translatedCategory), $emptySpace);
			}

			$translatedPaymentInterval = $app_list_strings['paymentinterval_list'][$cost['paymentinterval']];

			// Replace dot with comma so that at least openoffice knows price is a decimal
			// if price just looks like '1.00' it starts converting it to a date..
			$cost['price'] = str_replace('.',',', $cost['price']);

			$costLines[$cost['category']][] = "{$cost['price']}";
			$costLines[$cost['category']][] = "{$translatedPaymentInterval}";
		}

		// complete first line, then construct sparse lines
		if (count($costLines) > 0) {
			$line = array_merge($line, array_shift($costLines));
		}

		$emptyLine = array_fill(0, count($this->basic_field_names), '');

		$additionalLines = array();
		foreach ($costLines as $costLine) {
			$additionalLines[] = array_merge($emptyLine, $costLine);
		}	

		return array_merge(array($line), $additionalLines);
	}
	
	function save($check_notify = false) {
		global $timedate;

		// #566 avoid that finalcosts are multiplied with 10000 on archive/restore.
		// remove decimal seperator used in db format with sugarcrms default decimal seperator.
		// the finalcosts value looks like it comes from the gui again and should not be multiplied.
		if ($this->finalcosts) {
			global $locale;
			$defaultDecSep = $locale->getPrecedentPreference("default_decimal_seperator");
			$this->finalcosts = str_replace('.', $defaultDecSep, $this->finalcosts);
		}
		
		$this->fixDatetimes();
		parent::save($check_notify);
		
		
	}
	
	//2.1 avoid annoying depracated warnings and date conversion errors in sugarlog
	function fixDatetimes() {
		global $timedate;
		$date_array = array(
		array('datetime', 'date_modified'),
		array('datetime', 'date_entered'),
		array('date', 'startdate'),
		array('date', 'enddate'),
		array('date', 'minimumduration'),
		array('date', 'cancellationdate'),
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
	
	/* Versioning Stuff */

	// retrieve specified record even if deleted by default
	function retrieve($id = -1, $encode = true, $deleted = false) {
		return parent::retrieve($id, $encode, $deleted);
	}
	
        function addNextRevisionId($id) {
                if (empty($this->nextrevisions))
                        $this->nextrevisions = $id;
                else
                        $this->nextrevisions .= ' ' . $id;
        }

        function getLatestNextRevisionId() {
                $nextRevisionIds = explode(' ', $this->nextrevisions);

                return end($nextRevisionIds);
        }

        function getRootRevision() {
                $contract = new $this->object_name();

                if ($contract->retrieve($this->previousrevision))
                        return $contract->getRootRevision();
                else
                        return $this;
        }

        // returns bean of head revision
        function getHeadRevision() {
                $contract = $this->getRootRevision();
                $nextContract = new $this->object_name();

                while ($nextContract->retrieve($contract->getLatestNextRevisionId())) {
                        $contract = $nextContract;
                }

                return $contract;
        }

        function getHeadVersion() {
                $oldHead = $this->getHeadRevision();

                return $oldHead->version;
        }

        function getHeadId() {
                $oldHead = $this->getHeadRevision();

                return $oldHead->id;
        }

        function getNextRevisions() {
                $nextRevisionIds = explode(' ', $this->nextrevisions);
                $nextRevisions = array();

                foreach ($nextRevisionIds as $nextRevisionId) {
                        $nextContract = new $this->object_name();

                        if ($nextContract->retrieve($nextRevisionId))
                                $nextRevisions = array_merge($nextRevisions, array($nextContract), $nextContract->getNextRevisions());
                }

                return $nextRevisions;
        }

        // returns an array containing all previous versions of a contract
        function getAllPreviousRevisions() {
                if (!empty($this->previousrevision)) {
                        $previousContract = new $this->object_name();

                        // if this contract has a non empty previous revision id
                        // try to retrieve the referenced previous contract
                        if ($previousContract->retrieve($this->previousrevision)) {
                                // if the contract exists append his previous versions
                                return array_merge(array(0=>$previousContract), $previousContract->getAllPreviousRevisions());
                        }
                }
                return array();
        }
        
        //1.7.7 limit the number of beans returned since for >20 there is PHP waring for exceeded number of queries
	function getSevenNextRevisions() {
		$next = array();
		$id = $this->nextrevisions;
		for ($i=0; $i<7; $i++) {
			$nextRevision = new $this->object_name();
			if ($nextRevision->retrieve($id)) {
				if (!$nextRevision->deleted) {
				
			 		$next[$i] = $nextRevision;
				} else { $i = $i-1;}
				if ($nextRevision->nextrevisions) {
					$id = $nextRevision->nextrevisions;
				} else { break ;}
			}
		}
		return $next;
	}
	
	//1.7.7 limit the number of beans returned since for >20 there is PHP waring for exceeded number of queries
	function getSevenPreviousRevisions() {
		$previous = array();
		$id = $this->previousrevision;
		for ($i=0; $i<7; $i++) {
			$previousContract = new $this->object_name();
			if ($previousContract->retrieve($id)) {
				if (!$previousContract->deleted) {
				
					 $previous[$i] = $previousContract;
				} else { $i = $i-1;}
				if ($previousContract->previousrevision) {
			 		$id = $previousContract->previousrevision;
			 	} else { break ;}
			}
		}
		return $previous;
	}
        

        function mark_relationships_deleted($id) {
                // This function is called from $this->mark_deleted.
                // But we do NOT want to delete any relationships
                // as these are still needed.

                // Relationships can be deleted with $this->delete_linked
        }
        
	function get_list($order_by = "", $where = "", $row_offset = 0, $limit=PHP_INT_MAX, $max=-99) {
		return parent::get_list($order_by, $where, $row_offset, $limit, $max);
	}
	
	//1.7.6 we do not delete products but just seeting is_latest flag to zero, keeping all relationships	
	function oqc_mark_deleted($id)
	{
		global $current_user;
		$date_modified = gmdate($GLOBALS['timedate']->get_db_date_time_format());
		
					if ( isset($this->field_defs['modified_user_id']) ) {
                if (!empty($current_user)) {
                    $this->modified_user_id = $current_user->id;
                } else {
                    $this->modified_user_id = 1;
                }
                $query = "UPDATE $this->table_name set is_latest=0 , date_modified = '$date_modified', modified_user_id = '$this->modified_user_id' where id='$id'";
 			} else
                $query = "UPDATE $this->table_name set is_latest=0 , date_modified = '$date_modified' where id='$id'";
			$this->db->query($query, true,"Error marking record deleted: ");
//			$this->mark_relationships_deleted($id);

			// Take the item off the recently viewed lists
			$tracker = new Tracker();
			$tracker->makeInvisibleForAll($id);
	
	}
	
	function get_summary_text() {
		return $this->name;
		}
		
	function mark_deleted($id, $timeline=true) {
		
		if ($this->is_latest) {
			$previousVersions = $this->getAllPreviousRevisions();
			foreach ($previousVersions as $version) {
				$version->mark_deleted($version->id, false); //Do not correct timeline since we are deleting everything
			}
								
		//	$this->is_latest = false; //Sets is_latest fields as for deleted record
		//	$this->save();
		//If it is not latest, just make do fix for history panel correct timeline; it will be not accesible in any other way, too;
		
		} else { 
		/*	if ($timeline) {
			if (!empty($this->previousrevision)) {
				$previousVersion = new $this->object_name();
				if ($previousVersion->retrieve($this->previousrevision)) {
					$previousVersion->nextrevisions = $this->nextrevisions;
					$previousVersion->update_date_modified = false; //Do not change date_modified field, since we do not modify it
					$previousVersion->save();
				}
			}
			if (!empty($this->nextrevisions)) {
				$nextVersion = new $this->object_name();
				if ($nextVersion->retrieve($this->nextrevisions)) {
					$nextVersion->previousrevision = $this->previousrevision;
					$nextVersion->update_date_modified = false; //Do not change date_modified field, since we do not modify it
					$nextVersion->save();
				}
			}
			} */
			
			
			
		}
			
		parent::mark_deleted($id);	

	}
	
}
?>
