<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/oqc_Offering/oqc_Offering.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('include/formbase.php'); // contains function handleRedirect()

define('OFFERING_BEAN_NAME', 'oqc_Offering');
define('CONTRACT_BEAN_NAME', 'oqc_Contract');

// Recreates nextrevisions and previousrevisions fields
	function oqc_get_previousContractId($offering) {
		$previousContractId = '';
		if (!empty($offering->contractid)) {
			return $offering->contractid;}
		
		if(empty($offering->previousrevision)) {
			return ''; //$contract->previousrevision = '';
			}
		else {
			$old_offering = new oqc_Offering();
			$old_offering->retrieve($offering->previousrevision);
			if(! empty($old_offering->contractid)) {
				$previousContractId = $old_offering->contractid;
				//$contract->previousrevision = $old_offering->contractid;
				}
			else { $previousContractId = oqc_get_previousContractId($old_offering); }
		}
		return $previousContractId;
		//$contract->nextrevisions = '';
	}


if (isset($_GET['record']) && isset($_GET['module']) && $_GET['module'] == OFFERING_BEAN_NAME) {
	$id = $_GET['record'];
	$offering = new oqc_Offering();

	if ($offering->retrieve($id)) {
		//1.7.6 allows to create contract only from latest quote; 
		//checks if contract already exists, avoids loss of contract reference if user push cancel button
		if($offering->is_latest == 1) {
			//$GLOBALS['log']->error("Starting revision search");
			$previousContractId = oqc_get_previousContractId($offering);
			 
			if (!$previousContractId) {
			$contract = new oqc_Contract();
		
			// copy all data from offering into the contract
			$contract->loadFromRow($offering->fetched_row);
		  
		
			// unset id to make sure that we create a new contract
			unset($contract->id);
			$contract->document_id ='';
			//1.7.6 Unset also svnumber to allow unique # creation 
			$contract->svnumber = '';
			$contract->abbreviation = ''; //1.7.6 Unset also abbreviation since quote has different options

			global $timedate;
				if (empty($contract->startdate)) {
				$contract->startdate = date($timedate->get_date_format()); }

			$contract->version = intval($offering->version);
			$contract->deleted = 1;
			$contract->is_latest = 0;
			$contract->offeringid = $id;
			$contract->nextrevisions = '';
			$contract->previousrevision = '';
			$contract->oqc_template = '';
			// Some variables needs to be converted to floats in order to avoind Deprecated warnings
			$contract->total_cost = floatval($contract->total_cost);
			$contract->install_cost = floatval($contract->install_cost);
			$contract->shipment_cost = floatval($contract->shipment_cost);
			$contract->grand_total_vat = floatval($contract->grand_total_vat);
			$contract->unique_total_negotiated_price = floatval($contract->unique_total_negotiated_price);
			$contract->recurring_total_negotiated_price = floatval($contract->recurring_total_negotiated_price);			
			
			$contract->save();

			// add relationships after save because we need a new id
			$contract->add_relationships_from($offering);
		
			$offering->contractid = $contract->id;
			$offering->processed_dates_times = array();
			$offering->save();
		
			// redirect to contract in EditView; signal that temporary version should not be versioned by setting isLinked
			return header("Location: index.php?action=EditView&module=oqc_Contract&record={$contract->id}&isLinked=true");
			}
			else {
			$contract = new oqc_Contract();
				if ($contract->retrieve($previousContractId) ) {
					if ($contract->deleted == 1) { //2.0 Contract is in deleted state because user pushed cancel instead of save; just redirect to it 

						//$GLOBALS['log']->fatal("CreateContract:going branch 2");
						
						return header("Location: index.php?action=EditView&module=oqc_Contract&record={$contract->id}&isLinked=true");
					}
					if ($contract->version != $offering->version) {
						//$GLOBALS['log']->error("CreateContract:going branch 3");
						$oldsvnumber = $contract->svnumber;
						$newContract = new oqc_Contract();
						
						$newContract->loadFromRow($offering->fetched_row);
						unset($newContract->id);
						$newContract->document_id = '';
						$newContract->abbreviation = '';
						global $timedate;
							if (empty($newContract->startdate)) {
							$newContract->startdate = date($timedate->get_date_format());}
						$newContract->svnumber = $oldsvnumber; // keep the same svnumber of contract and set the same version as quote
						$newContract->version = intval($offering->version);
						$newContract->deleted = 1;
						$newContract->is_latest = 0;
						$newContract->offeringid = $id;
						$newContract->previousrevision = $contract->id;
						$newContract->nextrevisions = '';
						$newContract->oqc_template = '';
						// Some variables needs to be converted to floats in order to avoind Deprecated warnings
						$newContract->total_cost = floatval($newContract->total_cost);
						$newContract->install_cost = floatval($newContract->install_cost);
						$newContract->shipment_cost = floatval($newContract->shipment_cost);
						$newContract->grand_total_vat = floatval($newContract->grand_total_vat);
						$newContract->unique_total_negotiated_price = floatval($newContract->unique_total_negotiated_price);
						$newContract->recurring_total_negotiated_price = floatval($newContract->recurring_total_negotiated_price);
						//$GLOBALS['log']->error('Test variable type '. gettype($this->bean->total_cost));
						
												
						$newContract->save();
						// add relationships after save because we need a new id
						$newContract->add_relationships_from($offering);
						// update old contract nextrevision field
						$contract->nextrevisions = $newContract->id;
						$contract->save();
						
						$offering->contractid = $newContract->id;
						$offering->processed_dates_times = array();
						$offering->save();
						
		
						// redirect to contract in EditView; signal that temporary version should not be versioned by setting isLinked
						 return header("Location: index.php?action=EditView&module=oqc_Contract&record={$newContract->id}&isLinked=true");
					}
					else {
						$GLOBALS['log']->fatal("You already created contract for this offering! Please modify existing Contract or create new revision of Quote");
						return header("Location: index.php?action=DetailView&module=oqc_Contract&record={$contract->id}"); 
					}
				}
			}
		}
		else {
			$GLOBALS['log']->fatal("You are trying to create contract not from last version of Quote! Please create new revision of Quote");
			return header("Location: index.php?action=DetailView&module=oqc_Offering&record={$offering->id}"); 
		}	
	}
	else {
		$GLOBALS['log']->fatal("Offering with id '$id' could not be found! Cannot create a contract.");
	}
}
else {
		$GLOBALS['log']->fatal("Could not extract record and module fields from _GET array");
}


?>
