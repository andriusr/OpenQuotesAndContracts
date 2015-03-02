<?php
require_once('modules/Documents/Document.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');
require_once('include/formbase.php');
require_once('include/Sugar_Smarty.php');
require_once('include/oqc/Services/Services.php');
require_once('include/oqc/Pdf/Common.php');
require_once('include/oqc/common/common.php');

define('EXTERNAL_CONTRACT_TEMPLATE', 'include/oqc/Pdf/ExternalContract/ExternalContract.tpl');

class ExternalContractPdfCreator {
	public function createPdf($contract) {
		$contractFilename = templateToPdf(EXTERNAL_CONTRACT_TEMPLATE, $this->getExternalContractVariables($contract), 3);
		rename($contractFilename, "{$GLOBALS['sugar_config']['cache_dir']}/modules/Emails/attachments/{$contract->id}");

		$filename = utf8_decode($contract->name); // fix for #541, see http://de2.php.net/manual/de/function.utf8-decode.php
		header("Location: index.php?entryPoint=download&id={$contract->id}&type=oqc_ExternalContract&isTempFile=true&tempName=$filename.{$contract->version}.pdf");
	}

	private function getExternalContractVariables($contract) {
		$contractData = $contract->toArray();
		$contractData = sanatizeBeanArrayForLatex($contractData);

		$contact = new Contact();
		if ($contact->retrieve($contract->clientcontact_id)) {
			$contractData['clientcontactperson'] = $contact->toArray();
		}

		$contact = new Contact();
		if ($contact->retrieve($contract->technicalcontact_id)) {
			$contractData['technicalcontactperson'] = $contact->toArray();
		}

		$contact = new Contact();
		if ($contact->retrieve($contract->contact_id)) {
			$contractData['contactperson'] = $contact->toArray();
		}

		$account = new Account();
		if ($account->retrieve($contract->account_id)) {
			$contractData['account'] = $account->toArray();
		}

                global $timedate;
                $contractData['startdate'] = $timedate->to_display_date($contract->startdate);
                $contractData['minimumduration'] = $timedate->to_display_date($contract->minimumduration);

		global $app_list_strings;
		if ($contract->endperiod == 'other') {
	                $contractData['endperiod'] = $timedate->to_display_date($contract->enddate);
		}
		else {
        	        $contractData['endperiod'] = $app_list_strings['endperiod_list'][$contract->endperiod];
		}

		if ($contract->cancellationperiod == 'other') {
	                $contractData['cancellationperiod'] = $timedate->to_display_date($contract->cancellationdate);
		}
		else {
        	        $contractData['cancellationperiod'] = $app_list_strings['cancellationperiod_list'][$contract->cancellationperiod];
		}

		// show address linebreaks in pdf
		$contractData['deliveryaddress'] = preg_replace("/\n/", '\\newline ', $contract->deliveryaddress);
		$contractData['completionaddress'] = preg_replace("/\n/", '\\newline ', $contract->completionaddress);

		$contractData['svnumbers'] = $contract->getSVNumbersArray();

		// TODO: abbreviation and type probably have to be converted in the future
		$contractMatters = explode('^,^', $contract->externalcontractmatter);
		foreach ($contractMatters as &$matter) {
			$matter = $app_list_strings['externalcontractmatter_list'][$matter];
		}
		$contractData['externalcontractmatter'] = implode('\\newline ', $contractMatters);

		$previousCategory = '';
		$costs = $contract->getCostsArray();
		
		$months = getLanguageStringsPHP('months');
					
		foreach ($costs as &$cost) {
			$cost['numberOfDetailedCosts'] = count($cost['detailedCosts']);
			
			if ($previousCategory == $cost['category']) {
				$previousCategory = $cost['category'];
				$cost['category'] = ''; // TODO @LION i guess that leaving the category field empty should to some kind of marking... please comment. 
			} else {
				$previousCategory = $cost['category'];
				$cost['category'] = $app_list_strings['externalcontractmatter_list'][$cost['category']];
			}

			if ('annually' === $cost['paymentinterval'] || 'once' === $cost['paymentinterval'] || 'other' === $cost['paymentinterval']) {
				$enddate = date_parse($contract->enddate);
				
				// if the payment interval of this cost is once, annually or other, there will be only one detailed cost row.
				// so it is correct to modify the first detailed cost item in the array.
				// set the month for this detailed cost row to the month of the enddate. 
				$cost['detailedCosts'][0]['month'] = $enddate['month'];
			}
			
			// do translation now because paymentinterval will not be read from php code anymore.
			// so it can be in localized form from now on. 
			$cost['paymentinterval'] = $app_list_strings['paymentinterval_list'][$cost['paymentinterval']];
			
			foreach ($cost['detailedCosts'] as &$detailedCosts) {
				$detailedCosts['price'] = formatCurrencyForSmartyLatex($detailedCosts['price'], false); // format price for latex template (see #387)
			}
		}

		$positions = $contract->getPositionsArray();
		foreach ($positions as &$position) {
			$position['type'] = $app_list_strings['externalcontractmatter_list'][$position['type']];
			$position['price'] = formatCurrencyForSmartyLatex($position['price'], false); // format price for latex template (see #387)
		}
		
		// convert all currency values / prices before giving them to smarty
		$contractData['finalcosts'] = formatCurrencyForSmartyLatex($contractData['finalcosts'], true);
		
		return array(
			'numberOfCosts' => count($costs),
			'months' => $months,
			'contract' => $contractData, 
			'costs' => $costs,
			'positions' => $positions,
			'currencySymbol' => currencySymbolToLatexEquivalent(getSugarCrmLocale('default_currency_symbol')),
		);
	}

}
?>
