<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');
require_once('modules/oqc_Product/oqc_Product.php');
require_once('include/QuickSearchDefaults.php');
require_once('modules/Currencies/Currency.php');
require_once('modules/Currencies/ListCurrency.php');

function configureCurrencyVariables(&$focus) {
	
	
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
			}
		}
		
		//2.2RC1 Some legacy code to determine focus->currency_id
		foreach ($currency->list as $data){
	//		$focus_currency_id = '';
			if($data->status == 'Active'){
				if ($data->name == $focus->currency_id) {
					$focus->currency_id = $data->id;
					break;
				}
			}
		}
		
		}
		
		$currency->javascript .= '</script>';
		return $currency->javascript ;
	
	
	
	
	}
//1.7.8 this is based on /modules/Currency/Currency.php - workaround for the Sugar bug that creates several html tags with the same id.	
/*function oqc_getCurrencyNameDropDown($focus, $field='currency_name', $value='', $view='DetailView')
{
    if($view == 'EditView' || $view == 'MassUpdate' || $view == 'QuickCreate'){
		$currency_fields = array();
		//Bug 18276 - Fix for php 5.1.6
		$defs=$focus->field_defs;
		//
		foreach($defs as $name=>$key){
			if($key['type'] == 'currency'){
			$currency_fields[]= $name;			
			}
		}
		$currency = new ListCurrency();
        $currency->lookupCurrencies();
        $listitems = array();
        foreach ( $currency->list as $item )
            $listitems[$item->name] = $item->name;
        return '<select name="'.$field.'" id="oqc'.$field.'" />'. //1.7.8 fix for getting correct id
            get_select_options_with_id($listitems,$value).'</select>';
	}else{
//$GLOBALS['log']->error('OQC: focus name is '.$focus->object_name);
		$currency = new Currency();
        if (!empty($focus->currency_id) ) {
            return $focus->currency_id;
        } else {
       $currency_id = -99;
       $currency->retrieve($currency_id);
		 return $currency->name;
		}
	}
}

function oqc_getCurrencyDropDown($focus, $field='currency_id', $value='', $view='DetailView'){
    $view = ucfirst($view);
	if($view == 'EditView' || $view == 'MassUpdate' || $view == 'QuickCreate'){
        if ( isset($_REQUEST[$field]) && !empty($_REQUEST[$field]) ) {
            $value = $_REQUEST[$field];
	    } elseif ( empty($focus->id) ) {
            $value = $GLOBALS['current_user']->getPreference('currency');
            if ( empty($value) ) {
                // -99 is the system default currency
                $value = -99;
            }
        }
		require_once('modules/Currencies/ListCurrency.php');
	//	$currency_fields = array();
		//Bug 18276 - Fix for php 5.1.6
	//	$defs=$focus->field_defs;
		//
	//	foreach($defs as $name=>$key){
	//		if($key['type'] == 'currency'){
	//			$currency_fields[]= $name;
	//		}
	//	}
		$currency = new ListCurrency();
        $selectCurrency = $currency->getSelectOptions($value);

	//	$currency->setCurrencyFields($currency_fields);
		$html = '<select name="'. $field. '" id="oqc' . $field  . '_select" ';
	//	if($view != 'MassUpdate')
	//		$html .= 'onchange="CurrencyConvertAll(this.form);"';
		$html .= '>'. $selectCurrency . '</select>';
	//	if($view != 'MassUpdate')
	//		$html .= $currency->getJavascript();
		return $html;
	}else{

		$currency = new Currency();
		$currency->retrieve($value);
		return $currency->name;
	}

}
*/


function getServicesHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}

    global $app_list_strings;
	 global $app_strings;
    $smarty = new Sugar_Smarty;
  
	// setup the popup link
	$popup_request_data = array(
		'call_back_function' => 'OqcServices.handlePopUpClosed',
		'formName' => 'EditView',
		'field_to_name_array' => array(
			"price" => "price",
			"is_recurring" => "is_recurring",
		//	"price_recurring" => "price_recurring",
			"unit" => "unit",
			"name" => "name",
			"id" => "productId",
			"zeitbezug" => "zeitbezug",
			"currency_id" => "currency_id",
			//"oqc_vat" => "oqc_vat",
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

        // $_GLOBALS['log']->fatal("asasdasd " . $languageStrings['totalNegotiatedPrice']);

	global $timedate;
	global $locale;

	$sqsJavascript = '<script type="text/javascript" src="include/oqc/QuickSearch/oqcQS.js"></script>';
	$sqsJavascript .= '<script type="text/javascript" language="javascript">';
	$sqsJavascript .= 'addToValidateDateBefore("EditView", "now", "date", true , "Deadline has to be in the future. " ,"deadline");';
	$sqsJavascript .= '</script>';
	//1.7.8 setup of currency variables for javascript
	 
	$currencyScript = configureCurrencyVariables($focus);
	//2.2RC get contract currency
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
	
	
	
//	$default_currency = new Currency();
//	$default_currency->retrieve('-99');
//	$currencySymbol = $default_currency->symbol;
	//$currencySymbol = $locale->getPrecedentPreference('default_currency_symbol');
	
	
	
//	require_once('include/oqc/common/common.php');
	require_once('include/oqc/common/Configuration.php');
	$conf = Configuration::getInstance();
	$hideRecurringContainer = $conf->get('hideRecurringTable');
	//$GLOBALS['log']->error('OQC: Legacy Vat value is '.$vat);
	
	$sep = get_number_seperators();
	$vat_default = floatval(str_replace($sep[1],'.',$app_list_strings['oqc_vat_list']['default']))/100 ;
	//$GLOBALS['log']->error('OQC: Default Vat value is '.$vat_default);
	$smarty->assign('hideContainer', $hideRecurringContainer);
	$smarty->assign('thousandsSeparator', $sep[0]);
	$smarty->assign('decimalSeparator', $sep[1]);
	$smarty->assign('dropdownLabelsUnitJSON', $json->encode($app_list_strings['unit_list']));
	$smarty->assign('dropdownLabelsRecurrenceJSON', $json->encode($app_list_strings['zeitbezug_list']));
	$smarty->assign('dropdownLabelsDiscountTypeJSON', $json->encode($app_list_strings['discount_select_list']));
	$smarty->assign('dropdownLabelsVatJSON', $json->encode($app_list_strings['oqc_vat_list']));
	$smarty->assign('dateFormat', $locale->getPrecedentPreference('default_date_format'));
	
	$smarty->assign('currencyJavascript', $currencyScript);
	$smarty->assign('currencySymbol', $currencySymbol);
	$smarty->assign('current_rate', $current_ratio);
	$smarty->assign('current_id', $current_id);
	
	$smarty->assign('languageStrings', $languageStrings);
	$smarty->assign('languageStringsJSON', $languageStringsJSON);
	$smarty->assign('sqsJavascript', $sqsJavascript);
	$smarty->assign('now', date($timedate->get_date_format()));
	$smarty->assign('contractId', $focus->id);
	$smarty->assign('initialFilter', '&is_option=0');
	$smarty->assign('encoded_request_data', $encoded_request_data);
	$smarty->assign('vat_default', $vat_default); // default VAT value -1.7.8 just for information
	$smarty->assign('StartDate', $focus->startdate);
	$smarty->assign('EndDate', $focus->enddate);

	// new for yui
	$smarty->assign('id', $focus->id);
	$smarty->assign('moduleName', $focus->object_name);

	return $smarty->fetch('include/oqc/Services/' . $view . '.html');
}

?>
