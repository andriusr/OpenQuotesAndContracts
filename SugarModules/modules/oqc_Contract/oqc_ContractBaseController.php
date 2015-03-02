<?php
require_once('include/MVC/Controller/SugarController.php');
require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/oqc_Service/oqc_Service.php');
require_once('modules/oqc_TextBlock/oqc_TextBlock.php');
require_once('modules/oqc_EditedTextBlock/oqc_EditedTextBlock.php');
require_once('modules/Documents/Document.php');
require_once('modules/oqc_Contract/oqc_CreatePdf.php');
require_once('modules/oqc_Offering/oqc_Offering.php');

class oqc_ContractBaseController extends SugarController
{
	function pre_EditView() {
		if (array_key_exists('isDuplicate', $_REQUEST) && $_REQUEST['isDuplicate']) {
			// forget old referenced document
			$this->bean->document_id = '';
		}
		
		// redirect to EditView
		$this->view = $this->action_view_map[strtolower($this->do_action)];
	}

	// TODO: remove if unused
	protected static function getTextBlock($id) {
		$textBlock = new oqc_TextBlock();
		if ($textBlock->retrieve($id)) {
			return $textBlock;
		} else {
			$editedTextBlock = new oqc_EditedTextBlock();
			if ($editedTextBlock->retrieve($id)) {
				return $editedTextBlock;
			}
		}

		return null;
	}


	protected function deleteTextblocks() {
		global $sugar_version;
		if (isset($_POST['TextblocksRemove'])) {
			foreach ($_POST['TextblocksRemove'] as $textblockId) {
				// try to mark the textblock as deleted if it is an instance of EditedTextBlock
				// never delete the instances of the TextBlock Bean because these are the templates

				// check if textBlock needs to be removed
				if (strpos($this->bean->textblocksequence, $textblockId) !== false) {
					$textblock = oqc_EditedTextBlock::getFromId($textblockId);
					if ($textblock)
					$textblock->mark_deleted();
					else
					$textblock = oqc_TextBlock::getFromId($textblockId);

					$changes = array('field_name' => $textblock->name, 'data_type' => 'text', 'before' => $textblock->description, 'after' => '<deleted>');
					if(floatval(substr($sugar_version,0,3)) > 6.3) {
             	$this->bean->db->save_audit_records($this->bean, $changes); }
             	else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
				}
			}
		} else {
			$GLOBALS['log']->fatal('Could not extract the TextblockRemove field');
		}
	}

	// iterate over the textblocks that should be added / updated
	// copy the descriptions into new instances of oqc_EditedTextBlock if the user changed it
	// update the sequence because the id of the textblock should no longer be referenced
	// instead the new editedtextblock is referenced by the textblocksequence field
	// returns the updated textblocksequence
	
	protected function updateTextblockDescriptions() {
		global $sugar_version;
		$sequence = $_POST['textblockSequence'];
		$textblockIds = explode(' ', trim($sequence));

		foreach ($textblockIds as $textblockId) {
			$key = "description_$textblockId";
			$userEditedDescription = $_POST[$key];
			if ($userEditedDescription == '') {
				//$GLOBALS['log']->error('skipping texblock save- empty description');
				$sequence = trim(str_replace($textblockId, '', $sequence)); //do not save if it is empty
				continue;} 

			if ($originalTextblock = oqc_TextBlock::getFromId($textblockId)) {
				// it is a TextBlock instance
				// if the user changed the description copy the information from the TextBlock instance into a new instance of EditedTextBlock
				if ($originalTextblock->description != $userEditedDescription) {
					$changes = array('field_name' => $originalTextblock->name, 'data_type' => 'text', 'before' => $originalTextblock->description, 'after' => $userEditedDescription);
				
             if(floatval(substr($sugar_version,0,3)) > 6.3) {
             $this->bean->db->save_audit_records($this->bean, $changes); }
             else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }

					$editedTextblock = new oqc_EditedTextBlock();
					$editedTextblock->name = $originalTextblock->name;
					$editedTextblock->textblock_id = $originalTextblock->id;
					$editedTextblock->description = $userEditedDescription;
					$editedTextblock->save();
					//$GLOBALS['log']->error('saved as edited original template texblock');
					if (!empty($textblockId) && !empty($editedTextblock->id)) {
						$sequence = str_replace($textblockId, $editedTextblock->id, $sequence);
					} else {
						$GLOBALS['log']->fatal('textblockId or editedTextblock->id is empty');
					}
				}

				// check if textBlock is newly added
				if (strpos($this->bean->textblocksequence, $textblockId) === false) {
					$changes = array('field_name' => $originalTextblock->name, 'data_type' => 'text', 'before' => '<n/a>', 'after' => $userEditedDescription);
					
             if(floatval(substr($sugar_version,0,3)) > 6.3) {
             $this->bean->db->save_audit_records($this->bean, $changes); }
             else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
				}
			} else if ($editedTextblock = oqc_EditedTextBlock::getFromId($textblockId)) {
				// it has to be an EditedTextBlock instance
				// update the description and save it
				if ($editedTextblock->description != $userEditedDescription) {
					//$GLOBALS['log']->error('saved as edited template texblock that was saved before');
					$changes = array('field_name' => $editedTextblock->name, 'data_type' => 'text', 'before' => $editedTextblock->description, 'after' => $userEditedDescription);
					
             if(floatval(substr($sugar_version,0,3)) > 6.3) {
             $this->bean->db->save_audit_records($this->bean, $changes); }
             else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
					$editedTextblock->id = ''; //1.7.6 avoid Quotes inheriting textblock from linked Contract and vice versa
					
					$editedTextblock->description = $userEditedDescription;
					$editedTextblock->save(); //1.7.6 getting new id
					
					if (!empty($textblockId) && !empty($editedTextblock->id)) {
						$sequence = str_replace($textblockId, $editedTextblock->id, $sequence);
						}
				}
			}
			else { //2.0 this is former free text saving part
					global $app_list_strings; 
					//$GLOBALS['log']->error('saving as free text edited texblock');
					$changes = array('field_name' => $app_list_strings["oqc"]["Textblocks"]["freeText"], 'data_type' => 'text', 'before' => '<n/a>', 'after' => $userEditedDescription);
					
             	if(floatval(substr($sugar_version,0,3)) > 6.3) {
             	$this->bean->db->save_audit_records($this->bean, $changes); }
             	else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
             	
					$newTextblock = new oqc_EditedTextBlock();
					$newTextblock->name = $app_list_strings["oqc"]["Textblocks"]["freeText"];
					$newTextblock->id = '';
					//$newTextblock->id = $textblockId;
					$newTextblock->textblock_id = '';
					$newTextblock->description = $userEditedDescription;
					$newTextblock->save();

					if (!empty($textblockId) && !empty($newTextblock->id)) {
						$sequence = str_replace($textblockId, $newTextblock->id, $sequence);
					} else {
						$GLOBALS['log']->fatal('textblockId or editedTextblock->id is empty');
					}
			
			}
		}

		return $sequence;
	}

	protected function saveTextblocks() {
		//$this->saveFreeTextBlock(); 2.0 all texblocks are treated equally 
		// TODO	deletion is done by removing the reference to the textblock
		// 		this method does nothing because TextblocksRemove is empty
		// $this->deleteTextblocks();
		$this->bean->idoffreetextblock = ''; //Free text blocks are treated as regular ones since 2.0
		$sequence = $this->updateTextblockDescriptions();

		// save the new textblock sequence
		// this "deletes" the textblocks that have been removed from the webinterface
		// TODO implement a more space-efficient deletion strategy :-)
		$this->bean->textblocksequence = $sequence;
	}

	protected function getTranslateBackArray() {
		$translateBack = array();
		$translateBack['zeitbezug'][$app_list_strings['zeitbezug_list']['once']] = "once";
		$translateBack['zeitbezug'][$app_list_strings['zeitbezug_list']['monthly']] = "monthly";
		$translateBack['zeitbezug'][$app_list_strings['zeitbezug_list']['annually']] = "annually";
		$translateBack['unit'][$app_list_strings['unit_list']['hours']] = "hours";
		$translateBack['unit'][$app_list_strings['unit_list']['pieces']] = "pieces";
			
		return $translateBack;
	}

	// Seltsamerweise kommen die Strings im Formular hier mit umschriebenen Sonderzeichen (" und \) an. Dies wird mit dieser Funktion korrigiert
	protected function sanitizeString($string) {
		$string = str_replace('\"', '"', $string);
		$string = str_replace('\\\\', '\\', $string);

		return $string;
	}

	protected function saveServices() {
		global $sugar_version;
		global $app_list_strings;
		$servicesTableName = 'oqc_service'; // NOTE: relationship name in lowercase! otherwise no effect
		$servicesModuleName = 'oqc_Service';

		if($this->bean->load_relationship($servicesTableName)) {
			require_once('include/utils.php');
			$json = getJSONobj();
			//$GLOBALS['log']->error('Services: attaching '. var_export(array_merge((array)$json->decode(from_html($_POST['uniqueJsonString'])), (array)$json->decode(from_html($_POST['recurringJsonString']))),true));
			$allServices = array_merge((array)$json->decode(from_html($_POST['uniqueJsonString'])), (array)$json->decode(from_html($_POST['recurringJsonString'])));
						
			foreach ($allServices as $service) {
				$s = $service['_oData'];
				if (!$s['isSumRow']) { // skip this service if it is a sum row from the table instead of a real service row
					$newService = new oqc_Service($s['ProductId'], floatval($s['Price']), floatval($s['Quantity']), trim($s['Name']), trim($s['Description']), $s['Tax'], $s['Recurrence'], $s['Unit'], floatval($s['DiscountValue']), $s['Discount'], intval($s['Position']), $s['Currency']);
					$newService->save();
					$this->bean->$servicesTableName->add($newService->id);

					//Do auditing if we can compare two beans 
					$oldService = new oqc_Service();
					if (isset($s['Id'])) { 	
						$oldServiceText = ($oldService->retrieve($s['Id'])) ? ($oldService->as_plain_text()) : ('<n/a>');
					}
					else {$oldServiceText = '<n/a>';}	
					$newServiceText = $newService->as_plain_text();
						//$GLOBALS['log']->error('Services: as plain text old bean'. var_export($oldServiceText,true));
						//$GLOBALS['log']->error('Services: as plain text new bean'. var_export($newServiceText,true));
					if ($oldServiceText != $newServiceText) {
						$changes = array('field_name' => trim($s['Name']), 'data_type' => 'varchar', 'before' => $oldServiceText, 'after' => $newServiceText);
						global $sugar_version;
						if(floatval(substr($sugar_version,0,3)) > 6.3) {
							$this->bean->db->save_audit_records($this->bean, $changes); }
						else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
					}
					
				}
			}
			
		} else {
			$GLOBALS['log']->fatal("Could not load_relationship($servicesTableName)");
		}
	}
	
	protected function deleteServices() {
		global $app_list_strings;
		$servicesTableName = 'oqc_service'; // NOTE: relationship name in lowercase! otherwise no effect
		$servicesModuleName = 'oqc_Service';
		if (isset($_POST['ServicesRemove']) && is_array($_POST['ServicesRemove'])) {
				foreach ($_POST['ServicesRemove'] as $deletedServiceId) {
					$serviceBean = new oqc_Service();
					$serviceBean->retrieve($deletedServiceId);
					$serviceBean->mark_deleted($deletedServiceId);

					$changes = array('field_name' => $serviceBean->name, 'data_type' => 'varchar', 'before' => $serviceBean->as_plain_text(), 'after' => '<deleted>');
					//$this->bean->db->save_audit_records($this->bean, $changes);
				}
			}
	
		//$linkedServices = $this->bean->get_linked_beans('oqc_service', 'oqc_Service');
	}
	

	protected function saveAttachedDocuments() {
		
		
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
	
/* 1.7.6 Saving Contract, if it was created from the Quote will keep the same version number as of Quote. 
	If Contract does not have reference to the quote, then each time version # is increased after save.
	Quotes and Additions have own action_save() where logic can be set to be different. */
	
	function action_save() {
		global $timedate;
		$old_id = null;
		$isLinked = false;
		if (isset($_POST['isLinked'])) {
			$isLinked = ($_POST['isLinked'] =='true') ? true : false ; }
			
			//$GLOBALS['log']->fatal('isLinked variable is '.$isLinked . ' POST is '. $_POST['isLinked'] );
		// create a detached version without quote references 		
		if (! $isLinked && empty($this->bean->offeringid)) {
			if ($this->bean->is_latest) {
			$old_id = $this->bean->id;
			$this->bean->version = $this->bean->version + 1;}
			else {
				$latestRevision = $this->bean->getLatestRevision($this->bean->id) ;
				$old_id = $latestRevision->id;
				$this->bean->version = $latestRevision->version +1;
				}
			//$GLOBALS['log']->fatal('going branch 1');

			unset($this->bean->id);
			unset($this->bean->{$this->bean->table_name . '_number'});

			$this->bean->deleted = 0;
			$this->bean->nextrevisions = '';
			$this->bean->is_latest = 1; //1.7.6
			$this->bean->idsofadditions = ''; //2.0RC2 remove additions since this is new version of Contract 
			$this->bean->previousrevision = $old_id;
			
			parent::action_save();
						
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
		/* From here we have contract that is linked to the quote- we have to do versions identical to the quote */
		elseif(! empty($this->bean->offeringid) &&  !$isLinked) {
			//$GLOBALS['log']->fatal('going branch 2');
				if ($this->bean->is_latest == 0 && ($this->bean->deleted == 0)) {
				return header("Location: index.php?action=DetailView&module={$this->bean->object_name}&record={$this->bean->id}");// do nothing user is modifying old record; otherwise it is just created from Quote 
				}
			//$GLOBALS['log']->fatal('going branch 2a');
			
			if ($this->bean->deleted == 1) {
				$this->bean->mark_undeleted($this->bean->id);
				$old_id = $this->bean->previousrevision;}
			$this->bean->deleted = 0;
			$this->bean->is_latest = 1; //1.7.6 addition
			$this->bean->idsofadditions = ''; //2.0RC2 remove additions since this is new version of Contract 
			$this->bean->oqc_cleanup_document_revision($this->bean->id); //delete document revision that is no longer valid after modification 
			if (empty($this->bean->svnumber)) {
			$this->bean->fill_in_svnumber();
			}
			$this->bean->oqc_delete_relationships($this->bean->id); // deleting documents and services- will be recreated during save
			}
		/* isLinked signals that new id already created; we need to update records
		Make previousrevision not latest; update revisions fields;
		if empty svnumber might be necessary to generate svnumber (first contract creation) */
		elseif ($isLinked) {
			
			if ($this->bean->deleted == 1) {
				$this->bean->mark_undeleted($this->bean->id);}
			$this->bean->deleted = 0;
			$this->bean->is_latest = 1;
			$this->bean->idsofadditions = ''; //2.0RC2 remove additions since this is new version of Contract 
			$old_id = $this->bean->previousrevision;
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
			//Add related Quote to subpanel
			if ($this->bean->object_name == 'oqc_Contract') { 
			$quote = 'oqc_offering';
			$this->bean->load_relationship($quote);
			$this->bean->$quote->add($this->bean->offeringid);					
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

		parent::action_save();

		// redirect to new version
		$this->return_id = $this->bean->id;
		$this->return_module = $this->module;

		// save a reference to this newly created bean in the nextRevision field of the old bean
		if ($old_id != null) {
			$oldBean = new $this->bean->object_name();
			if ($oldBean->retrieve($old_id)) {
				$oldBean->addNextRevisionId($this->bean->id);
				$oldBean->save();
				// hide previous version
				$this->bean->oqc_mark_deleted($old_id); 
			}
		}
	}

  
	function action_CreatePdf() {
		createPdf($this->bean);
	}
	
}

?>
