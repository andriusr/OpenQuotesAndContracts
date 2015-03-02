<?php
require_once('include/MVC/Controller/SugarController.php');
require_once('modules/oqc_Service/oqc_Service.php');
require_once('modules/oqc_TextBlock/oqc_TextBlock.php');
require_once('modules/oqc_EditedTextBlock/oqc_EditedTextBlock.php');
require_once('modules/Documents/Document.php');
require_once('modules/oqc_Contract/oqc_ContractBaseController.php');
require_once('modules/oqc_Contract/oqc_Contract.php');

class oqc_AdditionController extends oqc_ContractBaseController
{
	/* 2.0 Saving Addition,  version is incremented and Contract updated for latest version.
	Additions ALWAYS are referenced to the contract version it is created from */
	
	function action_save() {
		
			$old_id = null;

			$isLinked = false;
			if (isset($_POST['isLinked'])) {
				$isLinked = ($_POST['isLinked'] =='true') ? true : false ; }
			// create new version of Addition and update Contract idsofadditions field	since we are creating new version of Addition	
			if (!$isLinked && !empty($this->bean->contractid)) {
				
				if (!$this->bean->is_latest) {
				$latestVersion = $this->bean->getLatestRevision();
				$old_id = $latestVersion->id;
				$this->bean->version = intval($latestVersion->version + 1);
				}
				else {
				$old_id = $this->bean->id;
				$this->bean->version = intval($this->bean->version +1);
				}
			//$GLOBALS['log']->fatal('going branch 1');

			unset($this->bean->id);
			unset($this->bean->{$this->bean->table_name . '_number'});

			$this->bean->deleted = 0;
			$this->bean->nextrevisions = '';
			$this->bean->is_latest = 1; //1.7.6
			$this->bean->previousrevision = $old_id;

			SugarController::action_save();
			
			//retrieve saved bean for oqc...number that is created during save
			$oqc_fld_number = $this->bean->table_name . '_number';
			$savedBean = new $this->bean->object_name ;
			if ($savedBean->retrieve($this->bean->id)) {
				$this->bean->$oqc_fld_number = intval($savedBean->$oqc_fld_number);
				}
		
			// 1.7.6 Keep generated svnumber for all future references
			if (empty($this->bean->svnumber)) {
			$this->bean->fill_in_svnumber();
			}
			
			
			$this->bean->oqc_delete_relationships($this->bean->id); // deleting documents and services- will be recreated during save
			//Recreate relationship to original contract
			$contract = 'oqc_contract';
			$this->bean->load_relationship($contract);
			$this->bean->oqc_contract->add($this->bean->contractid);
			//Update idsofadditions linked of contract
			$linkedContract = new oqc_Contract();
			if ($linkedContract->retrieve($this->bean->contractid)) {
				$linkedContract->idsofadditions = str_replace($old_id, $this->bean->id, $linkedContract->idsofadditions);
				$linkedContract->save();
				}
			
		}
	
		elseif ($isLinked) {
			
			if ($this->bean->deleted == 1) {
				$this->bean->mark_undeleted($this->bean->id);}
			$this->bean->deleted = 0;	
			$this->bean->is_latest = 1;
			//$GLOBALS['log']->fatal('going branch 3');
			
			//retrieve saved bean for oqc...number that is created during save
			$oqc_fld_number = $this->bean->table_name . '_number';
			$savedBean = new $this->bean->object_name ;
			if ($savedBean->retrieve($this->bean->id)) {
				$this->bean->$oqc_fld_number = intval($savedBean->$oqc_fld_number);
				}
			
			// 1.7.6 Keep generated svnumber for all future references
			if (empty($this->bean->svnumber)) {
			$this->bean->fill_in_svnumber();
			}
			
			$this->bean->oqc_delete_relationships($this->bean->id); // deleting documents and services- will be recreated during save
			//Recreate relationship to original contract
			$contract = 'oqc_contract';
			$this->bean->load_relationship($contract);
			$this->bean->oqc_contract->add($this->bean->contractid);
			// Add new addition to the list of idsofadditions
			$linkedContract = new oqc_Contract();
			if ($linkedContract->retrieve($this->bean->contractid)) {
				$linkedContract->idsofadditions = $linkedContract->idsofadditions . " " . $this->bean->id;
				$linkedContract->save();
				}
			
		
		}
			
		if (isset($_POST['servicesVAT'])) {
			$this->bean->vat = $_POST['servicesVAT'];
		} else if (isset($_POST['servicesOnceVAT'])) {
			$this->bean->vat = $_POST['servicesOnceVAT'];
		}

		$this->saveAttachedDocuments();
		$this->saveTextblocks();
		$this->saveServices();
 
		if (!isset($_POST['assigned_user_id'])) {
		$this->bean->assigned_user_id = $this->bean->created_by;} //2.1 set this only if it is not in $_POST

		SugarController::action_save();

		// redirect to new version
		$this->return_id = $this->bean->id;
		$this->return_module = $this->module;

		// If previous version exist, hide it and update nextrevision field
		if ($old_id != '') {
		
		$oldBean = new $this->bean->object_name();
		if ($oldBean->retrieve($old_id)) {
				$oldBean->addNextRevisionId($this->bean->id);
				$oldBean->save();
				$this->bean->oqc_mark_deleted($old_id); //1.7.6
		}
		}
	}
	
}

?>
