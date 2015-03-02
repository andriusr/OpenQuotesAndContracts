<?php
require_once('include/MVC/Controller/SugarController.php');
require_once('modules/oqc_Service/oqc_Service.php');
require_once('modules/oqc_TextBlock/oqc_TextBlock.php');
require_once('modules/oqc_EditedTextBlock/oqc_EditedTextBlock.php');
require_once('modules/Documents/Document.php');
require_once('modules/oqc_Contract/oqc_ContractBaseController.php');

class oqc_OfferingController extends oqc_ContractBaseController
{
//1.7.6 Quotes version always is incresed by 1 when saving (required by workflow), while svnumber is kept the same.
	
function action_save() {
		$old_id = '';
		if ($this->bean->is_latest) {
			$old_id = $this->bean->id;
			$this->bean->version = $this->bean->version + 1;}
			else {
				$latestRevision = $this->bean->getLatestRevision($this->bean->id) ;
				$old_id = $latestRevision->id;
				$this->bean->version = intval($latestRevision->version +1);
				}
		if (empty($this->bean->contractid)) {
			
			unset($this->bean->id);
			unset($this->bean->{$this->bean->table_name . '_number'});

			$this->bean->deleted = 0;
			$this->bean->nextrevisions = '';
			$this->bean->is_latest = 1; //1.7.6
			$this->bean->previousrevision = $old_id;
			//$this->bean->version = $this->bean->getHeadVersion() + 1;

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
		}
		/* 1.7.6 Logic does not depends on whether Contract was created or not; but this might be required in the future */
		else {
			unset($this->bean->id);
			unset($this->bean->{$this->bean->table_name . '_number'});

			$this->bean->deleted = 0;
			$this->bean->nextrevisions = '';
			$this->bean->is_latest = 1; //1.7.6
			$this->bean->previousrevision = $old_id;
			$this->bean->version = $this->bean->getHeadVersion() + 1;
			$this->bean->contractid = ''; // remove link to contract since its no longer is valid 

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

		if ($old_id != '') {
			$oldBean = new $this->bean->object_name();
			if ($oldBean->retrieve($old_id)) {
				$oldBean->addNextRevisionId($this->bean->id);
				$oldBean->save();
				// hide previous version
				$this->bean->oqc_mark_deleted($old_id); 
			}
		}
		
	}
	
	
}

?>
