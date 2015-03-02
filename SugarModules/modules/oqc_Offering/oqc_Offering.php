<?php

require_once('modules/oqc_Contract/oqc_ContractBase.php');

class oqc_Offering extends oqc_ContractBase {
	var $module_dir = 'oqc_Offering';
	var $object_name = 'oqc_Offering';
	var $table_name = 'oqc_offering';

	var $document_category = 'Quote';

	var $contractid;
	var $deadline;
	
	function oqc_Offering() {
		parent::oqc_ContractBase();
	}
	
	function get_summary_text() {
		return $this->name;
		}
		
	function fill_in_svnumber() {


		global $timedate;
//		$date = $timedate->swap_formats($this->date_entered, $timedate->get_date_time_format(), strrev($timedate->get_date_format()));
		$date = date("ymd");
		$fldname = strtolower(get_class($this)).'_number';
		//2.2RC2 Use translated abbreviations
		global $app_list_strings;
		if (isset($app_list_strings["quote_abbreviation_list"][$this->abbreviation])) {
			$abbreviation = $app_list_strings["quote_abbreviation_list"][$this->abbreviation];
		} else { $abbreviation = $this->abbreviation;}
		$this->svnumber = $abbreviation . $date . '/'. $this->$fldname;
	}
		
	function mark_deleted($id, $timeline=true) {

		
		if ($this->is_latest) {
			$previousVersions = $this->getAllPreviousRevisions();
			foreach ($previousVersions as $version) {
				$version->mark_deleted($version->id, false); //Do not correct timeline since we are deleting everything
			}
		
			if (!$this->load_relationship('oqc_service')) {
					$GLOBALS['log']->error("Could not load relationship to oqc_service. Cannot return the services related to this offering/contract!");
			} else {
				$services = $this->get_linked_beans('oqc_service', 'oqc_Service');
						
				foreach ($services as $service) {
				$service->mark_deleted($service->id);	
					
				}
			}
			
		
		
		//Mark deleted also related oqc_services  since they do not have UI	
		} else { 
		
			if (!$this->load_relationship('oqc_service')) {
					$GLOBALS['log']->error("Could not load relationship to oqc_service. Cannot return the services related to this offering/contract!");
			} else {
				$services = $this->get_linked_beans('oqc_service', 'oqc_Service');
						
				foreach ($services as $service) {
				$service->mark_deleted($service->id);	
					
				}
			}
			
			
		}
			
		parent::mark_deleted($id);	

	}
}
?>
