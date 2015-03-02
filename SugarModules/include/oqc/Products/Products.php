<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');
require_once('include/oqc/common/Configuration.php');
require_once('modules/oqc_Product/oqc_Product.php');
require_once('include/oqc/Services/CalendarMath.php');
require_once('modules/Currencies/Currency.php');
require_once('modules/Currencies/ListCurrency.php');
require_once('modules/oqc_Category/oqc_Category.php');

function configureCurrencyVariables() {

	$currency = new ListCurrency();
	global $current_user;
		$currency->javascript .="var oqc_ConversionRates = new Array(); \n";		
		$currency->javascript .="var oqc_CurrencySymbols = new Array(); \n";
		$currency->javascript .="var oqc_CurrencyNames = new Array(); \n";
		$currency->lookupCurrencies();
		if(isset($currency->list ) && !empty($currency->list )){
		foreach ($currency->list as $data){
			if($data->status == 'Active'){
			$currency->javascript .=" oqc_ConversionRates['".$data->id."'] = '".$data->conversion_rate."';\n";
			$currency->javascript .=" oqc_CurrencySymbols['".$data->id."'] = '".$data->symbol."';\n";
			$currency->javascript .=" oqc_CurrencyNames['".$data->id."'] = '".$data->name."';\n";
		}}
		}
		$currency->javascript .= '</script>';
		return $currency->javascript ;
}

function getCategoryNameHtml($focus, $name, $value, $view) {
	if ('DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}
	$category = new oqc_Category;
	if ($category->retrieve($focus->relatedcategory_id)) {
		return $category->name;
		}
	else { return "";}
}


function getProductsHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}

   global $app_list_strings;
   global $app_strings;
   $smarty = new Sugar_Smarty;
 // setup the popup link
	$popup_request_data = array(
		'call_back_function' => 'OqcProducts.handlePopUpClosed',
		'formName' => 'EditView',
		'field_to_name_array' => array(
			"price" => "price",
			"is_recurring" => "is_recurring",
			"unit" => "unit",
			"name" => "name",
			"id" => "productId",
			"oqc_vat" => "oqc_vat",
			"cancellationperiod" => "cancellationperiod",
			"monthsguaranteed" => "monthsguaranteed",
			"currency_id" => "currency_id",
	),
		'passthru_data' => array(
			'unit_hours' => $app_list_strings['unit_list']['hours'],
			'unit_pieces' => $app_list_strings['unit_list']['pieces'],
			'zeitbezug_once' => $app_list_strings['zeitbezug_list']['once'],
			'zeitbezug_monthly' => $app_list_strings['zeitbezug_list']['monthly'],
			'zeitbezug_annually' => $app_list_strings['zeitbezug_list']['annually'],
		),		
	);
	$json = getJSONobj();
	$encoded_request_data = $json->encode($popup_request_data);
	$languageStrings = $app_list_strings["oqc"]["Services"];
	//YUI error messages
	$languageStrings['LBL_NO_RECORDS_MESSAGE'] = $app_strings['LBL_NO_RECORDS_MESSAGE'];
	$languageStrings['LBL_DATA_ERROR_MESSAGE'] = $app_strings['LBL_DATA_ERROR_MESSAGE'];
	$languageStrings['LBL_LOADING_MESSAGE'] = $app_strings['LBL_LOADING_MESSAGE'];
	$languageStringsJSON = $json->encode($languageStrings);
	

	global $timedate;
	global $locale;

	$sqsJavascript = '<script type="text/javascript" src="include/oqc/QuickSearch/oqcQS.js"></script>';
	$sqsJavascript .= '<script type="text/javascript" language="javascript">';
	$sqsJavascript .= 'addToValidateDateBefore("EditView", "now", "date", true , "Deadline has to be in the future. " ,"deadline");';
	$sqsJavascript .= '</script>';
	
	//2.2RC get product currency
	if(isset($focus->currency_id) && $focus->currency_id != '') {
		$currentCurrency = new Currency();
		$currentCurrency->retrieve($focus->currency_id);
		$currencySymbol = $currentCurrency->symbol;
		$current_ratio = $currentCurrency->conversion_rate;
		$current_id = $currentCurrency->id;
	} else {
	
		$currencySymbol = $locale->getPrecedentPreference('default_currency_symbol');
		$current_ratio = 1;
		$current_id = '-99';
		}
		
	$currencyScript = configureCurrencyVariables();

	$sep = get_number_seperators();
	$smarty->assign('thousandsSeparator', $sep[0]);
	$smarty->assign('decimalSeparator', $sep[1]);
	$smarty->assign('dropdownLabelsUnitJSON', $json->encode($app_list_strings['unit_list']));
	$smarty->assign('dropdownLabelsRecurrenceJSON', $json->encode($app_list_strings['zeitbezug_list']));
	$smarty->assign('dateFormat', $locale->getPrecedentPreference('default_date_format'));
	$smarty->assign('currencySymbol', $currencySymbol);
	$smarty->assign('current_rate', $current_ratio);
	$smarty->assign('current_id', $current_id);
	$smarty->assign('currencyJavascript', $currencyScript);
	$smarty->assign('languageStrings', $languageStrings);
	$smarty->assign('languageStringsJSON', $languageStringsJSON);
	$smarty->assign('dropdownLabelsVatJSON', $json->encode($app_list_strings['oqc_vat_list'])); //1.7.8
	$smarty->assign('sqsJavascript', $sqsJavascript);
	$smarty->assign('now', date($timedate->get_date_format()));
	$smarty->assign('contractId', $focus->id);
	$smarty->assign('initialFilter', "&not_this_product_id={$focus->id}"); // see view.popup.php of oqc_Product :)
	$smarty->assign('encoded_request_data', $encoded_request_data);
   $smarty->assign('isPacket', $focus->isPacket());
	

	
	// new for yui
	$smarty->assign('id', $focus->id);
	$smarty->assign('moduleName', $focus->object_name);

	return $smarty->fetch('include/oqc/Products/Products.' . $view . '.html');
}
?>