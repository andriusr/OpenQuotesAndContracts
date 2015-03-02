<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');
require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/Currencies/Currency.php');
require_once('modules/Currencies/ListCurrency.php');

 function option_downloadLink($id)
{
	//return 'download.php?id=' . $id . '&type=Documents'; // Sugar 5.0
	return 'index.php?module=oqc_Product&record=' . $id . '&action=DetailView&return_module=oqc_Product'; 
}
//2.2RC1 we can use also package variables, but this way user can remove package table without affecting other parts
function option_configureCurrencyVariables() {

	$currency = new ListCurrency();
	global $current_user;
		$currency->javascript .="var oqc_optionConversionRates = new Array(); \n";		
		$currency->javascript .="var oqc_optionCurrencySymbols = new Array(); \n";
		$currency->javascript .="var oqc_optionCurrencyNames = new Array(); \n";
		$currency->lookupCurrencies();
		if(isset($currency->list ) && !empty($currency->list )){
			foreach ($currency->list as $data){
				if($data->status == 'Active'){
					$currency->javascript .=" oqc_optionConversionRates['".$data->id."'] = '".$data->conversion_rate."';\n";
					$currency->javascript .=" oqc_optionCurrencySymbols['".$data->id."'] = '".$data->symbol."';\n";
					$currency->javascript .=" oqc_optionCurrencyNames['".$data->id."'] = '".$data->name."';\n";
				}
			}
		}
		$currency->javascript .= '</script>';
		return $currency->javascript ;
}

function buildProductOptionsArray($options, $current_id, $current_ratio) {
	
	global $app_strings;
	global $app_list_strings;
	$options_array = array();
	foreach ($options as $option) {
		if ($option->currency_id != $current_id ) {
			$optionCurrency = new Currency();
			if (!empty($option->currency_id) && $option->currency_id != '-99') {
				$optionCurrency->retrieve($option->currency_id);
				$option_conversion_rate = $optionCurrency->conversion_rate;
			} else {$option_conversion_rate = 1; }
			$option->price = $option->price * $current_ratio/$option_conversion_rate;
			}
		if ($option->deleted) {
			$option->name .= '<br>'. $app_strings['LBL_OQC_PRODUCT_DELETE']; }
		if (!$option->active) {
			$option->name .= '<br>'. $app_strings['LBL_OQC_PRODUCT_INACTIVE'];}
		//2.2RC2 translation eroor fix
		if (isset($app_list_strings["oqc_product_status_list"][$option->status])) {
			$option->status = $app_list_strings["oqc_product_status_list"][$option->status];
			}
      $options_array[] = array('name' => from_html($option->name),
       									'id' => $option->id,
	                              'status' => $option->status,
	                              'price' => $option->price,
	                              'is_recurring' => $option->is_recurring,
	                              'version' => $option->version,
	                              'date_modified' => $option->date_modified,
	                              'modified_by_name' => $option->modified_by_name,
	                              'option_url' => $option->deleted ? '' : option_downloadLink($option->id),
	                              'currency_id' => $current_id,
	                              'row_status' => $option->deleted ? 'delete' : 'saved',
	  									);	
	}
	
	return $options_array;
}

function get_all_linked_product_options($focus) {
	$optionsIds = explode(' ', trim($focus->optionssequence));
	$options = array();

	foreach ($optionsIds as $id) {
		$option = new oqc_Product();

		if ($option->retrieve($id)) {
		  
			if (($option->is_latest == 1) || ($focus->is_latest == 0)) {
			$options[] = $option;
			} else {
			$option = $option->getLatestRevision();
			$options[] = $option;	
			}
		}
	}

	return $options;
}



function getProductOptionsHtml($focus, $name, $value, $view) 
{
    if ('EditView' != $view && 'DetailView' != $view) {
        return ""; // skip the rest of the method if another view calls this method
    }

   global $app_list_strings;
   global $mod_strings;
   global $locale;
	$smarty = new Sugar_Smarty;

	// setup the popups link
	$popup_request_data = array(
		'call_back_function' => 'popup_return_option',
		'formName' => 'EditView',
		'field_to_name_array' => array(
			"price" => "price",
			"is_recurring" => "is_recurring",
			"version" => "version",
			"name" => "name",
			"id" => "id",
			"status" => "status",
			"date_modified" =>  "date_modified",
			"modified_by_name" => "modified_by_name",
			"currency_id" => "currency_id",
		),
		'passthru_data' => array(),		
	);

	$json = getJSONobj();
	$encoded_request_data = $json->encode($popup_request_data);
	//$languageStrings = array_merge($app_list_strings["oqc"]["ProductOptions"], $mod_strings);
	$languageStrings = $json->encode($app_list_strings["oqc"]["ProductOptions"]);
		
	
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
	$currencyScript = option_configureCurrencyVariables();
	
	if (isset($focus->optionssequence)) {
	$c = get_all_linked_product_options($focus);   
	$smarty->assign('productOptions', buildProductOptionsArray($c, $current_id, $current_ratio));
	} else { $smarty->assign('productOptions', array()); }
	
	$sep = get_number_seperators();
	$smarty->assign('currencySymbol', $currencySymbol);
	$smarty->assign('current_rate', $current_ratio);
	$smarty->assign('current_id', $current_id);
	$smarty->assign('optionCurrencyJavascript', $currencyScript);
	
	$smarty->assign('thousandsSeparator', $sep[0]);
	$smarty->assign('decimalSeparator', $sep[1]);
	$smarty->assign('moduleName', 'oqc_Product');
	$smarty->assign('languageStringsProductOptions', $languageStrings);
	$smarty->assign('addOption', $app_list_strings["oqc"]["ProductOptions"]['add']);
	$smarty->assign($mod_strings);
	$smarty->assign('options_popup_encoded_request_data', $encoded_request_data);
	
//	$smarty->assign('create_popup_encoded_request_data', $encoded_request_data);
//	$smarty->assign('upload_revision_encoded_request_data', $encoded_revision_request_data);	
	$smarty->assign('initialFilter', "\"&is_option=1\""); 

	return $smarty->fetch('include/oqc/ProductOptions/' . $view . '.html');    
}
 
?>
