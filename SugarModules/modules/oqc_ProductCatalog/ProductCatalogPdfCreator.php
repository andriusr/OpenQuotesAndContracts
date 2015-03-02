<?php
require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('modules/oqc_Category/oqc_Category.php');
require_once('modules/Documents/Document.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');
require_once('include/formbase.php');
require_once('include/Sugar_Smarty.php');
require_once('include/oqc/Services/Services.php');
require_once('modules/oqc_Contract/oqc_HtmlToLatexConverter.php');
require_once('include/oqc/Pdf/Common.php');
require_once('include/oqc/common/common.php');
require_once('modules/oqc_Contract/oqc_CreatePdf.php');
require_once('modules/Currencies/Currency.php');


class ProductCatalogPdfCreator {
//1.7.5 - fixed product catalog name, filename generation and versioning
	public function createPdf($productCatalog) {
		global $timedate;
      global $app_list_strings;
      global $current_user;
      global $sugar_config;
      $catalog_done = true;
      $create_new_document = true;
		$document = new Document();
		if (! $document->retrieve($productCatalog->document_id)) { 
			//$create_new_document = true;
			if (!empty($productCatalog->pdf_document_name)) {
				$document_name =  $productCatalog->pdf_document_name; 
			}	else {
				$document_name =  $app_list_strings['oqc']['pdf']['common']['filenamePrefixCatalog'] . "_" . date("Y");// Configure default Catalog document name here
			} 
		} else {
			// Search is there exist catalog with the same name
			$productCatalog->load_relationship('documents');
			$linkedDocuments = $productCatalog->documents->get();	
			//$GLOBALS['log']->error('OQCProductCatalog: Linked documents: '. var_export($linkedDocuments, true));
			if (empty($productCatalog->pdf_document_name)) {
				$document_name =  $app_list_strings['oqc']['pdf']['common']['filenamePrefixCatalog'] . "_" . date("Y");
			} else { 
				$document_name = $productCatalog->pdf_document_name;
			}
			foreach ($linkedDocuments as $id) {
				if ($document->retrieve($id)) {
					if ($document->document_name == $document_name) {
						$create_new_document = false;
						break;
					}
				}
			}
		}
		if ($create_new_document)	 {
			unset($document);	
			$document = new Document();
			$document->document_name = $document_name;
			$document->category_id = "ProductCatalog";
			$document->subcategory_id = "Pdf";
			$document->status_id = "Active";
		   $document->document_purpose_c = "Internal";
			$document->active_date = date($timedate->get_date_format());
			$document->assigned_user_id = $current_user->id;
// create an id for this new document
			$document->save();
			$document->new_with_id = false;
		}
		$catalog_done = $this->createNewRevision($productCatalog, $document);
		if ($catalog_done) {
			$productCatalog->load_relationship('documents');
			$productCatalog->documents->add($document->id);
			$productCatalog->document_id = $document->id;
			$productCatalog->save();
			$document->save();
			header("Location: index.php?action=DetailView&module=DocumentRevisions&record={$document->document_revision_id}");
			exit;
		} else {
			if (!$productCatalog->document_id)	{
				$document->mark_deleted($document->id); //This was new document, so delete it if pdf creation fails
			}
			echo "<html>
			Pdf creation failed. Set debugPdfCreation=1 in config file and re-run creation of pdf file to get error log. </br>
			<a href=\"{$sugar_config['site_url']}/index.php?action=DetailView&module=oqc_ProductCatalog&record={$productCatalog->id}\">Return to previuos page</a>
			</html>";
			exit;
		}
	}			

	private function createNewRevision($productCatalog, &$document) {
		global $timedate;
      global $app_list_strings;
		$productCatalogFilename = $this->categoryPagesToPdf($productCatalog);
		if(! $productCatalogFilename) {
			$GLOBALS['log']->fatal('OQC: Failed to create new catalog revision');
			return false; }
		$revision = new DocumentRevision();
		if (! $revision->retrieve($document->document_revision_id)) {
			$revision->document_id = $document->id;
			$revision->revision = 0;
		}
		$revision->revision = $revision->revision + 1;
		if (DEBUG_PDF_CREATION) {
			$revision->file_mime_type = 'text/plain';
			$revision->file_ext = 'log';
			$revision->filename =$app_list_strings['oqc']['pdf']['common']['filenamePrefixCatalog'] . "_" . date("Ymd") . "_{$revision->revision}.log";
		} else {
			$revision->file_mime_type = 'application/pdf';
			$revision->file_ext = 'pdf';
			$revision->filename = $app_list_strings['oqc']['pdf']['common']['filenamePrefixCatalog'] . "_" . date("Ymd") . "_{$revision->revision}.pdf";
		}
		
      // set fields to null in order to correctly generate new values 
      $revision->date_entered = '';
      $revision->date_modified = '';
		//$revision->filename = $app_list_strings['oqc']['pdf']['common']['filenamePrefixCatalog'] . "_" . date("Ymd") . "_{$revision->revision}.pdf";
		$revision->id = '';
		$revision->save();

		
		rename($productCatalogFilename, getDocumentFilename($revision->id));

		$document->document_revision_id = $revision->id;
		
		return true;
	}


	private function categoryPagesToPdf($productCatalog) {
		if ($productCatalog->oqc_template == null) {
		$beanName = substr(trim($productCatalog->object_name),4);
		$templatePaths = getTemplatesPath($beanName);
		} else {
		$templatePaths = getTemplatesPath($productCatalog->oqc_template);}
		
		$filename = templateToPdf($templatePaths['PRODUCT_CATALOG_TEMPLATE'], $this->getProductCatalogVariables($productCatalog), 3);
		//TODO cleanup here the temporary pdf files generated from product attachments 
		if(! $filename) return null;
		return $filename;
	}

	function beansToArrayWithAttachements($beans) {
		// avoids php warning
		if (empty($beans)) {
			//$GLOBALS['log']->error('OQC: Product bean is:empty');
			return array();
		}
				

		$array = array();

		foreach ($beans as $bean) {
			$options = array();
			if (!empty($bean->optionssequence)) {
				$options = $bean->get_all_linked_product_options_for_catalog($bean->optionssequence);
			}
			
			$attachementPdfName = createAttachedDocumentsPdf($bean);
			
			
			$beanArray = $bean->toArray(true);
			//$GLOBALS['log']->error('OQC: Product bean is:'. var_export($beanArray,true) );
			//if ($bean instanceof oqc_Product && $bean->getImageFilenameUrl()) {
				// note that the image url is relative to the sugarcrm root directory.
			$beanArray['image_url'] = $bean->getImageFilenameUrl();
			//}
			//else {
			//	$beanArray['image_url'] = null;}
			
			//$beanArray['shortdescription'] = htmlToLatex(from_html($beanArray['shortdescription']));
			
			$beanArray['description'] = htmlToLatex(from_html($beanArray['description']));
			$beanArray['name'] = stringToLatex(from_html($beanArray['name']));
			$beanArray['price_text'] = stringToLatex(trim($beanArray['price_text']));
			$beanArray['pdfAttachement'] = $attachementPdfName;
			$beanArray['options'] = $this->beansToArrayWithAttachements($options);
			
			global $app_list_strings;
			if($beanArray['unit'] != '') {
			$beanArray['unit'] = $app_list_strings['unit_list'][$beanArray['unit']];}

			$array[] = $beanArray;
		}

		return $array;
	}
		
// 1.7.5 - modified to use function with attachements creation.

	function insertProducts(&$categories) {
		foreach ($categories as &$category) {
			$bean = new oqc_Product();
		//	$products = $bean->get_full_list("", "relatedcategory_id='{$category['id']}' and publish_state = 'published' and oqc_product.active=1 and is_latest=1 and is_option=0"); //1.7.6-2.0 extra conditions active and is_latest since produst are not deleted
			$products = $bean->get_full_list("", "relatedcategory_id='{$category['id']}' and publish_state = 'published' and oqc_product.active=1 and is_latest=1"); //2.1RC1 Options are shown in pdf file
			//2.0 arrange beans according catalog_position field 
			if (!empty($products)) {
			usort($products, array('oqc_Product', 'oqc_product_compare_catalog_position'));
			}			
			$category['products'] = $this->beansToArrayWithAttachements($products);
			$this->insertProducts($category['subCategories']);
		}
	}
// 1.7.5 end of modification

	private function getSmartyCategories($categories) {
		$items = array();

		foreach ($categories as $subCategory) {
			$subCategory['category']->name = replaceSpecialCharactersWithHtml($subCategory['category']->name);
				
			$items[] = array(
				'id' => $subCategory['category']->id,
				'name' => stringToLatex(from_html($subCategory['category']->name)),
				'number' => $subCategory['category']->number,
				'description' => htmlToLatex(from_html($subCategory['category']->description)),
				'subCategories' => $this->getSmartyCategories($subCategory['subcategories']),
			);
		}
		return $items;
	}

	private function getProductCatalogVariables($productCatalog) {
		$rootCategoriesSmarty = $this->getSmartyCategories($productCatalog->getAllCategories());
		$this->insertProducts($rootCategoriesSmarty);

		$description = htmlToLatex(from_html($productCatalog->description));
		//1.7.6 TODO create error handling here 
		if ($description == null ) {
		$GLOBALS['log']->error('OQC: Product catalog description is null!');
		//return null;
		} 
		global $timedate;
		$validfrom = $timedate->to_display_date($productCatalog->validfrom);
		$validto = $timedate->to_display_date($productCatalog->validto);
		
		$frontpage = null;
		$attachment = null;
		if ($productCatalog->frontpage_id != null || $productCatalog->attachment_id != null) {
			$doc = new Document();
		if ($doc->retrieve($productCatalog->frontpage_id)) {
			$frontpage = str_replace("\\", '/',TMP_DIR . DIRECTORY_SEPARATOR . $doc->document_revision_id . '.pdf');
			copy(getcwd() . DIRECTORY_SEPARATOR . getDocumentFilename($doc->document_revision_id), $frontpage);
		}
		if ($doc->retrieve($productCatalog->attachment_id)) {
			$attachment = str_replace("\\", '/', TMP_DIR . DIRECTORY_SEPARATOR . $doc->document_revision_id . '.pdf');
			copy(getcwd() . DIRECTORY_SEPARATOR . getDocumentFilename($doc->document_revision_id), $attachment);
		}
		}
		//ProductCatalog currency setup
		$currencyArray = array();
		$currency = new Currency();
		$currency_id = $currency->retrieve_id_by_name($productCatalog->currency_id);
		//$GLOBALS['log']->error('Contract variables: currency: '. var_export($currency_id,true));
		if ($currency_id)	 {
		   $currency->retrieve($currency_id); 
			$currencyArray['currency_id']= $currency->iso4217;
			$currencyArray['currency_symbol'] = $currency->symbol;
			$currencyArray['currency_ratio'] = $currency->conversion_rate;
		}
		else {
		$currencyArray['currency_id']= $currency->getDefaultISO4217();
		$currencyArray['currency_symbol'] = $currency->getDefaultCurrencySymbol();
		$currencyArray['currency_ratio'] = 1.00;
		}
		$currencyArray['currency_symbol'] = str_replace("\xE2\x82\xAC", '\euro{}',$currencyArray['currency_symbol']);
		$currencyArray['currency_symbol'] = str_replace('$', '\$',$currencyArray['currency_symbol']);
		$currencyArray['currency_symbol'] = str_replace("\xC2\xA3", '{\pounds}',$currencyArray['currency_symbol']);
		$currencyArray['currency_symbol'] = str_replace("\xC2\xA5",  '{Y\hspace*{-1.4ex}--}' ,$currencyArray['currency_symbol']);
		
		
		
		$productCatalogVariables= array(
			'name' => $productCatalog->name,
			'validfrom' => $validfrom,
			'validto' => $validto,
			'graphicsDir' => LATEX_GRAPHICS_DIR, 
			'categoriesAndProducts' => $rootCategoriesSmarty, 
			'description' => $description,
			'frontpage' => $frontpage,
			'attachment' => $attachment,
		    'year' => date('Y'),
		    'currency' => $currencyArray,
		    'discount' => 1.00 - $productCatalog->oqc_catalog_discount/100,
		);
		
		//$GLOBALS['log']->error('Product Catalog variables: '. var_export($productCatalogVariables,true));	
		return $productCatalogVariables;
	}

}
?>
