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
require_once('modules/oqc_Product/oqc_Product_sugar.php');
require_once('modules/oqc_ProductCatalog/oqc_ProductCatalog.php');
require_once('modules/Currencies/Currency.php');
require_once('modules/Documents/Document.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');

class oqc_Product extends oqc_Product_sugar {
// 1.7.5 required to include product attachements into catalog
	var $attachementsequence;
	var $new_with_id = false;

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

//2.1 returns attachments with subcategory technical description

	function getTechnicalDescriptions() {
		$attachmentIds = explode(' ', trim($this->attachmentsequence));
		$attachments = array();
	
		foreach ($attachmentIds as $id) {
			$attachment_data = array();
			$revision = new DocumentRevision();
			if (!$revision->retrieve($id)) {
		
				$attachment = new Document();
				if ($attachment->retrieve($id)) {
					if ($attachment->subcategory_id == 'Technical') {
					//$attachment_data = array();
					$attachment_data["id"] = $attachment->id;
					$attachment_data["document_name"] = $attachment->document_name;
					$attachment_data["document_revision_id"] = $attachment->document_revision_id;
	//				$attachment_data["doc_status"] = 'new';
					$attachments[]	= $attachment_data;
				}
				}
			} else {
				$attachment = new Document();
				if ($attachment->retrieve($revision->document_id)) {
					if ($attachment->subcategory_id == 'Technical') {
					//$attachment_data = array();
					$attachment_data["id"] = $attachment->id;
					$attachment_data["document_name"] = $attachment->document_name . '_rev.' . $revision->revision;
					$attachment_data["document_revision_id"] = $revision->id;
	//				$attachment_data["doc_status"] = 'new';
					$attachments[]	= $attachment_data;
				}
				}
			}
			
			
			
		}
	
		return $attachments;
	}


	
	public static function getFieldFromId($fieldName, $id) {
		$product = new oqc_Product();
		
		if ($product->retrieve($id))
			return $product->$fieldName;
		else
			return 0; // TODO handle error
	}

	static function isMimeTypeAllowed($mimeType) {
		$allowedMimeTypes = array(
                    // add all allowed mime-types for images. see http://www.iana.org/assignments/media-types/image/
                    'image/bmp',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/tiff',
                    'image/pjpeg', // M$ invented new image type, required to work with IE8
		);
		
		return FALSE !== array_search($mimeType, $allowedMimeTypes);		
	}
	
	// returns the url to the product image or FALSE if none has been uploaded or if the file does not exist at the specified location
	function getImageFilenameUrl() {
		if (!empty($this->image_unique_filename)) {
						global $sugar_config;
                  require_once('include/oqc/common/Configuration.php');
                  $conf = Configuration::getInstance();
		 				$oqc_uploadDir = $conf->get('fileUploadDir');
		 				$uploadDir = $oqc_uploadDir ? $oqc_uploadDir : $sugar_config['upload_dir'];
		 				
                    $url = $uploadDir. $this->image_unique_filename;
                    if (strtoupper(substr(php_uname('s'), 0, 3)) === 'WIN') {
                    $url_win = str_replace("\\", "/", getcwd() .'/'.$url);	
                    if (file_exists($url_win)) {
                        return $url;
                    }
                    }
                  
						  //$GLOBALS['log']->error('OQC: Product image url is:'. $url );
                    if (file_exists($url)) {
                        return $url;
                    }  
		}
		
		return null;
	} 

	// return the product beans contained in this packet as bean arrays.	
	function getPackagedProductBeans() {
		$products = array();

		if ($this->isPacket()) {
			$packaged_product_counts_and_ids = explode(' ', $this->packaged_product_ids);

			foreach ($packaged_product_counts_and_ids as $packaged_product_count_and_id) {
	                	list($packaged_product_count, $packaged_product_id) = explode(':', $packaged_product_count_and_id);

		                	// instead of calling retrieve we directly access the database with db->query because retrieve will call fill_in_additional_list_fields which will format the prices of the products.
		                	// this would overwrite the price value "24.00" with a localized string "<currencySymbol>24,00" like "€24,00".
	                        // TODO add sql injection protection!
	                        // TODO add interesting fields if neccessary.
	                        $packaged_product_array = $this->db->fetchByAssoc($this->db->query("select id,name,price,price_recurring from oqc_product where id='$packaged_product_id';"));
	                        
	                        if (!empty($packaged_product_array)) {
								// additionally we "inject" the count value into the product bean. because we have to know this value lateron (in getPacketPrice for example)
								if (array_key_exists('__count_in_package', $packaged_product_array)) {
									$GLOBALS['log']->fatal('oqc_product::getPackagedProductBeans(): cannot add key __count_in_package because it already exists');
								} else {
									$packaged_product_array['__count_in_package'] = $packaged_product_count;
								}
								$products[] = $packaged_product_array;	                        	
	                        }   
				}
			}
		

		return $products;
	}

	// returns the packet price for this product which is the sum of the prices (field name should be 'price' or 'price_recurring')
	// of its packaged products.
	// Deprecated, no longer in use 
	function getPacketPrice($priceFieldName='price', $ignoreTaxes = true) {
		$sum = 0;
		
		if ($this->isPacket()) {
			$products = $this->getPackagedProductBeans();
			
			// TODO only do this if $ignoreTaxes == false
			require_once('include/oqc/common/Configuration.php');
			$conf = Configuration::getInstance();
			$vat = 1.0 + $conf->get('vat');
	
			foreach ($products as $product) {
				if ($ignoreTaxes || "0" == $product['vat']) {
					$sum += $product[$priceFieldName] * $product['__count_in_package'];
				} else {
					$sum += $vat * $product[$priceFieldName] * $product['__count_in_package'];	
				}
			}
		}

		return $sum;
	}
	
        // a product is called a packet if it contains at least one other product.
        // links to products are stored in the packaged_product_ids field.
        // -> a product is called a packet if this field is not empty.
        function isPacket() {
        	if (isset($this->packaged_product_ids)) {
            $trimmed = trim($this->packaged_product_ids);
            return !empty($trimmed);
            }
            else {return false;}
        }

        function containsProductWithId($productId) {
            // the field packaged_product_ids could look like the following "1:id1 2:id2 3:id3"
            // it contains a space separated list of (quantity),(product id) pairs
            // the package contains the given id if the id is part of the string packaged_product_ids
            if (!$this->isPacket()) {
                // if this is no packet it will not contain any products
                return false;
            } else {
                // this product contains the product with the given id
                // is has be found in the packaged_product_ids field.
                return FALSE !== strstr($this->packaged_product_ids, $productId);
            }
        }

	function oqc_Product(){	
		parent::oqc_Product_sugar();
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
		
		
		if (isset($_REQUEST['action'])) {
                if ('DetailView' === $_REQUEST['action']) {
					 	$this->unique_identifier = sprintf("%08d", $this->unique_identifier);
					}
		}
   //   $this->fill_in_additional_list_fields();
	}
	function fill_in_additional_list_fields() {
		parent::fill_in_additional_list_fields();
		
		// fillin the category number field if possible
		if (!empty($this->relatedcategory_id)) {
			$category = new oqc_Category();
			if ($category->retrieve($this->relatedcategory_id)) {
				$this->category_number = $category->number;
			}
		}
		
		$catalog = new oqc_ProductCatalog;
		if ($catalog->retrieve($this->catalog_id)) {
			$this->catalog_name = $catalog->name;
		}
		
		if(isset($this->currency_id) && $this->currency_id !='') {
		    $currency = new Currency();
		    $currency->retrieve($this->currency_id);
    		if($currency->id != $this->currency_id || $currency->deleted == 1){
    	//			$this->amount = $this->amount_usdollar;
    				$this->currency_id = $currency->id;
    		}
		} else {$this->currency_id = '-99';}
		
		 if ( $this->force_load_details == true)
                {
                        $this->fill_in_additional_detail_fields();
                }
	
	}
	
	function save($check_notify = false, $save_old_bean = false) {
		global $timedate;

		if ($save_old_bean) {
			global $locale;
			$defaultDecSep = $locale->getPrecedentPreference("default_decimal_seperator");
			$this->price = str_replace('.', $defaultDecSep, $this->price);
		}
		
		// Bug 32581 - Make sure the currency_id is set to something
        global $current_user, $app_list_strings;

      if ( empty($this->currency_id) )
            $this->currency_id = -99;
		
		
		$this->fixDatetimes();
		parent::save($check_notify);
		
	}
	
	//2.1 avoid annoying depracated warnings and date conversion errors in sugarlog
	function fixDatetimes() {
		global $timedate;
		$date_array = array(
		array('datetime', 'date_modified'),
		array('datetime', 'date_entered'),
	//	array('date', 'startdate'),
	//	array('date', 'enddate'),
	//	array('date', 'signedon'),
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
	
	
	
	/* CSV Export */
	var $basic_field_names = array('', 'name', 'description', 'relatedcategory', 'price', 'price_text', 'unit', 'zeitbezug', 'active', 'external', 'published', 'monthsguaranteed', 'cancellationperiod', 'personincharge', 'assigned_employee', 'version');
	
	function get_exportable_fields_header($beans) {
		global $sugar_config;
		$lang = $sugar_config['default_language'];
        $mod_strings = return_module_language($lang, $this->module_dir);

        $basic_field_names = array();
		foreach ($this->basic_field_names as $field_name) {
			$basic_field_names[] = $mod_strings['LBL_' . strtoupper($field_name)];
		}
		
		return array($basic_field_names);
	}

	function get_exportable_fields($start_year) {
		$line = array();

		global $timedate;
		global $sugar_config;
		$lang = $sugar_config['default_language'];
		$app_list_strings = return_app_list_strings_language($lang);
				
		foreach ($this->basic_field_names as $field_name) {
			if (empty($field_name)) {
				$line[] = '';
			}
			// resolve relate fields
			else if (isset($this->field_name_map[$field_name]['type']) && $this->field_name_map[$field_name]['type'] == 'relate') {
				global $beanList;
				global $beanFiles;
				
				$type = $beanList[$this->field_name_map[$field_name]['module']];
				require_once($beanFiles[$type]);
				$bean = new $type;
				
				$id = $this->{$this->field_name_map[$field_name]['id_name']};
				if ($bean->retrieve($id)) {
					// Just use name for now; using rname of field would be more correct
					$line[] = $bean->name;
				}
				else {
					$line[] = '';
				}
			}
			else if ($field_name == 'unit' || $field_name == 'zeitbezug') {
				$line[] = $app_list_strings[$field_name . '_list'][$this->$field_name];
			}				
			else {
				$value = parent::decode_exportable_field($field_name);
				
				// fix for #548
				if (strpos($value, "\r\n")) {
					$line[] = str_replace("\r\n", ' ', $value);
				} else if (strpos($value, "\n")) {
					$line[] = str_replace("\n", ' ', $value);
				} else {
					$line[] = $value;
				}
			}
		}

		return array($line);
	}
	
	/* Versioning Stuff */

	// retrieve specified record even if deleted by default
	function retrieve($id = -1, $encode = true, $deleted = false) {
		return parent::retrieve($id, $encode, $deleted);
	}
	
        function addNextRevisionId($id) {
                if (empty($this->nextrevisions)) {
                        $this->nextrevisions = $id;}
      //          else
      //                  $this->nextrevisions .= ' ' . $id;
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
        //2.0 function for getting latest revision
        //Returns latest revision bean
        function getLatestRevision() {
                $latestProduct = new $this->object_name();
                $nextProduct = new $this->object_name();
                $nextProduct->nextrevisions = $this->getLatestNextRevisionId();
					//  $nextProduct->id = $this->id;
                while ($latestProduct->retrieve($nextProduct->nextrevisions)) {
                        $nextProduct = $latestProduct;
                }

                return $nextProduct;
        }
        //Returns latest revision id
        function getLatestRevisionFromId($id) {
        				
                $latestProduct = new oqc_Product();
                $nextProduct = new oqc_Product();
                $nextProduct->nextrevisions = $id;
					 $nextProduct->id = $id;
                while ($latestProduct->retrieve($nextProduct->nextrevisions)) {
                        $nextProduct = $latestProduct;
                }

                return $nextProduct->id;
        }
        //end 2.0 methods

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
   //2.0 extra functions     
   static function oqc_product_compare_catalog_position($a, $b) { 
	return strnatcmp($a->catalog_position, $b->catalog_position); 
	} 
	
	// returns ProductOptions beans array from $optionssequence 
	
	function get_all_linked_product_options($optionssequence) {
	$optionsIds = explode(' ', trim($optionssequence));
	$options = array();

	foreach ($optionsIds as $id) {
		$option = new oqc_Product();

		if ($option->retrieve($id)) {
		  
			if (($option->is_latest == 1) || ($this->is_latest == 0)) {
			$options[] = $option;
			} else {
			$option = $option->getLatestRevision();
			$options[] = $option;	
			}
		}
	}

	return $options;
	}    
   //2.0 End
   //2.1 For catalog we have to select only active and published options; Product is latest already 
   
   function get_all_linked_product_options_for_catalog($optionssequence) {
	$optionsIds = explode(' ', trim($optionssequence));
	$options = array();

	foreach ($optionsIds as $id) {
		$option = new oqc_Product();

		if ($option->retrieve($id)) {
			if ($option->is_latest == 1) {
				if (($option->active == 1) && ($option->publish_state == 'published')) {
				$options[] = $option;
				} 
			} else {
				$option = $option->getLatestRevision();
					if (($option->active == 1) && ($option->publish_state == 'published')) {
					$options[] = $option;	
					}
				}	
		}
	 }


	return $options;
	}     
    
        
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

        // find out the previous revisions of this product and return an array containing their ids.
        function  getAllPreviousVersions() {
            $ids = array();

            $previousRevisions = $this->getAllPreviousRevisions();
            foreach ($previousRevisions as $previousRevision) {
                $ids[] = $previousRevision->id;
            }

            return $ids;
        }
//2.2RC1 We want to delete relationships when calling $this->mark_deleted...
 /*       function mark_relationships_deleted($id) {
                // This function is called from $this->mark_deleted.
                // But we do NOT want to delete any relationships
                // as these are still needed.

                // Relationships can be deleted with $this->delete_linked
        } */
        
        //1.7.7 limit the number of beans returned since for >20 there is PHP warning for exceeded number of queries
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
	
	//2.2RC1 override bean function since we need to patch nextrevisions and previousrevisions fields 
	function mark_deleted($id) {

		//If it is latest version, we need to remove it also from optionssequence and packaged_product_ids of related products;
		//mark_deleted also earlier versions of product(this will produce warnings in legacy systems)
		if ($this->is_latest) {
			$previousVersions = $this->getAllPreviousRevisions();
			$prevIds = array();
			foreach ($previousVersions as $version) {
				$prevIds[] = $version->id;
			//	$version->update_date_modified = false;
				$version->mark_deleted($version->id);
				}
			$prevIds = array_merge(array($id), $prevIds);
			$relatedProducts = $this->get_full_list('', 'is_latest = 1 and (optionssequence != "" or packaged_product_ids != "")'); //Select only products that have options or are packaged
			foreach ($relatedProducts as $relatedProduct) {
				$matchCount = 0;
				$matchPacket = 0;
				$matchedOptionsString = str_replace($prevIds, '', $relatedProduct->optionssequence, $matchCount);
				$matchedPacketsString = str_replace($prevIds, '', $relatedProduct->packaged_product_ids, $matchPacket);	
				if (($matchCount+$matchPacket) != 0) {
					$relatedProduct->optionssequence = str_replace('  ', ' ', trim($matchedOptionsString));
					$relatedProduct->packaged_product_ids = preg_replace('/\d{1,2}::\d{1}/', '', $matchedPacketsString);	
				//	$GLOBALS['log']->error("Deleted Ids_are: ". $relatedProduct->packaged_product_ids );	
					$relatedProduct->packaged_product_ids = str_replace('  ', ' ', trim($relatedProduct->packaged_product_ids));
					$relatedProduct->save();
				}
				
			}
		
			$this->is_latest = false; //Sets is_latest fields as for deleted record
			$this->save();
		} else { //If it is not latest, just make do fix for history panel correct timeline; it will be not accesible in any other way, too
			
			/*if (!empty($this->previousrevision)) {
				$previousVersion = new oqc_Product();
				if ($previousVersion->retrieve($this->previousrevision)) {
					$previousVersion->nextrevisions = $this->nextrevisions;
					$previousVersion->update_date_modified = false; //Do not change date_modified field, since we do not modify it
					$previousVersion->save();
				}
			}
			if (!empty($this->nextrevisions)) {
				$nextVersion = new oqc_Product();
				if ($nextVersion->retrieve($this->nextrevisions)) {
					$nextVersion->previousrevision = $this->previousrevision;
					$nextVersion->update_date_modified = false; //Do not change date_modified field, since we do not modify it
					$nextVersion->save();
				}
			} */
			
		}
			
		parent::mark_deleted($id);	

	}
	
	
	
	
	function get_summary_text() {
		return $this->name;
		}
	
}
?>
