<?php

require_once('modules/oqc_Contract/oqc_ContractBase.php');
require_once('modules/oqc_Addition/oqc_Addition.php');
require_once('modules/Documents/Document.php');

class oqc_Contract extends oqc_ContractBase {
	var $module_dir = 'oqc_Contract';
	var $object_name = 'oqc_Contract';
	var $table_name = 'oqc_contract';

	var $document_category = 'Contract';

	var $idsofadditions;
	var $offeringid;
	var $signedcontractdocument;
	var $signedcontractdocument_id;
	var $unique_total_negotiated_price;
	var $recurring_total_negotiated_price;
			
	function oqc_Contract() {
		parent::oqc_ContractBase();
	}
	
	/* workaround for sugarcrm bug in SugarBean class
	 * 
	 * sugarcrm cannot set the name of the signed document correctly because it is empty.
	 * however, the user cannot access the file because the name is empty. so we set the
	 * name to make sure, that the user can see and download the contract file.
	 * 
	 * unfortunately this change cannot be saved in the document bean because the name of
	 * the document is not stored in the database (source => non-db)
	 * 
	 * function fill_in_relationship_fields(){
	 * ....
	 *		if (isset($mod->name)) {
	 * 			$this->$name = $mod->name;
	 * 		}
	 * ....
	 * }
	 * 
	 **/
	
	function fill_in_relationship_fields() {
		parent::fill_in_relationship_fields();
		
		if (!empty($this->signedcontractdocument_id)) {
			$document = new Document();
			
			if ($document->retrieve($this->signedcontractdocument_id)) {
				$this->signedcontractdocument = $document->document_name;
			}
		}
	}

	// returns an array containing all additions of a contract
	function getAdditions() {
		if (!empty($this->idsofadditions)) {
			$additionsArray = array();
			$additionIds = explode(" ", trim($this->idsofadditions));
			
			// iterate over addition ids
			foreach ($additionIds as $additionId) {
				$addition = new oqc_Addition();
				// add the addition to the additions array if it could be retrieved
				if ($addition->retrieve($additionId)) {
					if (! $addition->deleted) {
						$additionsArray[] = $addition;					
					}
				}
			}
			
			return $additionsArray;
		}
		return array();
		
	}
	
	function get_summary_text() {
		return $this->name;
		}
		
	function oqc_delete_relationships($id) {
		//$remove_relationships = array();
		$remove_relationships = array('documents', 'oqc_service', 'accounts', 'contacts', 'oqc_product', 'oqc_addition');
    	//$linked_fields=array_keys($this->get_linked_fields());
		//$remove_relationships = array_diff($linked_fields,$keep_relationships);
    	foreach ($remove_relationships as $name)
    	{
    		if ($this->load_relationship($name))
    		{
    			//$GLOBALS['log']->fatal('relationship loaded '.$name);
    			$this->$name->delete($id);
    		}
    		else
    		{
    			$GLOBALS['log']->error('error loading relationship '.$name);
    		}
    	}
    
	}
	
	function mark_deleted($id, $timeline=true) {

		//If it is latest version, we need to mark_deleted also related oqc_additions and oqc_services, since there are no other way to remove them
		//mark_deleted also earlier versions of contract and reset contractid field of offering if offeringid is not empty.
		if ($this->is_latest) {
			$previousVersions = $this->getAllPreviousRevisions();
			
			foreach ($previousVersions as $version) {
				$version->mark_deleted($version->id, false); //Do not correct timeline since we are deleting everything
			}
			/*if (!empty($this->offeringid)) {
					$offering = new oqc_Offering();
					if ($offering->retrieve($this->offeringid)) {
						$offering->contractid = '';
						$offering->update_date_modified = false;
						$offering->save();
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
			if (!$this->load_relationship('oqc_addition')) {
					$GLOBALS['log']->error("Could not load relationship to oqc_addition. Cannot return the services related to this offering/contract!");
			} else {
				$additions = $this->get_linked_beans('oqc_addition', 'oqc_Addition');
						
				foreach ($additions as $addition) {
				$addition->mark_deleted($addition->id, false);	
					
				}
			}
			
		
		//	$this->is_latest = false; //Sets is_latest fields as for deleted record
		//	$this->save();
		//If it is not latest, just make do fix for history panel correct timeline; it will be not accesible in any other way, too;
		//Mark deleted also related oqc_services and oqc_additions since they do not have UI	
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
			} 
			if (!empty($this->offeringid)) {
					$offering = new oqc_Offering();
					if ($offering->retrieve($this->offeringid)) {
						$offering->contractid = '';
						$offering->update_date_modified = false;
						$offering->save();
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
			if (!$this->load_relationship('oqc_addition')) {
					$GLOBALS['log']->error("Could not load relationship to oqc_addition. Cannot return the services related to this offering/contract!");
			} else {
				$additions = $this->get_linked_beans('oqc_addition', 'oqc_Addition');
						
				foreach ($additions as $addition) {
				$addition->mark_deleted($addition->id);	
					
				}
			}
			
		}
			
		parent::mark_deleted($id);	

	}
	
	  
}
?>

