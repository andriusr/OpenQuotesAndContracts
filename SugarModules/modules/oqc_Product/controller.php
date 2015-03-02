<?php
require_once('include/utils.php');
require_once('include/oqc/common/common.php');
require_once('include/MVC/Controller/SugarController.php');
require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/oqc_Category/oqc_Category.php');
require_once('modules/Documents/Document.php');
require_once('modules/oqc_Product/oqc_ImageResize.php'); //1.7.6 
require_once('modules/DocumentRevisions/DocumentRevision.php');

class oqc_ProductController extends SugarController {
	function begin_new_version() {
		$old_id = '';
		
		//2.1 first we need to get latest version 
		if (!isset($_POST['record']) || empty($_POST['record'])) {
			$this->bean->version = 1;
			if (!isset($_POST['catalog_position'])) {
				$this->catalog_position = 1000; //Set large number, so it is last in the list		
			}
		}
		elseif ($this->bean->is_latest == 1) {
			$this->bean->version += 1;
			$old_id = $this->bean->id;
			
		}
		else {
		$latestRevision = $this->bean->getLatestRevision();
		$this->bean->version = $latestRevision->version + 1;
	//	$GLOBALS['log']->error("Version number increaed by one ". var_export($this->bean->version, true));
		$old_id = $latestRevision->id;
		}
		
		
		$this->bean->previousrevision = $old_id;

		// unset old baggage, which will automatically be created on parent::action_save
		unset($this->bean->id);
		unset($this->bean->{$this->bean->table_name . '_number'});
		
		
	
		// ensure that this bean is fresh even when editing an old deleted version.
		$this->bean->deleted = 0;
		$this->bean->nextrevisions = '';
		$this->bean->is_latest = 1;
		
		return $old_id;
	}

	// should only be called after parent::action_save, because $this->bean->id is needed
	function end_new_version($old_id) {
		// hide previous head revision.
		
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
			
		// redirect to new version
		if ($this->return_module != 'oqc_ProductCatalog') {
		$this->return_id = $this->bean->id;
		$this->return_module = $this->module;
		}
	}
	
	function save_packaged_products() {
		require_once('include/utils.php');
		$json = getJSONobj();
		$services = $json->decode(from_html($_POST['uniqueJsonString']));

		$packaged_product_ids = "";
		foreach ($services as $service) {
			$id = '';
			$count = '';
			$isUnique = '';
			if (array_key_exists('ProductId', $service['_oData'])) {
			$id = $service['_oData']['ProductId'];}
			if (array_key_exists('Quantity', $service['_oData'])) {
			$count = $service['_oData']['Quantity'];}
			if (array_key_exists('IsUnique', $service['_oData'])) {
			$isUnique = $service['_oData']['IsUnique'] ? "1" : "0";}
				
			// do some validity checking to prevent that invalid lines (like the sum line) are saved in the database
			if (!empty($id) && !empty($count)) {
				// syntax: ID:COUNT:UNIQUE where UNIQUE is "1" for true or "0" for false
				$packaged_product_ids .= $count . ':' . $id . ':' . $isUnique . ' ';

				// TODO do auditing
				/*					$oldService = new oqc_Service();
				$oldServiceText = ($oldService->retrieve($s['Id'])) ? ($oldService->as_plain_text()) : ('<n/a>');

				if ($oldServiceText != $newService->as_plain_text()) {
				$changes = array('field_name' => $name, 'data_type' => 'varchar', 'before' => $oldServiceText, 'after' => $newService->as_plain_text());
				$this->bean->db->save_audit_records($this->bean, $changes);
				}
				*/
			}
		}
			
		$this->bean->packaged_product_ids = trim($packaged_product_ids);
	}
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
	
	private function saveProductOptions() {
		
		$sequence = array();
		if (!isset($_POST["row_status"])) {
			return;
			}
		for ($i = 0; $i < count($_POST["row_status"]); $i++) {
			if ($_POST["row_status"][$i] == 'delete') {
				continue;
			} else {
				$sequence[] = $_POST['option_ids'][$i];
			}
		}
		$this->bean->optionssequence = implode(' ', $sequence);
	}
	
	//2.2RC1 We need to update optionsequences and packaged_products_ids with new id. This would be global product search. It is time consuming, but it will allow safely delete old versions of products.
	private function updateRelatedProducts($old_id) {
		$latestProducts = $this->bean->get_full_list('', 'is_latest = 1 and (optionssequence != "" or packaged_product_ids != "")');
		foreach ($latestProducts as $latestProduct) {
			$count1 = 0;
			$count2 = 0;
			$latestProduct->optionssequence = str_replace($old_id, $this->bean->id, $latestProduct->optionssequence, $count1);
			$latestProduct->packaged_product_ids = str_replace($old_id, $this->bean->id, $latestProduct->packaged_product_ids, $count2);
			//$GLOBALS['log']->error("Ids_are: ". $latestProduct->packaged_product_ids );
			//$GLOBALS['log']->error("Optionsequences are: ". $latestProduct->optionssequence );
			if (($count1+$count2) != 0) {
				$latestProduct->save();
				}
			
			}
		
	}
	
	

	function action_save() {
		$isDuplicate = empty($_REQUEST['record']) && empty($_REQUEST['return_id']);
		// check if there are any modifications
		$modified = hasBeenModified($this->bean, array());

		if (!$isDuplicate && !$modified) {
			return; // skip save if this is not a duplicate and nothing been modified
		}
		//2.0 We determine to what catalog category belongs
		if (!empty($this->bean->relatedcategory_id)) {
			$category = new oqc_Category();
			if ($category->retrieve($this->bean->relatedcategory_id)) {
				$this->bean->catalog_id = $category->catalog_id;
				}
		}
		


		// save id of user that created the old version
		global $timedate;
		$dateCreated = $timedate->to_db($this->bean->date_entered);
		$createdById = $this->bean->created_by;

		$old_id = $this->begin_new_version();
		
		parent::action_save();
		
		$this->end_new_version($old_id);

		$this->initializeUniqueIdentifier();
		$this->save_packaged_products();
		$this->saveAttachedDocuments();
		$this->saveProductOptions();
		$this->saveImageWithResize();
		$this->updateRelatedProducts($old_id);
		//$GLOBALS['log']->error("Dates are: ". $this->bean->date_entered );
		// the new contract should have the same creator and creation date as the previous version, fix for #486
		if ($dateCreated) { $this->bean->date_entered = $dateCreated; }
		if ($createdById) { $this->bean->created_by = $createdById; } 

		if (!isset($_POST['assigned_user_id'])) {
		$this->bean->assigned_user_id = $this->bean->created_by;} //2.1 set this only if it is not in $_POST

		parent::action_save();
	}
	//Deprecated; no longer used
	private function saveImage() {
		if ("1" == $_REQUEST['image_deleted']) {
			// setting all image fields empty to indicate the product has no image anymore
			// the previous version of the product will still reference the image
			$this->bean->image_mime_type = $this->bean->image_filename = $this->bean->image_unique_filename = ''; // setting to empty string instead of setting to null. because setting to null does not set the db entry to null.
		} else {
			// this assumes that edit view form has enctype="multipart/form-data" set
			$file = $_FILES['select_image_filename'];

			if (empty($file['name']) && empty($file['type']) && empty($file['tmp_name'])) {
				// don't do anything. we assume the old product image is still valid and keep everything as is.
				$GLOBALS['log']->debug("oqc_ProductController::saveImage() name, type, tmp_name of image are empty. Will not upload any file.");
			} else if ($file['error'] != 0) {
				// TODO handle different error codes
				// TODO what do they mean??
				$GLOBALS['log']->warn("oqc_ProductController::saveImage() Could not upload any files because error ${file['error']} is reported.");
			} else {
				// note: perhaps there was previous image for this product and the user uploaded a new one.
				// we must not delete the old picture because a new version of the product will automatically created.
				// the older version of the product still displays the previous image.
	
				require_once('include/oqc/common/Configuration.php');
				$conf = Configuration::getInstance();
					
				if ($file['size'] > $conf->get('maximumUploadFileSize')) {
					$GLOBALS['log']->warn("oqc_ProductController::saveImage() Image size (".$file['size'].") exceeds maximumUploadFileSize (".$conf->get('maximumUploadFileSize')."). Please check configuration.");
				} else {
					// TODO how browser/server (?) finds out mime type (can we trust it?)
					if (!$this->bean->isMimeTypeAllowed($file['type'])) {
						$GLOBALS['log']->warn("oqc_ProductController::saveImage() Image has a invalid mime type " . $file['type']);
					} else {
						$this->bean->image_mime_type = $file['type'];
						$this->bean->image_filename = basename($file['name']);
	
						$id = str_replace('.', '', uniqid('i', true)); // we have to remove the dots from the generated id because latex can only determine the filetype properly if the only dot in the filename is in front of the file extension.
						$fileExtension = substr($this->bean->image_filename, strrpos($this->bean->image_filename, '.') + 1);
						$this->bean->image_unique_filename = $id . "." . $fileExtension; // we have to add the original file extension to make sure latex can later determine the filetype when generating the pdf.
							
						$from = $file['tmp_name'];
						$to = $conf->get('fileUploadDir') . $this->bean->image_unique_filename;
							
						if (!move_uploaded_file($from, $to)) {
							$GLOBALS['log']->warn("oqc_ProductController::saveImage() could not move file from $from to $to. Please check configuration file and permissions");
						}
					}
				}
			}
		}
	}
//1.7.6 Images are saved with determined image size to avoid crippled layouts and reduce disk space
// Bug - new image after delete is not saved

   private function saveImageWithResize() {
   	
   	if (isset($_REQUEST['image_deleted'])){
		if ("1" == $_REQUEST['image_deleted']) {
			// setting all image fields empty to indicate the product has no image anymore
			// the previous version of the product will still reference the image
			$this->bean->image_mime_type = $this->bean->image_filename = $this->bean->image_unique_filename = ''; // setting to empty string instead of setting to null. because setting to null does not set the db entry to null.
			}
		}	// this assumes that edit view form has enctype="multipart/form-data" set
			$file = $_FILES['select_image_filename'];

			if (empty($file['name']) && empty($file['type']) && empty($file['tmp_name'])) {
				// don't do anything. we assume the old product image is still valid and keep everything as is.
				$GLOBALS['log']->warn("oqc_ProductController::saveImage() name, type, tmp_name of image are empty. Will not upload any file.");
				return;
			} else if ($file['error'] != 0) {
				// TODO handle different error codes
				// TODO what do they mean??
				$GLOBALS['log']->warn("oqc_ProductController::saveImage() Could not upload any files because error ${file['error']} is reported.");
				return;
			} else {
				// note: perhaps there was previous image for this product and the user uploaded a new one.
				// we must not delete the old picture because a new version of the product will automatically created.
				// the older version of the product still displays the previous image.
				// 2.1 Use standard config.php settings for upload dir and max file size. It fileUploadDir key exist in document.properties, then use values from openqc configuration file. By default openqc values are disabled.
				global $sugar_config; 
								
				require_once('include/oqc/common/Configuration.php');
				$conf = Configuration::getInstance();
				$oqc_uploadDir = $conf->get('fileUploadDir');
				$oqc_maxFileSize = $conf->get('maximumUploadFileSize');
				$uploadDir = $oqc_uploadDir ? $oqc_uploadDir : $sugar_config['upload_dir'];
				$maxFileSize = $oqc_maxFileSize ? $oqc_maxFileSize : $sugar_config['upload_maxsize'];
					
					
				if ($file['size'] > $maxFileSize) {
					$GLOBALS['log']->warn("oqc_ProductController::saveImage() Image size (".$file['size'].") exceeds maximumUploadFileSize (".$maxFileSize."). Please check configuration.");
				} else {
					// TODO how browser/server (?) finds out mime type (can we trust it?)
					if (!$this->bean->isMimeTypeAllowed($file['type'])) {
						$GLOBALS['log']->warn("oqc_ProductController::saveImage() Image has a invalid mime type " . $file['type']);
					} else {
						$this->bean->image_mime_type = $file['type'];
						$this->bean->image_filename = basename($file['name']);
	
						$id = str_replace('.', '', uniqid('i', true)); // we have to remove the dots from the generated id because latex can only determine the filetype properly if the only dot in the filename is in front of the file extension.
						$fileExtension = substr($this->bean->image_filename, strrpos($this->bean->image_filename, '.') + 1);
						$this->bean->image_unique_filename = $id . "." . $fileExtension; // we have to add the original file extension to make sure latex can later determine the filetype when generating the pdf.
							
						$from = $file['tmp_name'];
						$to = $uploadDir . $this->bean->image_unique_filename;
						$thumbname = $uploadDir .'th'. $this->bean->image_unique_filename;
						
						if (!move_uploaded_file($from, $to)) {
							$GLOBALS['log']->warn("oqc_ProductController::saveImage() could not move file from $from to $to. Please check configuration file and permissions");
							return;
						}
						else if (! resizeImage($to, $thumbname, 700 )) { 
							$GLOBALS['log']->debug("oqc_ProductController::saveImage() image could not be resized");
						}
					}
				}
			}
	}

	private function initializeUniqueIdentifier() {
		if ($this->bean->version == 1) {
			// with every change we create a new version of the product. we increase its version number. still we want to have one id that stays the same on all versions of the product.
			// this is the unique_identifier field stays the same in all product versions. when we create the first version of a product we search for a new unique_identifier and set it.
			// we never have to update this field in the next versions of the product since we want that it stays the same in all versions. the fields version and oqc_product_number are
			// increased normally.
			 
			// determine the maximum unique_identifier value
			$result = $this->bean->db->fetchByAssoc($this->bean->db->query("SELECT MAX(unique_identifier) FROM oqc_product;"));
			$max_unique_identifier = $result["MAX(unique_identifier)"];
	
			// set the unique_identifier one above the current maximum. it will stay the same in all newer versions of this product.
			$this->bean->unique_identifier = $max_unique_identifier + 1;
		}
	}
	
	//2.2RC1 We need special logic to mark products deleted. 
	function action_delete() {
		
		if(!empty($_REQUEST['record'])){
		
			if(!$this->bean->ACLAccess('Delete')){
				ACLController::displayNoAccess(true);
				sugar_cleanup(true);
			}
				
			$this->bean->mark_deleted($_REQUEST['record']);
		}else{
			sugar_die("A record number must be specified to delete");
		}
	}

}

?>
