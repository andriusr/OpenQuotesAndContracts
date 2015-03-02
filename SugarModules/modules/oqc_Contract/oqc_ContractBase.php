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

require_once('include/SugarObjects/templates/issue/Issue.php');
require_once('modules/Contacts/Contact.php');
require_once('modules/oqc_TextBlock/oqc_TextBlock.php');
require_once('modules/oqc_EditedTextBlock/oqc_EditedTextBlock.php');
require_once('modules/Documents/Document.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');
require_once('modules/Currencies/Currency.php');
//require_once('modules/oqc_Offering/oqc_Offering.php');
//require_once('modules/oqc_Addition/oqc_Addition.php');
require_once('modules/oqc_Service/oqc_Service.php');


class oqc_ContractBase extends Issue {
		var $new_schema = true;
		
		var $id;
		var $name;
		var $date_entered;
		var $date_modified;
		var $modified_user_id;
		var $modified_by_name;
		var $created_by;
		var $created_by_name;
		var $description;
		var $deleted;
		var $created_by_link;
		var $modified_user_link;
		var $assigned_user_id;
		var $assigned_user_name;
		var $assigned_user_link;
		var $contract_number;
		var $type;
		var $status;
		var $priority;
		var $resolution;
		var $work_log;
		var $services;
		var $attachments;
		var $abbreviation;
		var $technicalcontact_id;
		var $technicalcontact;
		var $contactperson_id;
		var $contactperson;
		var $textblockediting;
		var $clienttechnicalcontact_id;
		var $clienttechnicalcontact;
		var $clientcontact_id;
		var $clientcontact;
		var $officenumber;
		var $document_id;
		var $textblocksequence;
		var $idoffreetextblock;
		var $previousrevision;
		var $startdate;
		var $enddate;
		var $version;
		var $nextrevisions;
		var $vat;
		var $attachmentsequence;
		var $company;
		var $company_id;
		var $new_with_id = false; //required from 6.4
		var $total_cost;
		var $grand_total_vat;
		
	function oqc_ContractBase(){	
		parent::Issue();
	}

	function bean_implements($interface){
		switch($interface){
			case 'ACL': return true;
		}
		return false;
	}

	function addNextRevisionId($id) {
		//if (empty($this->nextrevisions))
			$this->nextrevisions = $id;
		//else
		//	$this->nextrevisions .= ' ' . $id;
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
	
	    //2.0 function for getting latest revision bean
        function getLatestRevision() {
                $latestProduct = new $this->object_name();
                $nextProduct = new $this->object_name();
                $nextProduct->nextrevisions = $this->nextrevisions;
					 
                while ($latestProduct->retrieve($nextProduct->nextrevisions)) {
                        $nextProduct = $latestProduct;
                }

                return $nextProduct;
        }
        //2.0 function for getting latest revision id
        function getLatestRevisionFromId($id) {
        				
                $latestProduct = new $this->object_name();
                $nextProduct = new $this->object_name();
                $nextProduct->nextrevisions = $id;
					 $nextProduct->id = $id;
                while ($latestProduct->retrieve($nextProduct->nextrevisions)) {
                        $nextProduct = $latestProduct;
                }

                return $nextProduct->id;
        }
        
        function getLatestRevisionVersion($id) {
        				
                $latestProduct = new $this->object_name();
                $nextProduct = new $this->object_name();
                $nextProduct->nextrevisions = $id;
					 $nextProduct->id = $id;
                while ($latestProduct->retrieve($nextProduct->nextrevisions)) {
                        $nextProduct = $latestProduct;
                }

                return $nextProduct->version;
        }
        //end 2.0 methods
	
	
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
	
	
	

	// retrieve specified record even if deleted by default
	function retrieve($id = -1, $encode = true, $deleted = false) {
		return parent::retrieve($id, $encode, $deleted);
	}

	function fill_in_officenumber() {
		$account = new Account();
		if ($account->retrieve($this->company_id)) {
			$this->officenumber = $account->officenumber_c;
		}
	}
// 1.7.6 rewrite of code for unique number generation 
	function fill_in_svnumber() {


		global $timedate;
//		$date = $timedate->swap_formats($this->date_entered, $timedate->get_date_time_format(), strrev($timedate->get_date_format()));
		$date = date("ymd");
		$fldname = strtolower(get_class($this)).'_number';
		//2.2RC2 Use translated abbreviations
		global $app_list_strings;
		if (isset($app_list_strings["contract_abbreviation_list"][$this->abbreviation])) {
			$abbreviation = $app_list_strings["contract_abbreviation_list"][$this->abbreviation];
		} else { $abbreviation = $this->abbreviation;}
		$this->svnumber = $abbreviation . $date . '/'. $this->$fldname;
	}
//end

	function get_linked_textblocks() {
		$textBlocks = $this->get_linked_beans('oqc_textblock', 'oqc_TextBlock', NULL, 0, -1, 0);
		$deletedTextBlocks = $this->get_linked_beans('oqc_textblock', 'oqc_TextBlock', NULL, 0, -1, 1);

		return array_merge($textBlocks, $deletedTextBlocks);
	}

	function get_linked_edited_textblocks() {
		return $this->get_linked_beans('oqc_editedtextblock', 'oqc_EditedTextBlock');
	}


	function get_all_linked_textblocks() {
		// return array_merge($this->get_linked_textblocks(), $this->get_linked_edited_textblocks());
		$textblockIds = explode(' ', trim($this->textblocksequence));
		$textblocks = array();

		foreach ($textblockIds as $id) {
			$textblock = new oqc_Textblock();
			$editedTextblock = new oqc_EditedTextBlock();

			if ($textblock->retrieve($id)) {
				$textblocks[] = $textblock;
			} else if ($editedTextblock->retrieve($id)) {
				$textblocks[] = $editedTextblock;
			}
		}

		return $textblocks;
	}
	/*
	function get_all_linked_attachments() {
		$attachmentIds = explode(' ', trim($this->attachmentsequence));
		$attachments = array();
	
		foreach ($attachmentIds as $id) {
			$attachment = new Document();
	
			if ($attachment->retrieve($id)) {
				$attachments[] = $attachment;
			}
		}
	
		return $attachments;
	} */
	//2.1 we return here documents ids (old method) or revision id (new method).
	function get_all_linked_attachments() {
	$attachmentIds = explode(' ', trim($this->attachmentsequence));
	$attachments = array();

	foreach ($attachmentIds as $id) {
		$revision = new DocumentRevision();
		if (!$revision->retrieve($id)) {
		// if in old format try to recover by document id	
			
			$attachment = new Document();
			if ($attachment->retrieve($id)) {
				$attachments[] = $attachment->id;
			}
		} else {
		$attachments[] = $revision->id;
		}
	}

	return $attachments;
	}
		
	function add_relationships_from($bean) {
		$relationships = array('documents', 'oqc_service');
		
		foreach ($relationships as $relationship) {
			$this->load_relationship($relationship);
			$bean->load_relationship($relationship);
			
			$linkedBeanIds = $bean->$relationship->get();
			foreach ($linkedBeanIds as $id)
				$this->$relationship->add($id);
		}
	}
	//1.7.6 we need function to keep quotes/projects/ExternalContracts 
	
	function oqc_cleanup_relationships($id) {
		$remove_relationships = array();
		$keep_relationships = array('project', 'oqc_offering','oqc_externalcontract','company_link', strtolower($object_name) .'_contact_link');
    	$linked_fields=array_keys($this->get_linked_fields());
		$remove_relationships = array_diff($linked_fields,$keep_relationships);
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
	// Deletes relationships that are re-created during save; override this in each sub-class for custom relationships 
	function oqc_delete_relationships($id) {
		//$remove_relationships = array();
		$remove_relationships = array('documents', 'oqc_service', 'accounts', 'contacts', 'oqc_product');
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
    			$GLOBALS['log']->error('error loading relationship');
    		}
    	}
    
	}  
	
	function oqc_cleanup_document_revision($id) {
		$contract =  new $this->object_name();
		if($contract->retrieve($id)) {
			if (!empty($contract->document_id)) {
			$document = new Document();
				if($document->retrieve($contract->document_id)) {
					if(!empty($document->document_revision_id)) {
						$revision = new DocumentRevision();
						 if($revision->retrieve($document->document_revision_id)) {
						 	 if($revision->revision == $contract->version) {
						 	 	$revision->mark_deleted($revision->id);
						 	 	}
						 	 }
						  $document->document_revision_id = '';
						 	 //$document->document_revision_id = null;
						  $document->save();	
						 }
					}
				}
			}
		
		
		}
	
	function find_document_id() {
				
			if(empty($this->previousrevision)) {
				return null;
			}
			else {
			$old_contract =  new $this->object_name();
			$old_contract->retrieve($this->previousrevision);
			if(! empty($old_contract->document_id)) {
				return $old_contract->document_id;
				}
			else { return $old_contract->find_document_id($old_contract); }
			}
		}

/*		function oqc_delete_relationships($id) {
		$relationships = array('documents', 'oqc_service');
		
		foreach ($relationships as $relationship) {
			$this->load_relationship($relationship);
						
//			$linkedBeanIds = $this->$relationship->get();
//			foreach ($linkedBeanIds as $id)
				$this->$relationship->delete($id);
				$GLOBALS['log']->fatal('relationship '.$id.' deleted');
		}
	} */




	function save_relationship_changes($is_update, $exclude = array()) {
		parent::save_relationship_changes($is_update, $exclude);

		$contacts = 'contacts';
		$this->load_relationship($contacts);
		
		$accounts = 'accounts';
		$this->load_relationship($accounts);
		
		$contact = new Contact();
		if ($contact->retrieve($this->clientcontact_id)) {
			$this->$contacts->add($this->clientcontact_id);
			$this->$accounts->add($contact->account_id);
		}

		if ($contact->retrieve($this->clienttechnicalcontact_id)) {
			$this->$contacts->add($this->clienttechnicalcontact_id);
			$this->$accounts->add($contact->account_id);
		}
		
		$account = new Account();
		if ($account->retrieve($this->company_id)) {
			$this->$accounts->add($this->company_id);
		}
		
		$products = 'oqc_product';
		$this->load_relationship($products);
		
		
		$services = $this->get_linked_beans('oqc_service', 'oqc_Service');		
		foreach ($services as $service) {
			$this->$products->add($service->product_id);
		}
	}
	
	function save($check_notify = false) {
		
		$this->fixDatetimes();
		$return_id = parent::save($check_notify);
	
		
		return $return_id;
	}
	
	//2.1 avoid annoying depracated warnings and date conversion errors in sugarlog
	function fixDatetimes() {
		global $timedate;
		$date_array = array(
		array('datetime', 'date_modified'),
		array('datetime', 'date_entered'),
		array('date', 'startdate'),
		array('date', 'enddate'),
		array('date', 'signedon'),
		array('date', 'deadline'),
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
	
	function fill_in_additional_list_fields() {
		parent::fill_in_additional_list_fields();
	//	$GLOBALS['log']->error("Contract currency_1:". $this->currency_id);
		
		if(isset($this->currency_id) && $this->currency_id !='') {
			
			
		    $currency = new Currency();
		 //   $test = $currency->retrieve($this->currency_id);
		 //   $GLOBALS['log']->error("Currency retrieve:". var_export($test, true));
		    $currency->retrieve($this->currency_id);
		    if($currency->id != $this->currency_id || $currency->deleted == 1){
		    	//2.2RC1 Some legacy code to determine currency_id
		    	$currencyList = new ListCurrency();
				$currencyList->lookupCurrencies();
				$legacy = false;
				if(isset($currencyList->list ) && !empty($currencyList->list )){
					foreach ($currencyList->list as $data){
						if($data->status == 'Active'){
							if ($data->name == $this->currency_id) {
								$this->currency_id = $data->id;
								$legacy = true ;
								break;
							}
						}
					}
				}
		    	if (!$legacy) {
		    		$this->currency_id = $currency->id;
    		 	}
    	// 	$GLOBALS['log']->error("Contract currency_2:". $this->currency_id . ' ' .$currency->id);
    		 }	
    		 
		} else {$this->currency_id = '-99';
	//	$GLOBALS['log']->error("Contract currency_3:". $this->currency_id);
		}
		$this->grand_total = $this->total_cost + $this->grand_total_vat;
	//	$GLOBALS['log']->error("Contract currency_4:". $this->currency_id);
		
		 if ( $this->force_load_details == true)
                {
                        $this->fill_in_additional_detail_fields();
                }
	
	}
	
	function fill_in_additional_detail_fields() {
		parent::fill_in_additional_detail_fields();
		
		if(isset($this->currency_id) && $this->currency_id !='') {
		    $currency = new Currency();
		    $currency->retrieve($this->currency_id);
    		if($currency->id != $this->currency_id || $currency->deleted == 1){
    	//			$this->amount = $this->amount_usdollar;
    				$this->currency_id = $currency->id;
    		}
		} else {$this->currency_id = '-99';}
		
		
	}
	
//2.2RC1 re-write of delete action for safe deletion of records	
/*	function mark_relationships_deleted($id) {
		// This function is called from $this->mark_deleted.
		// But we do NOT want to delete any relationships
		// as these are still needed.
		
		// Relationships can be deleted with $this->delete_linked
	} */
	
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

			// Take the item off the recently viewed lists
			$tracker = new Tracker();
			$tracker->makeInvisibleForAll($id);
	
	}
	
	
}
?>
