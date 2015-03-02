<?php

require_once('modules/oqc_Contract/oqc_Contract.php');

class oqc_Addition extends oqc_ContractBase {
	var $module_dir = 'oqc_Addition';
	var $object_name = 'oqc_Addition';
	var $table_name = 'oqc_addition';

	var $document_category = 'Addition';

	function oqc_Addition() {
		parent::oqc_ContractBase();
	}
	
	function get_summary_text() {
		return $this->name;
		}
		
	// Deletes relationships that are re-created during save; override this in each sub-class for custom relationships 
	function oqc_delete_relationships($id) {
		
		$remove_relationships = array('documents', 'oqc_service', 'accounts', 'contacts');
    	
    	foreach ($remove_relationships as $name)
    	{
    		if ($this->load_relationship($name))
    		{
    			//$GLOBALS['log']->fatal('relationship loaded '.$name);
    			$this->$name->delete($id);
    		}
    		else
    		{
    			$GLOBALS['log']->error('error loading relationship');
    		}
    	}
    
	}
	
	function fill_in_svnumber() {


		global $timedate;
//		$date = $timedate->swap_formats($this->date_entered, $timedate->get_date_time_format(), strrev($timedate->get_date_format()));
		$date = date("ymd");
		$fldname = strtolower(get_class($this)).'_number';
		//2.2RC2 Use translated abbreviations
		global $app_list_strings;
		if (isset($app_list_strings["addition_abbreviation_list"][$this->abbreviation])) {
			$abbreviation = $app_list_strings["addition_abbreviation_list"][$this->abbreviation];
		} else { $abbreviation = $this->abbreviation;}
		$this->svnumber = $abbreviation . $date . '/'. $this->$fldname;
	} 
	
	function mark_deleted($id, $timeline=true) {

		//If it is latest version, we need to mark_deleted also related oqc_additions and oqc_services, since there are no other way to remove them
		//mark_deleted also earlier versions of contract and reset contractid field of offering if offeringid is not empty.
		if ($this->is_latest) {
			$previousVersions = $this->getAllPreviousRevisions();
			foreach ($previousVersions as $version) {
				$version->mark_deleted($version->id, false); //Do not correct timeline since we are deleting everything
			}
			/*if (!empty($this->contractid)) {
					$contract = new oqc_Contract();
					if ($contract->retrieve($this->contractid)) {
						$contract->idsofadditions = str_replace($this->id, '', trim($contract->idsofadditions));
						$contract->idsofadditions = str_replace('  ', ' ', trim($contract->idsofadditions));
						$contract->update_date_modified = false;
						$contract->save();
					}
				} */
			if (!$this->load_relationship('oqc_service')) {
					$GLOBALS['log']->error("Could not load relationship to oqc_service. Cannot return the services related to this offering/contract!");
			} else {
				$services = $this->get_linked_beans('oqc_service', 'oqc_Service');
						
				foreach ($services as $service) {
				$service->mark_deleted($service->id);	
					
				}
			}
					
		//	$this->is_latest = false; //Sets is_latest fields as for deleted record
		//	$this->save();
		//If it is not latest, just make do fix for history panel correct timeline; it will be not accesible in any other way, too;
		//Mark deleted also related oqc_services and oqc_additions since they do not have UI	
		} else { 
			/*if ($timeline) {
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
			} 
			if (!empty($this->contractid)) {
					$contract = new oqc_Contract();
					if ($contract->retrieve($this->contractid)) {
						$contract->idsofadditions = str_replace($this->id, '', trim($contract->idsofadditions));
						$contract->idsofadditions = str_replace('  ', ' ', trim($contract->idsofadditions));
						$contract->update_date_modified = false;
						$contract->save();
					}
				} */
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
