<?php

require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('modules/Documents/Document.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');
require_once('include/formbase.php');
require_once('include/Sugar_Smarty.php');
//require_once('include/oqc/Services/Services.php');
require_once('include/oqc/Pdf/Common.php');
require_once('include/oqc/common/Configuration.php');
require_once('modules/Currencies/Currency.php');
require_once('modules/oqc_Contract/oqc_HtmlToLatexConverter.php');
require_once('include/oqc/Services/CalendarMath.php');
require_once('modules/EmailAddresses/EmailAddress.php');

class DocumentHandler {
	private $CONVERTER;
	private $PAGE_INSERTER;
	
	private $openOfficeProc;
	
	public function __construct() {
		require_once('include/oqc/common/Configuration.php');
		$conf = Configuration::getInstance();
		
		$this->CONVERTER = $conf->get('pathDocumentConverter');
		$this->PAGE_INSERTER = $conf->get('pathPageInserter');

	}

	public function convertToPdf($filename) {
		$pdfFilename = TMP_DIR . '/' . basename($filename) . '.pdf';

		execute($this->CONVERTER, $filename . ' ' . $pdfFilename);
	
		if (! file_exists($pdfFilename)) {
			$GLOBALS['log']->error('Problem with OpenOffice or DocumentConverter, convertToPdf error');
			return null;
			}
	
		return $pdfFilename;
	}
	
	public function withBlankPages($filename, $pageCount) {
		$newFilename = tempnam(TMP_DIR, 'blank');
		
		if (execute($this->PAGE_INSERTER, "$filename $newFilename $pageCount") != 0) {
			unlink($newFilename);
			$GLOBALS['log']->error('OQC: Problem with PageInserter, withBlankPages error');
//			trigger_error("Problem with OpenOffice or DocumentModifier", E_USER_NOTICE);
			return null;
			}
		return $newFilename;
	}
}
//********* End class DocumentHandler

function oqc_replaceVariables($input, $variables) {
	
	$smarty = new Sugar_Smarty;
	$smarty->left_delimiter = '{{';
	$smarty->right_delimiter = '}}';
	$smarty->register_resource('string', array(
    'oqc_string_get_template',
    'oqc_string_get_timestamp',
    'oqc_string_get_secure',
    'oqc_string_get_trusted')
	);
	if (!array_key_exists('language', $variables)) {
		global $app_list_strings;
		$variables['language'] = $app_list_strings['oqc'];
	}
	$smarty->assign($variables);
	$output = $smarty->fetch('string:'.$input);
	//$GLOBALS['log']->error('replaceVariables: output is: '. var_export($output,true));
	
	return $output;
}


function getTextBlockHtml($textBlock) {
	
	return from_html($textBlock->description);
}
// Function for getting current user data. Uses several shortcuts since by default SugarCE users are not associated with any Account;
// the function below will work if Users have created Contacts/Acounts with unique email address
function oqc_getUserVariables() {
	
	global $current_user;
	$contractData = array();
	$userData = sanatizeBeanArrayForLatex($current_user->toArray(true));
	$email_address = $current_user->getEmailInfo();
	$firstName = $current_user->first_name;
	$lastName = $current_user->last_name;
		
	$emailBean = new EmailAddress();
	//Trying to find Contacts by email addresss or names, maybe we will be lucky
	$relatedId = $emailBean->getRelatedId($email_address['email'], 'Contacts');
	//$GLOBALS['log']->error('Search Contact id: '. var_export($relatedId[0],true));
	$userContact = new Contact();
	//We have unique id and can proceed to retrieve all required information	
	//$GLOBALS['log']->error('User variables: count output is: '. var_export(count($relatedId),true));	
	if ((count($relatedId)) == 1 && $relatedId[0]) {
		//$GLOBALS['log']->error('User variables: email recovery OK: ');
		if ($userContact->retrieve($relatedId[0])) {
			$contractData['userContact'] = sanatizeBeanArrayForLatex($userContact->toArray(true));
			
			
			$userAccount = new Account();
			if ($userAccount->retrieve($userContact->account_id)) {
		
			$contractData['userContact']['account'] = sanatizeBeanArrayForLatex($userAccount->toArray(true));
			} 
		}
	}
	//We have several ids associated with the same email address, try to match first and last names
	else  {
			//$GLOBALS['log']->error('Account variables: variables transferred to latex template: '. var_export($clientAccount->toArray(true),true));	
		   $where_clause = "first_name='{$firstName}' AND last_name='{$lastName}' AND deleted=0";
         $query = "SELECT id FROM contacts WHERE $where_clause";
         $r = $userContact->db->query($query, true);
         $retArr = array();
         while($a = $userContact->db->fetchByAssoc($r)) {
            $retArr[] = $a['id'];
        	}
        	//$GLOBALS['log']->error('User variables: retrieved from db: '. var_export($retArr,true));	
         if ((count($retArr) == 1) && $retArr[0]) {
         	if ($userContact->retrieve($retArr[0])) {
					$contractData['userContact'] = sanatizeBeanArrayForLatex($userContact->toArray(true));
					$userAccount = new Account();
						if ($userAccount->retrieve($userContact->account_id)) {
						$contractData['userContact']['account'] = sanatizeBeanArrayForLatex($userAccount->toArray(true));
						} 
				}
         }
         //Give up and use user data that are available
         else {
				$contractData['userContact']= $userData;
			}
	}
	$contractData['userContact']['email_address'] = $email_address['email'];
	return $contractData;
}


function getContractVariables($contract) {
	$contractData = sanatizeBeanArrayForLatex($contract->toArray(true));
	$clientContact = new Contact();
	if ($clientContact->retrieve($contract->clientcontact_id)) {
		$contractData['clientContact'] = sanatizeBeanArrayForLatex($clientContact->toArray(true)); // Gets data from DB only
		$clientAccount = new Account();
		if ($clientAccount->retrieve($clientContact->account_id)) {
			//$GLOBALS['log']->error('Account variables: variables transferred to latex template: '. var_export($clientAccount->toArray(true),true));	
			$contractData['clientContact']['account'] = sanatizeBeanArrayForLatex($clientAccount->toArray(true));} //gets data from DB only
	}
	
	// only date is needed (not time) and we have to convert it to the user format
	global $timedate;
	//$GLOBALS['log']->error('Contract variables: date_modified: '. var_export($contract->date_modified,true));
	//$contractData['date_modified'] = $timedate->to_display_date($contract->date_modified);
	$contractData['date_modified'] = $timedate->getDatePart($contract->date_modified);
	//$contractData['startdate'] = $timedate->to_display_date($contract->startdate);
	//$contractData['enddate'] = $timedate->to_display_date($contract->enddate);
	//$contractData['deadline'] = $timedate->to_display_date($contract->deadline);
	
	// translate
	global $app_list_strings;
	if (isset($contractData['periodofnotice'])) {
	$contractData['periodofnotice'] = $app_list_strings['periodofnotice_list'][$contractData['periodofnotice']]; }
	//contract currency setup
	$currency = new Currency();
	$currency_id = $currency->retrieve_id_by_name($contract->currency_id);
	//$GLOBALS['log']->error('Contract variables: currency: '. var_export($currency_id,true));
	if ($currency_id)	 {
		   $currency->retrieve($currency_id); 
			$contractData['currency_id']= $currency->iso4217;
			$contractData['currency_symbol'] = $currency->symbol;
	}
	else {
		$contractData['currency_id']= $currency->getDefaultISO4217();
		$contractData['currency_symbol'] = $currency->getDefaultCurrencySymbol();
	}
	$contractData['currency_symbol'] = str_replace("\xE2\x82\xAC", '\euro{}',$contractData['currency_symbol']);
	$contractData['currency_symbol'] = str_replace('$', '\$',$contractData['currency_symbol']);
	$contractData['currency_symbol'] = str_replace("\xC2\xA3", '{\pounds}',$contractData['currency_symbol']);
	$contractData['currency_symbol'] = str_replace("\xC2\xA5",  '{Y\hspace*{-1.4ex}--}' ,$contractData['currency_symbol']);
	
	// Get Sugar user information 
	$userData = oqc_getUserVariables();
	$contractData = array_merge($contractData,$userData);
	$outputData = array('contract' => $contractData, 'graphicsDir' => LATEX_GRAPHICS_DIR);
	
	//$GLOBALS['log']->error('Contract variables: variables transferred to latex template: '. var_export($contractData,true));
	return $outputData;
}

function getPdfVariables($contract) {
	
	global $app_list_strings;
	global $locale;
			
	$serviceArrays = array();
	$oneTimeServiceArrays = array();
	$productArrays = array();
	$oneTimeProductArrays = array();
	$pdfDataArray = array();
	$contractVariables = array();
	$calculatedCosts = array();
   $imagesExist = false;
   $sep = get_number_seperators();
	$vat_default = floatval(str_replace($sep[1],'.',$app_list_strings['oqc_vat_list']['default']))/100 ;
   
   //Get contract variables 
	$contractVariables = getContractVariables($contract);
	//Get service data for processing
	$services = $contract->get_linked_beans('oqc_service', 'oqc_Service');
	
	
	if (!empty($services)) {
		
		usort($services, array('oqc_Service', 'oqc_service_compare_position'));
		
		
	foreach ($services as $service) {
		$serviceArray = $service->toArray();
		$serviceArray = sanatizeBeanArrayForLatex($serviceArray);
		
		$product = getProductBean($service);
		if ($product) {
		$productArray = $product->toArray();
		$productArray = sanatizeBeanArrayForLatex($productArray);
		}
		else {$productArray= array();}
		
		if (!empty($service->description)) {
		// Rewrite description with Latex converter output.
			$convertor = new oqc_HtmlToLatexConverter();
			$serviceArray['description'] = $convertor->html2latex('<html><head></head><body>'.from_html($service->description).'</body></html>');	
		}
		
		elseif (!empty($product->description)) {
			$convertor = new oqc_HtmlToLatexConverter();
			$productArray['description'] = $convertor->html2latex('<html><head></head><body>'.from_html($product->description).'</body></html>');	
		}
		// translate
		
		$serviceArray['zeitbezug_translated'] = $app_list_strings['zeitbezug_list'][$serviceArray['zeitbezug']];
		if ($app_list_strings['unit_list'][$serviceArray['unit']]) {
					$serviceArray['unit'] = $app_list_strings['unit_list'][$serviceArray['unit']];}
		$calc_vat = ($serviceArray['oqc_vat'] == 'default') ? $vat_default : (($serviceArray['oqc_vat']!== '') ? $serviceArray['oqc_vat'] : $vat_default);
		$serviceArray['oqc_vat'] = $calc_vat *100 ;
		$serviceArray['discounted_price'] = $service->getDiscountedPrice($calc_vat);
      $serviceArray['discounted_price_tax_free'] = $service->getDiscountedPriceTaxFree();
      $serviceArray['image_url'] = false;
      if ($product) {
			if ($product->getImageFilenameUrl()) {
				if (WINDOWS) {
			      $serviceArray['image_url'] = str_replace("\\", "/", '"'. getcwd() .'"/'.$product->getImageFilenameUrl());
			   } else {
			   		$serviceArray['image_url'] = str_replace("\\", "/", getcwd().'/'.$product->getImageFilenameUrl());
			   }
			}
      }
      $serviceArray['has_image'] = $serviceArray['image_url'] !== FALSE; // convenient flag for access from latex template
      $serviceArray['startdate'] = $contract->startdate;
      $serviceArray['enddate'] = $contract->enddate;
      //$GLOBALS['log']->error('getPdfVariables: '. var_export($serviceArray['oqc_vat'],true));
     
        if (!empty($serviceArray['service_currency_id']) ) {
        		$currency = new Currency();
           //$currency_id = -99;
       		$currency->retrieve($serviceArray['service_currency_id']);
       	//Convert currency symbols to latex equivalents here        
				$serviceArray['currency_symbol'] = $currency->symbol; 
				$serviceArray['currency_symbol'] = str_replace("\xE2\x82\xAC", '\euro{}',$serviceArray['currency_symbol']);
				$serviceArray['currency_symbol'] = str_replace('$', '\$',$serviceArray['currency_symbol']);
				$serviceArray['currency_symbol'] = str_replace("\xC2\xA3", '{\pounds}',$serviceArray['currency_symbol']);
				$serviceArray['currency_symbol'] = str_replace("\xC2\xA5",  '{Y\hspace*{-1.4ex}--}' ,$serviceArray['currency_symbol']);
			}
      if (!$imagesExist && $serviceArray['has_image']) {
                    $imagesExist = true;}
				
		
		if ($service->zeitbezug == 'once') {
			$oneTimeServiceArrays[] = $serviceArray;
			$oneTimeProductArrays[] = $productArray;
			
		}
		else {
			$serviceArrays[] = $serviceArray;
			$productArrays[] = $productArray;
			
		}
	}
	
	// merge data from products and services, prefering service data
	$serviceData = array_map('array_merge', $productArrays, $serviceArrays);
	$oneTimeServiceData = array_map('array_merge', $oneTimeProductArrays, $oneTimeServiceArrays);
	
	}
    
	$costsTotal = calculateTotalCosts($serviceData, false);
	$oneTimeCostsTotal = calculateTotalCosts($oneTimeServiceData);
	//$currency_symbol = 
	
		
	$serviceData = array(
      'imagesExist' => $imagesExist,
		'services' => $serviceData, 
		'oneTimeServices' => $oneTimeServiceData,
		//'currency' => $locale->getPrecedentPreference('default_currency_iso4217'),
	);
		
	$pdfDataArray = array_merge($contractVariables, $serviceData, $costsTotal, $oneTimeCostsTotal);
	//$GLOBALS['log']->error('Services: variable transferred to pdf: '. var_export($pdfDataArray,true));
	return $pdfDataArray;
}

function calculateTotalCosts($dataArray,$once=true) {
	
	global $timedate;
	global $app_list_strings;
	
	
	//$linkedServices = $contract->get_linked_beans('oqc_service', 'oqc_Service');

	//$services_once_array = array();
	//$services_ongoing_array = array();
	
	$sumServicesVatTotal = 0;
	$sumServicesTotal = 0;
	$months = null;
	$variables = array();
	//$sep = get_number_seperators();
	//$vat_default = floatval(str_replace($sep[1],'.',$app_list_strings['oqc_vat_list']['default']))/100 ;
	if ($once) {
		foreach ($dataArray as $service) {
			$sumServicesVatTotal += $service['discounted_price_tax_free'] * $service['quantity'] * $service['oqc_vat']/100;
			$sumServicesTotal += $service['discounted_price'] * $service['quantity'];
			
			
			}
	$sumServicesVatTotal =  round($sumServicesVatTotal, 2);
	$sumServicesTotal = round($sumServicesTotal, 2);
	$sumServicesTaxFreeTotal = round($sumServicesTotal - $sumServicesVatTotal, 2);
	
	$variables = array(
		
		'ServicesOnceNetTotal' => $sumServicesTaxFreeTotal,
		'ServicesOnceVAT' => $sumServicesVatTotal,
		'ServicesOnceGrossTotal' => $sumServicesTotal,
		);		
			
	}
	//getServices($linkedServices, true, $services_once_array, $sumServicesOnceVAT, $sumServicesOnce, $vat_default);
	//getServices($linkedServices, false, $services_ongoing_array, $sumServicesOngoingVAT, $sumServicesOngoing, $vat_default);
	else {
		foreach ($dataArray as $service) {
		
		$startdate = from_db($timedate->to_db_date($service['startdate'], false));
		$enddate = from_db($timedate->to_db_date($service['enddate'], false));
		$months = 0;
		
		if (($startdate == 0) || ($enddate == 0))
	{
		$months = 12; // Kosten für ein Jahr, falls keine Angabe gemacht	
	} else
	{
		$months = MonthsBetween($startdate, $enddate);
	}

	//  foreach ($dataArray as $service) {
		$service_cost = 0.0;
		
		if ($service['zeitbezug'] == 'monthly')
		{
			$service_cost += ($service['discounted_price_tax_free'] * $service['quantity']) * $months;
		} else
		if ($service['zeitbezug'] == 'annually')
		{
			$service_cost += ($service['discounted_price_tax_free'] * $service['quantity'] / 12.0) * $months;
		}
		$sumServicesVatTotal += $service_cost * $service['oqc_vat']/100;
		$sumServicesTotal += $service_cost * (1 + $service['oqc_vat']/100);
	//  }
		
	}
	
	
	$sumServicesVatTotal =  round($sumServicesVatTotal, 2);
	$sumServicesTotal = round($sumServicesTotal, 2);
	$sumServicesTaxFreeTotal = round($sumServicesTotal - $sumServicesVatTotal, 2);
	
	$variables = array(
		'OngoingCostsNetTotal' => $sumServicesTaxFreeTotal,
		'OngoingCostsVAT' => $sumServicesVatTotal,
		'OngoingCostsGrossTotal' => $sumServicesTotal,
		'OngoingMonths' => $months,
		);
	}
			
	return $variables;
}	
	
function servicesToLatex($pdfData,$template) {	
	
	$filename = templateToLatex($template["SERVICES_TEMPLATE"], $pdfData);
	if ($filename == null) {
		return null;}
	$filenameWithExtension = $filename . '.tex';
	rename($filename, $filenameWithExtension);
	
	return $filenameWithExtension;
}

function titlePageToLatex($pdfData,$template) {
	$filename = templateToLatex($template["TITLE_PAGE_TEMPLATE"], $pdfData);
	if ($filename == null) {
		return null;}
	$filenameWithExtension = $filename . '.tex';
	rename($filename, $filenameWithExtension);
	
	return $filenameWithExtension;
}

function textBlocksToLatex($contract,$pdfData,$template) {
	//processing path html->smarty->latex->assemble into single file using skeleton/smarty
	$textBlocks = $contract->get_all_linked_textblocks();
	$textBlocksHtml = array_map('getTextBlockHtml', $textBlocks);
	
	//$GLOBALS['log']->error('textBlocksToLatex: data transferred to pdf: '. var_export($textBlocksHtml,true));
	if (!$textBlocksHtml) {
		return null;}
	
	$filenames = array();       
	foreach ($textBlocksHtml as $textBlockHtml) {
		
		//convert html files to latex 
		$latex_output = '';
		$smarty_output = '';
		$smarty_output = oqc_replaceVariables($textBlockHtml, $pdfData);
		$convertor = new oqc_HtmlToLatexConverter();
		$latex_output = $convertor->html2latex('<html><head></head><body>'.$smarty_output.'</body></html>'); // need to add head section for correct utf-8 handling
		
		$filename = tempnam(TMP_DIR, TEXTBLOCK_TMP_PREFIX);
		$filenames[] = $filename;

		
		file_put_contents($filename, $latex_output);
		
	}

	$variables = array('filenames' => $filenames);
	
	$filename = templateToLatex($template['TEXTBLOCKS_TEMPLATE'], $variables);
	if (!file_exists($filename)) {
		$GLOBALS['log']->error('OQC textBloksToLatex: Failed to convert HTML to Latex!');
		return null;
		}
	else {
	$filenameWithExtension = $filename . '.tex';
	rename($filename, $filenameWithExtension);
	$GLOBALS['log']->error('OQC textBloksToLatex: Converted texbloks filename is '.$filenameWithExtension);	
	
	// replace sequences of double newlines "\n\n" with "\newline \n" in latex file
	//$latexFileContents = file_get_contents($latexFilename);
	//$latexFileContents = preg_replace("/(.+)\\\\newline\n\n/", "$1 \\\\newline\n", $latexFileContents);
	//$latexFileContents = preg_replace("/(.+)\n\n/", "$1 \\\\newline\n", $latexFileContents);
	
	foreach ($filenames as $filename) {
		unlink($filename); }
	return $filenameWithExtension; // TODO unlink all temporal files
	}
}



function getProductBean($service) {
	if($service->product_id) {
	$product = new oqc_Product();
	$product->retrieve($service->product_id);
	return $product;
	} else { return null; }
}

function getPageCount($filename) {
	execute(PDFTK, "$filename dump_data", $pdfData);
	
	if (! preg_match('/NumberOfPages: (\d+)/', implode('\n', $pdfData), $matches)) {
		$GLOBALS['log']->fatal('OQC: Failed to get the number of pages of $filename!');
		return null;
		}

	return $matches[1];
}

function getRealFilename($revision) {
			return preg_replace('/\s/', '_', TMP_DIR . DIRECTORY_SEPARATOR . basename($revision->filename));
}

function attachDocuments($contract, $contractFilename) {
	$attachedDocuments = $contract->get_all_linked_attachments();
//	$GLOBALS['log']->error('Attached file:'. var_export($attachedDocuments, true));
	
	if (empty($attachedDocuments))
		return $contractFilename;

	$docHandler = null;
	$catArgs = array();
	$filenameArgs = array();
	$attachArgs = array();
	$filenames = array();
	$ids = range('B', chr(ord('B') + count($attachedDocuments) - 1));
	
	foreach ($attachedDocuments as $attachment_id) {
		$revision_id = $attachment_id;
		$revision = new DocumentRevision();
		if (!$revision->retrieve($attachment_id)) { 
		  $document = new Document();
		  if ($document->retrieve($attachment_id)) {
				$revision_id = $document->document_revision_id;
			}
		}
		if ($revision->file_ext != 'pdf' && $revision->file_mime_type != 'application/pdf') {
			if (! $docHandler)
				$docHandler = new DocumentHandler();
				
			$filename = getDocumentFilename($revision_id);
				// we need a descriptive filename for word macros and pdf attachments
			$realFilenameWithExtension = getRealFilename($revision); 
			$GLOBALS['log']->error('Copying files from: '. $filename. ' to: '. $realFilenameWithExtension);
			copy($filename, $realFilenameWithExtension);
			$filenames[] = $realFilenameWithExtension;
				
			$attachmentFilename = $docHandler->convertToPdf($realFilenameWithExtension);
			if ($attachmentFilename) {
				$catArgs[] = current($ids); 
				$filenameArgs[] = current($ids) . '=' . $attachmentFilename;
				$filenames[] = $attachmentFilename;
				next($ids);
			}		
			else {
				$attachArgs[] = $realFilenameWithExtension;
				$GLOBALS['log']->error('OQC DocumentHandler: file '.$realFilenameWithExtension. ' is not possible to convert to pdf!');
				continue;
			}
		}
		else {
			$attachmentFilename = getDocumentFilename($revision_id);
			$catArgs[] = current($ids);
			$filenameArgs[] = current($ids) . '=' . $attachmentFilename;
			next($ids);
		}
	}
	$GLOBALS['log']->error('Attached pdf files:'. var_export($catArgs, true));
	
	$testPdfFiles = implode('', $catArgs); //test if there are any pdf file available for pdftk
	$testAttachFiles = implode('', $attachArgs); //test if there are attachement files
	$outputFilename = tempnam(TMP_DIR, '');
	$finalFilename = tempnam(TMP_DIR, '');
	if(!empty($testPdfFiles)) {
		// merge files
		$pdfTkArgs = "A=$contractFilename " . implode(' ', $filenameArgs) . ' cat A ' . implode(' ', $catArgs) . " output $outputFilename keep_first_id";
	
	if (execute(PDFTK, $pdfTkArgs) == 0) {
		copy($outputFilename, $contractFilename); //overwrite source file
		}
		else {
		$GLOBALS['log']->error('Failed to merge PDF files!');
		}
	}
	if (!empty($testAttachFiles)) {
		$pdfTkArgs = "$contractFilename attach_files " . implode(' ', $attachArgs) . " output $finalFilename";

		if (execute(PDFTK, $pdfTkArgs) == 0) {
				copy($finalFilename,$contractFilename);
		}
		else { 
				$GLOBALS['log']->error('Failed to attach documents to final PDF!');
		}
		
	}
	//cleanup of temporary files
	unlink($finalFilename);
	unlink($outputFilename);	
	foreach($filenames as $attachfile) {
			unlink($attachfile);}
	
	return $contractFilename;
	
}

function createNewRevision($contract, &$document) {
	// TODO add some logic to select different templates for Contracts/Quotes/Additions
	//1. Get template paths. 2. get contract/services variables.3 Proceed to fetching partial templates. 4. Proceed to fetching main template and creating pdf file.
	if ($contract->oqc_template == null) {
	$beanName = substr(trim($contract->object_name),4);
	$templatePaths = getTemplatesPath($beanName);
	} else {
	$templatePaths = getTemplatesPath($contract->oqc_template);}
	$pdfData = getPdfVariables($contract);
	
	$segmentFilenames = array();
	$segmentFilenames['titlePage'] = titlePageToLatex($pdfData,$templatePaths);
	$segmentFilenames['textBlocks'] = textBlocksToLatex($contract, $pdfData, $templatePaths);
	//if ($segmentFilenames['textBlocks'] == null ) {
		//$GLOBALS['log']->fatal('OQC: TextBloks are empty or You do not have html2tex convertor installed!');
		//return null;
	//	} 
	$segmentFilenames['services'] = servicesToLatex($pdfData,$templatePaths);
	
	
	$contractFilename = null;
	$contractFilename = templateToPdf($templatePaths["CONTRACT_TEMPLATE"], $segmentFilenames);
	if ($contractFilename == null) {
		//$GLOBALS['log']->fatal('OQC: You likely do not have PDFLATEX package installed!');
		return null;
		}
	if (DEBUG_PDF_CREATION) {
		$contractWithAttachmentsFilename = $contractFilename;
		// Add information about pdftk to the log file
		$returnTestValue = null;
		$outputArray = array();
		$returnTestValue = execute(PDFTK, '--version', $outputArray);
		$GLOBALS['log']->error('createNewRevision: pdftk $returnTestValue is: ' .$returnTestValue);
		if (!empty($outputArray)) {
			$addString = "\n\rpdftk --version output: \n\r" . implode("\n",$outputArray);
		} else {
			$addString = "\n\rpdftk --version output: null \nreturn value: {$returnTestValue}";
		}
		sugar_file_put_contents($contractWithAttachmentsFilename, $addString, FILE_APPEND | LOCK_EX);
	} else {
		$contractWithAttachmentsFilename = attachDocuments($contract, $contractFilename);
		if ($contractWithAttachmentsFilename == null) {
			$GLOBALS['log']->fatal('OQC: You likely do not have PDFTK package installed!');
			$contractWithAttachmentsFilename = $contractFilename;
		}
	}
	// unlink segmentFilenames
	foreach ($segmentFilenames as $filename) {
		unlink($filename); }
	
	$revision = new DocumentRevision();
	$revision->document_id = $document->id;
	$revision->revision = $contract->version; //1.7.6 Make document version the same as seed 
	if (DEBUG_PDF_CREATION) {
		$revision->file_mime_type = 'text/plain';
		$revision->file_ext = 'log';
		$revision->filename = $document->category_id .'_'.$contract->svnumber.'_v'. $revision->revision.'.log';
	} else {
		$revision->file_mime_type = 'application/pdf';
		$revision->file_ext = 'pdf';
		$revision->filename = $document->category_id .'_'.$contract->svnumber.'_v'. $revision->revision.'.pdf';
	}
	$revision->save();
	
	rename($contractWithAttachmentsFilename, getDocumentFilename($revision->id));
	
	$document->document_revision_id = $revision->id;
	//$document->save();
	return true;
}

function createPdf($contract) {
	//1.7.6 fix for document category
	global $timedate;
   global $app_list_strings;
   	global $current_user;
   	global $sugar_config;
	$beanname = get_class($contract);
	$document_category = substr(trim($beanname),4);
	if ($document_category == 'Offering') {
		$document_category = 'Quote';
		}
	$oqc_run = false;
		//Try to find if some version of contract had document_id created 
	if ($contract->document_id == null) {
		$legacy_document_id = $contract->find_document_id($contract);
		$contract->document_id = $legacy_document_id;
		$GLOBALS['log']->error('OQC: Found contract_id! '.$contract->document_id);
		if (!empty($contract->document_id)) {
			$oqc_run = true;
		}
	}
	//$conf = Configuration::getInstance();
	if (DEBUG_PDF_CREATION) {
		$oqc_run = true;
	}
	$document = new Document();
	if (! $document->retrieve($contract->document_id)) {
		//Creating document name for the first time
		$document->document_name = $document_category.'Pdf-'.$contract->svnumber;
		$document->category_id = $document_category;
		$document->subcategory_id = 'Pdf';
		$document->active_date = date($timedate->get_date_format());
		$document->status_id = "Active";
		$document->document_purpose_c = "Customer";
		$document->assigned_user_id = $current_user->id;
		
		// create an id for this new document
		$document->save();
		$document->new_with_id = false ; //1.7.8 Since sugar 6.2 document saving generated error- this is fix for it
		$oqc_done = createNewRevision($contract, $document);
				
	} else {
		$revision = new DocumentRevision();
		if (!$document->document_revision_id) {
			$oqc_run = true;}
		$revision->retrieve($document -> document_revision_id);
		if (($contract ->version == $revision ->revision) && ($oqc_run == false)) { //SET TO TRUE FOR PDF CREATION INDEPENDENT ON VERSION
		
		// do not create new revision since pdf file is already created for this revision. Normally, only one pdf
		// file can be created for each revision.
			$GLOBALS['log']->fatal('OQC: File already exist -skip file conversion to PDF!');
			header("Location:index.php?entryPoint=download&id={$document->document_revision_id}&type=Documents");
			exit ;
		} else {
			if (($contract ->version == $revision ->revision) && ($oqc_run == true)) {
				$revision->mark_deleted($revision->id);
				$GLOBALS['log']->error('OQC: Deleted inactive document revision!');
			}
			$document->active_date = date($timedate->get_date_format());
			$document->status_id = 'Active';
			$document->assigned_user_id = $current_user->id;
			$document->save();
			$document->new_with_id = false ;
			$oqc_done = createNewRevision($contract, $document);
		}	
	}

	if ($oqc_done) {
		$document->save();
		$documents = 'documents';
		$contract->load_relationship($documents);
		$contract->documents->add($document->id);
		$contract->document_id = $document->id;
		$contract->save();
		header("Location: index.php?action=DetailView&module=DocumentRevisions&record={$document->document_revision_id}");
		exit;
	}
	else { 
		if (!$contract->document_id)	{
			$document->mark_deleted($document->id); //This was new document, so delete it if pdf creation fails
		}
		echo "<html>
			Pdf creation failed. Set debugPdfCreation=1 in config file and re-run creation of pdf file to get error log. </br>
			<a href=\"{$sugar_config['site_url']}/index.php?action=DetailView&module={$beanname}&record={$contract->id}\">Return to previuos page</a>
			</html>";
		exit;
	}
		
}

// remove apostroophe symbol from filename because it causes trouble: the filename then contains something like &#039;. even if you replace this again with a real apostrophe.
function sanatizeFilename($filename) {
	$filename = str_replace('&#039;', '', $filename);
	return trim($filename);
}
//1.7.5 - creates single pdf file from all Product attachements 
function createAttachedDocumentsPdf($product) {
	$attachedDocuments = $product->get_all_linked_attachments();
//	trigger_error("Started to convert products to PDF!", E_USER_NOTICE);	
	if (empty($attachedDocuments))
		return null;

	$docHandler = null;
	$catArgs = array();
	$filenameArgs = array();
	$filenames = array();
	$attachArgs = array();
	$ids = range('A', chr(ord('A') + count($attachedDocuments) - 1));
	
	foreach ($attachedDocuments as $attachment_id) {
		$revision_id = $attachment_id;
		$revision_check = new DocumentRevision();
		if (!$revision_check->retrieve($attachment_id)) { 
		  $document = new Document();
		  if ($document->retrieve($attachment_id)) {
				$revision_id = $document->document_revision_id;
				$purpose = $document->document_purpose_c;
			}
		} else {
			$document = new Document();
		  if ($document->retrieve($revision_check->document_id)) {
				$purpose = $document->document_purpose_c;
			}
			
		}
		
		
		if ($purpose == 'Catalog') { //1.7.6 include only documents marked For Product Catalog
		$revision = new DocumentRevision();
		if ($revision->retrieve($revision_id)) { 
			if ( $revision->file_ext != 'pdf') { //SugarCE determines file type unreliably, so only extension is used
				if (! $docHandler)
					$docHandler = new DocumentHandler();
				
				$filename = getDocumentFilename($revision_id); // skuria failo varda su nuoroda
				// we need a descriptive filename for word macros and pdf attachments
				$realFilenameWithExtension = getRealFilename($revision); 
				copy($filename, $realFilenameWithExtension); 
				$filenames[] = $realFilenameWithExtension;
				$attachmentFilename = $docHandler->convertToPdf($realFilenameWithExtension);
				if ($attachmentFilename) {
						$catArgs[] = current($ids); 
						$filenameArgs[] = current($ids) . '=' . $attachmentFilename;
						$filenames[] = $attachmentFilename;
						next($ids);
				}
				else { // file was not possible to convert
						$attachArgs[] = $realFilenameWithExtension;
						$GLOBALS['log']->fatal('OQC DocumentHandler: file '.$realFilenameWithExtension. ' is not possible to convert to pdf!');
						continue;
				}
			}
			else {
				$attachmentFilename = getDocumentFilename($revision_id);
				$catArgs[] = current($ids);
				$filenameArgs[] = current($ids) . '=' . $attachmentFilename;
				next($ids);
			}
			
		}
	  }	
	}
	
	$testPdfFiles = implode('', $catArgs); //test if there are any pdf file available for pdftk
	//$GLOBALS['log']->error('OQC pdf testfiles'.$testPdfFiles);
	$testAttachFiles = implode('', $attachArgs); //test if there are attachement files
	if (empty($testPdfFiles)) {
		foreach($filenames as $attachfile) {
			unlink($attachfile);}
		return null;
		}
	$outputFilename = tempnam(TMP_DIR, '');
	$finalFilename = tempnam(TMP_DIR, '');
	$contractFilename = tempnam(TMP_DIR, '');
	if(!empty($testPdfFiles)) {
		// merge files
		$pdfTkArgs = implode(' ', $filenameArgs) . ' cat ' . implode(' ', $catArgs) . " output $outputFilename keep_first_id";
	
	if (execute(PDFTK, $pdfTkArgs) == 0) {
		copy($outputFilename, $contractFilename); //owerwrite source file
		}
		else {
		$GLOBALS['log']->error('Failed to merge PDF files!');
		//cleanup of temporary files
		unlink($finalFilename);
		unlink($outputFilename);
		unlink($contractFilename);	
		foreach($filenames as $attachfile) {
			unlink($attachfile);}
		return null;	
		}
	}
	if (!empty($testAttachFiles) && !empty($testPdfFiles)) {
		$pdfTkArgs = "$contractFilename attach_files " . implode(' ', $attachArgs) . " output $finalFilename";

		if (execute(PDFTK, $pdfTkArgs) == 0) {
				copy($finalFilename,$contractFilename);
		}
		else { 
				$GLOBALS['log']->error('Failed to attach documents to final PDF!');
		}
		
	}
	//cleanup of temporary files
	unlink($finalFilename);
	unlink($outputFilename);	
	foreach($filenames as $attachfile) {
			unlink($attachfile);}
	$contractFilenamePdf = str_replace("\\", "/", dirname($contractFilename) . DIRECTORY_SEPARATOR . basename($contractFilename, '.tmp').'.pdf'); 
	rename($contractFilename, $contractFilenamePdf);
	//$GLOBALS['log']->error('OQC: Attachment filename is '.$contractFilenamePdf);
	
	//return str_replace("\\","/",$contractFilename.'.pdf');
	return $contractFilenamePdf;
}
// end of modification 
?>
