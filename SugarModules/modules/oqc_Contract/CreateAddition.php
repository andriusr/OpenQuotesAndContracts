<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/oqc_Addition/oqc_Addition.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('include/formbase.php'); // contains function handleRedirect()

define('CONTRACT_BEAN_NAME', 'oqc_Contract');
define('ADDITION_BEAN_NAME', 'oqc_Addition');

if (isset($_GET['record']) && isset($_GET['module']) && $_GET['module'] == CONTRACT_BEAN_NAME) {
	$contractId = $_GET['record'];
	$contract = new oqc_Contract();

	if ($contract->retrieve($contractId)) {
		$addition = new oqc_Addition();
		
		// copy all data from contract into the addition
		$addition->loadFromRow($contract->fetched_row);
		
		// unset id to make sure that we create a new contract
		unset($addition->id);
		$addition->document_id = '';
		//$addition->idoffreetextblock = '';
		$addition->svnumber = '';
		$addition->abbreviation = ''; //1.7.6 Unset also abbreviation since addition has different options
		$addition->previousrevision = '';
		$addition->nextrevisions = '';
		$addition->version = 1;
		$addition->deleted = 1;
		$addition->contractid = $contractId;
		$addition->is_latest = 0;
		$addition->oqc_template = '';
		$addition->total_cost = floatval($addition->total_cost);
		$addition->install_cost = floatval($addition->install_cost);
		$addition->shipment_cost = floatval($addition->shipment_cost);
		$addition->grand_total_vat = floatval($addition->grand_total_vat);
		$addition->save();
	
		// add relationships after save because we need a new id
		$addition->add_relationships_from($contract);
		
		// TODO when the contract is changed its id is changed and the addition still
		//		references the old contract
				
		// redirect to addition in EditView; signal that temporary version should not be versioned by setting isDetached
		header("Location: index.php?action=EditView&module=oqc_Addition&record={$addition->id}&isLinked=true");
	} else {
		$GLOBALS['log']->fatal("Contract with id '$contractId' could not be found! Cannot create an addition.");
	}
} else {
		$GLOBALS['log']->fatal("Could not extract record and module fields from _GET array");
}

?>
