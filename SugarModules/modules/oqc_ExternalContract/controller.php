<?php
require_once('modules/Contacts/Contact.php');
require_once('modules/Accounts/Account.php');
require_once('include/oqc/common/common.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('modules/oqc_ExternalContractCosts/oqc_ExternalContractCosts.php');
require_once('modules/oqc_ExternalContractPositions/oqc_ExternalContractPositions.php');
require_once('modules/oqc_ExternalContractDetailedCosts/oqc_ExternalContractDetailedCosts.php');
require_once('include/MVC/Controller/SugarController.php');
require_once('modules/oqc_ExternalContract/ExternalContractPdfCreator.php');

class oqc_ExternalContractController extends SugarController
{
	function action_Archive() {
		$this->bean->is_archived = true;
		$this->bean->save();
	
		// fake version attribute to force page reload	
		$url = "index.php?module=".$this->module."&action=DetailView&record=".$this->bean->id.'&version='.rand();
		$this->set_redirect($url);
	}

	function action_Restore() {
		$this->bean->is_archived = false;
		$this->bean->save();

		// fake version attribute to force page reload	
		$url = "index.php?module=".$this->module."&action=DetailView&record=".$this->bean->id.'&version='.rand();
		$this->set_redirect($url);
	}

	function action_CreatePdf() {
		$pdfCreator = new ExternalContractPdfCreator();
		$pdfCreator->createPdf($this->bean);
	}

	function begin_new_version() {
		$old_id = $this->bean->id;

		// unset old baggage, which will automatically be created on parent::action_save
		unset($this->bean->id);
		unset($this->bean->{$this->bean->table_name . '_number'});

		// ensure that this bean is fresh even when editing an old deleted version.
		$this->bean->deleted = 0;
		$this->bean->nextrevisions = '';
		$this->bean->is_latest = 1; //1.7.6

		$this->bean->previousrevision = $old_id;
		$this->bean->version = $this->bean->getHeadVersion() + 1;

		return $old_id;
	}

	// should only be called after parent::action_save, because $this->bean->id is needed
	function end_new_version($old_id) {
		// hide previous head revision.
		$oldHeadId = $this->bean->getHeadId();
		if ($oldHeadId != $this->bean->id) {
			$this->bean->oqc_mark_deleted($oldHeadId);
		}

		// remember this bean as the next revision
		$oldBean = new $this->bean->object_name();
		if ($oldBean->retrieve($old_id)) {
			$oldBean->addNextRevisionId($this->bean->id);
			$oldBean->save();
		}

		// redirect to new version
		$this->return_id = $this->bean->id;
		$this->return_module = $this->module;
	}
	//1.7.6 added for saving of Documents- copy from Products module
	//2.1 rewrite this function to store revision ids instead of document ids 
	private function saveAttachedDocuments() {
		
	//	$documents = 'documents';
	//	$this->bean->load_relationship($documents);
		$sequence = array();
		if (isset($_POST["document_status"]) && (!empty($_POST["document_status"]))) {
		for ($i = 0; $i < count($_POST["document_status"]); $i++) {
			$document_id = $_POST['document_ids'][$i];
			if ($_POST["document_status"][$i] == 'delete') {
				$revision = new DocumentRevision();
				if ($revision->retrieve($_POST['document_ids'][$i])) {
					$document_id = $revision->document_id;
					}
				$document = new Document();
				$document->retrieve($document_id);
				$changes = array('field_name' => $document->document_name, 'data_type' => 'varchar', 'before' => $document->filename, 'after' => '<deleted>');
					 global $sugar_version;
                if(floatval(substr($sugar_version,0,3)) > 6.3) {
                $this->bean->db->save_audit_records($this->bean, $changes); }
                else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
			} else {
				$revision = new DocumentRevision();
				if ($revision->retrieve($_POST['document_ids'][$i])) {
					$document_id = $revision->document_id;
					}
		//		$this->bean->$documents->add($document_id); //2.1 We do not add documents here; only pdf files should be added 
				$document = new Document();
				$document->retrieve($document_id);

				if ($_POST["document_status"][$i] == 'new') {
					$changes = array('field_name' => $document->document_name, 'data_type' => 'varchar', 'before' => '<n/a>', 'after' => $document->filename);
					global $sugar_version;
               if(floatval(substr($sugar_version,0,3)) > 6.3) {
               $this->bean->db->save_audit_records($this->bean, $changes); }
               else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
				}

				$sequence[] = $_POST['document_ids'][$i];
			}
		}
		}
		$this->bean->attachmentsequence = implode(' ', $sequence);
		
	}
	

	function action_save() {
		// make duplicate create new costs and positions
		$isDuplicate = empty($_REQUEST['record']) && empty($_REQUEST['return_id']);
		// check if there are any modifications
		$modified = hasBeenModified($this->bean, array('finalcosts'));
		
		if (!$isDuplicate && !$modified) {
			return; // skip save if this is not a duplicate and nothing has nothing has been modified 
		}
		
		if ($this->bean->enddate != $_REQUEST['enddate']) {
			$this->bean->already_notified = false; // notify user again because the enddate has changed.
		}

		// save id of user that created the old version
		global $timedate;
		$dateCreated = $timedate->to_db($this->bean->date_entered);
		$createdById = $this->bean->created_by;

		$old_id = $this->begin_new_version();
		parent::action_save();
		$this->end_new_version($old_id);

		// save related data. parent::action_save() had to be called once already (auditing).
		$this->saveCosts($isDuplicate);
		$this->savePositions($isDuplicate);
		$this->saveSVNumbers();
		$this->saveAttachedDocuments(); //1.7.6
		
		// the new contract should have the same creator and creation date as the previous version, fix for #486
		if ($dateCreated) { $this->bean->date_entered = $dateCreated; } 
		if ($createdById) { $this->bean->created_by = $createdById; }
		
		// workaround for #487: write id stored in created_by field into assigned_user_id field to make sure that searches similiar to 'only my items' work properly 
		$this->bean->assigned_user_id = $this->bean->created_by;
		
		parent::action_save();

		$accountRelationName = 'accounts';
		$contactsRelationName = 'contacts';

		// make sure that the relations can be loaded
		if ($this->bean->load_relationship($accountRelationName) && $this->bean->load_relationship($contactsRelationName)) {
			if ($this->relationshipHasBeenChanged(new Account(), $accountRelationName, array('account_id'))) {
				// delete relationsships to accounts and contacts
				$this->removeAllFromRelationship(new Account(), $accountRelationName);

				// add the relationsships  again. this avoids duplicates and outdated data
				$this->bean->accounts->add($this->bean->account_id);
			}

			if ($this->relationshipHasBeenChanged(new Contact(), $contactsRelationName, array('clientcontact_id', 'technicalcontact_id'))) {
				// delete relationsships to accounts and contacts
				$this->removeAllFromRelationship(new Contact(), $contactsRelationName);

				// add the relationsships  again. this avoids duplicates and outdated data
				$this->bean->contacts->add($this->bean->clientcontact_id);
				$this->bean->contacts->add($this->bean->technicalcontact_id);
				// TODO add relationship to employee (contact_id)
			}
		}
	}

	// check if an item with the given $id exists in the relationship called $relationshipName
	private function relationshipExists($template, $relationshipName, $id) {
		if ($this->bean->load_relationship($relationshipName)) {
			$beans = $this->bean->$relationshipName->getBeans($template);

			foreach ($beans as $bean) {
				if ($id === $bean->id) {
					return true;
				}
			}

			return false;
		}
	}

	// removes all items from relationship called $relationshipName
	private function removeAllFromRelationship($template, $relationshipName) {
		if ($this->bean->load_relationship($relationshipName)) {
			$this->bean->$relationshipName->delete($this->bean->id);
			return true;
		}

		return false;
	}

	// check if the relationship called $relationshipName has been changed after saving the last time
	// the $keys parameter specifies the attribute names ($this->bean->$key) that are used for the check
	private function relationshipHasBeenChanged($template, $relationshipName, $keys) {
		$idArray = $this->getIdsOfRelatedItems($template, $relationshipName);

		foreach ($keys as $key) {
			// compare the ids of the related items with $this->bean->$key
			if (array_search($this->bean->$key, $idArray) === false) {
				// if $this->bean->$key does not exist in the $idArray the relationship has been changed
				return true;
			}
		}

		return false;
	}

	// returns an array containing the ids of the items taking part in the relationship called $relationshipName
	private function getIdsOfRelatedItems($template, $relationshipName) {
		$idArray = array();
		$beans = $this->bean->$relationshipName->getBeans($template);
		foreach ($beans as $bean) {
			$idArray[] = $bean->id;
		}
		return $idArray;
	}

	private function auditDeletedPositions() {
		$positionIds = explode(' ', $this->bean->positions);
		foreach ($positionIds as $positionId) {
			if (isset($_REQUEST['positionIds']) && !in_array($positionId, $_REQUEST['positionIds'])) {
				$position = new oqc_ExternalContractPositions();
				if ($position->retrieve($positionId)) {
					$changes = array('field_name' => translate('LBL_POSITIONS'), 'data_type' => 'text', 'before' => $position->as_plain_text(), 'after' => '<deleted>');
					global $sugar_version;
                if(floatval(substr($sugar_version,0,3)) > 6.3) {
                $this->bean->db->save_audit_records($this->bean, $changes); }
                else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
				}
			}
		}
	}

	private function savePositions($isDuplicate) {
		$this->auditDeletedPositions();

		if (isset($_REQUEST['positionIds']) && is_array($_REQUEST['positionIds'])) {
			$positionIds = array();
			$numberOfPositions = count($_REQUEST['positionIds']);

			for ($i=0; $i<$numberOfPositions; $i++) {
				$id = $_REQUEST['positionIds'][$i];
				$name = $_REQUEST["positionName_$id"];
				$type = $_REQUEST['positionType'][$i];
				$qty = $_REQUEST["positionQuantity_$id"];
				$price = $_REQUEST["positionPrice_$id"];
				$desc = $_REQUEST["positionDescription_$id"];

				$position = new oqc_ExternalContractPositions();

				$beforeText = null;
				if (!$isDuplicate && $position->retrieve($id)) {
					// position could be successfully found in db, it is initialized with old values from database
					if ($position->name != $name || $position->type != $type || $position->quantity != $qty || $position->price != $price || $position->description != $desc) {
						$beforeText = $position->as_plain_text();
					}
				} else {
					$beforeText = '<n/a>';
				}

				// set new values for position
				$position->name = $name;
				$position->type = $type;
				$position->quantity = $qty;
				$position->description = $desc;
				$position->price = $price;
				
				// does an update if the position already existed or an insert if it is a new position
				$position->save();

				// add the position id to the list of positions for this external contract instance
				$positionIds[] = $position->id;

				if (isset($beforeText)) {
					$changes = array('field_name' => translate('LBL_POSITIONS'), 'data_type' => 'text', 'before' => $beforeText, 'after' => $position->as_plain_text());
					global $sugar_version;
                if(floatval(substr($sugar_version,0,3)) > 6.3) {
                $this->bean->db->save_audit_records($this->bean, $changes); }
                else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
				}
			}

			if ($numberOfPositions > 0) {
				$this->bean->positions = implode(' ', $positionIds);
			} else {
				$this->bean->positions = '';
			}
		} else {
			$this->bean->positions = '';
		}
	}

	private function auditDeletedCosts() {
		$costIds = explode(' ', $this->bean->costs);
		foreach ($costIds as $costId) {
			// TODO produces warning in logfile!!d
			if (!array_key_exists('costIds', $_REQUEST) || !in_array($costId, $_REQUEST['costIds'])) {
				$cost = new oqc_ExternalContractCosts();
				if ($cost->retrieve($costId)) {
					$changes = array('field_name' => $cost->get_name(), 'data_type' => 'text', 'before' => $cost->as_plain_text(), 'after' => '<deleted>');
					global $sugar_version;
                if(floatval(substr($sugar_version,0,3)) > 6.3) {
                $this->bean->db->save_audit_records($this->bean, $changes); }
                else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
				}
			}
		}
	}

	private function saveCosts($isDuplicate) {
		$this->auditDeletedCosts();

		if (isset($_REQUEST['costIds']) && is_array($_REQUEST['costIds'])) {
			$costIds = array();
			$numberOfCosts = count($_REQUEST['costIds']);

			for ($i=0; $i<$numberOfCosts; $i++) {
				$id = $_REQUEST['costIds'][$i];
				$price = $_REQUEST['costPrices'][$i];
				$desc = $_REQUEST['costDescriptions'][$i];
				$year = $_REQUEST['costYears'][$i];
				$category = $_REQUEST['costCategories'][$i];
				$paymentInterval =  $_REQUEST['costPayment'][$i];

				$cost = new oqc_ExternalContractCosts();

				$beforeText = null;
				if (!$isDuplicate && $cost->retrieve($id)) {
					if ($cost->price != $price || $cost->description != $desc || $cost->year != $year || $cost->category != $category || $cost->paymentinterval != $paymentInterval) {
						$beforeText = $cost->as_plain_text();
					}
				} else {
					$beforeText = '<n/a>';
				}

				$cost = new oqc_ExternalContractCosts();

				if (!$isDuplicate && $cost->retrieve($id)) {
					// the cost already exists (and this is no duplicate)
					// update the cost instead of creating a new row in the table
					$cost->price = $price;
					$cost->year = $year;
					$cost->category = $category;
					$cost->description = $desc;
					$cost->paymentinterval = $paymentInterval;
				} else {
					$cost = new oqc_ExternalContractCosts($price, $desc, $category, $year, $paymentInterval);
				}

				$cost->save();
				$costIds[] = $cost->id;

				$this->saveDetailedCost($isDuplicate, $id, $cost);

				if (isset($beforeText)) {
					$changes = array('field_name' => $cost->get_name(), 'data_type' => 'text', 'before' => $beforeText, 'after' => $cost->as_plain_text());
					global $sugar_version;
                if(floatval(substr($sugar_version,0,3)) > 6.3) {
                $this->bean->db->save_audit_records($this->bean, $changes); }
                else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
				}
			}

			if ($numberOfCosts > 0) {
				$this->bean->costs = implode(' ', $costIds);
			} else {
				$this->bean->costs = '';
			}
		} else {
			$this->bean->costs = '';
		}
	}

	// save the detailed costs for this particular cost
	// the parameter id is the id used in the _REQUEST array. we pass it as a parameter because when we are creating new cost rows id != cost->id. this means we still need the original id used in the ui to identify the value in the request array.
	private function saveDetailedCost($isDuplicate, $id, $cost) {
		$detailedCostIdString = '';
		$numberOfDetailedCosts = count($_REQUEST['detailedCostMonth_'.$id]);

		for ($i=0; $i<$numberOfDetailedCosts; $i++) {
			$detailedCostId = $_REQUEST["detailedCostId_$id"][$i];
			$month = $_REQUEST["detailedCostMonth_$id"][$i];
			$price = $_REQUEST["detailedCostPrice_$id"][$i];
				
			$detailedCost = new oqc_ExternalContractDetailedCosts();
			if (!$isDuplicate && $detailedCost->retrieve($detailedCostId)) {
				// the detailed cost already exists. just do an update instead of creating a new row in the database
				$detailedCost->price = $price;
				$detailedCost->month = $month;
				$detailedCost->cost_id = $cost->id;
			} else {
				$detailedCost = new oqc_ExternalContractDetailedCosts($price, $month, $cost->id);
			}
			$detailedCost->save();

			$detailedCostIdString .= $detailedCost->id . ' ';
		}

		$cost->detailedcost_ids = trim($detailedCostIdString);
		$cost->save();
	}
	
	private function assembleSVNumbersIntoArray() {
	$i=0;	
	foreach ($_REQUEST as $key => $value) {
			
		if ( strpos($key, 'svnumbersName') !== false) {
			
			$svtem = explode('_', $key);
			$_REQUEST['svnumberNames'][$i] = $value;
			$_REQUEST['svnumberIds'][$i] = $_REQUEST["svnumbersId_".$svtem[1]]; 
			$i=$i+1;
		}
			
	}
	//$GLOBALS['log']->fatal(var_export($_REQUEST['svnumberNames'],true));
	}

	private function auditDeletedSVNumbers() {
		$svIds = explode($this->bean->svnumber_sep, $this->bean->svnumbers);
		foreach ($svIds as $svId) {
			if (!empty($svId) && !in_array($svId, $_REQUEST['svnumberIds']) && !in_array($svId, $_REQUEST['svnumberNames'])) {
				$contract = new oqc_Contract();
				if ($contract->retrieve($svId)) {
					$svName = $contract->svnumber;
				} else {
					$svName = $svId;
				}

				$changes = array('field_name' => translate('LBL_SVNUMBERS'), 'data_type' => 'text', 'before' => $svName, 'after' => '<deleted>');
				global $sugar_version;
                if(floatval(substr($sugar_version,0,3)) > 6.3) {
                $this->bean->db->save_audit_records($this->bean, $changes); }
                else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
			}
		}
	}

	private function saveSVNumbers() {
		$this->assembleSVNumbersIntoArray();
		$this->auditDeletedSVNumbers(); // should not work since $svid is not id and we have separate entries. 

		if (isset($_REQUEST['svnumberIds']) && is_array($_REQUEST['svnumberIds'])) {
			$svnumbers = array();
			$numberOfSVNumbers = count($_REQUEST['svnumberIds']);

			for($i=0; $i<$numberOfSVNumbers; $i++) {
				$contractId = $_REQUEST['svnumberIds'][$i];
				$svnumberName = $_REQUEST['svnumberNames'][$i];

				$contract = new oqc_Contract();
				if ($contract->retrieve($contractId)) {
					// the svnumber references a valid contract. save the id of the contract instead of the svnumber name in the bean.
					$svnumbers[] = $contractId;
				} else {
					// the svnumber does not reference a valid contract. throw the contractId away and just store the svnumber name.
					$svnumbers[] = $svnumberName;
				}

				// svnumber is new
				if (strpos($this->bean->svnumbers, end($svnumbers)) === false) {
					$changes = array('field_name' => translate('LBL_SVNUMBERS'), 'data_type' => 'text', 'before' => '<n/a>', 'after' => $svnumberName);
					global $sugar_version;
                if(floatval(substr($sugar_version,0,3)) > 6.3) {
                $this->bean->db->save_audit_records($this->bean, $changes); }
                else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
				}
			}

			if ($numberOfSVNumbers > 0) {
				$this->bean->svnumbers = implode($this->bean->svnumber_sep, $svnumbers);
			} else {
				$this->bean->svnumbers = '';
			}
		} else {
			$this->bean->svnumbers = '';
		}
	}
}
?>
