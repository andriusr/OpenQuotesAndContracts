<?php
/* 
 * do currency formatting on service side assuming server is much faster than clients
 * this does not add the currency symbol
 * the following code is similiar to formatting code in javascript, see localizedCurrencyValidator in Services.js
 */ 
function getFormattedCurrencyValue($currencyFloat) {
	// get decimal separator character first
	require_once('modules/Currencies/Currency.php');
	// get decimal separator because we want to deliver a properly formatted currency value to the user
	// for the following to work make sure the default_decimal_separator setting is correct (in config.php and config_override.php. administrators can set the defaults of config_override.php in the locale settings of sugarcrm.
	$sep = get_number_seperators();
	$decimalSeparator = $sep[1];
	
	// got decimal separator. now do actual formatting.
	$currencyString = strval($currencyFloat);
		
	if (false !== ($pos=strpos($currencyString, '.'))) {
		// update "1.23" to "1,23" (if , is decimal separator)
		$secondPart = substr($currencyString, $pos+1);

		if (1 === strlen($secondPart)) {
			$secondPart .= '0';
		} else if (2 < strlen($secondPart)) {
			$secondPart = substr($secondPart, 0, 2);
		}

		return substr($currencyString, 0, $pos) . $decimalSeparator . $secondPart;
	} else {
		// update "1" to "1,00" (if , is decimal separator)
		return $currencyString . $decimalSeparator . "00";
	}
}

/*
 * this method converts a given currency symbol into the latex equivalent. see formatCurrencyForSmartyLatex.
 */
function currencySymbolToLatexEquivalent($currencySymbol) {
	global $sugar_config;
	
	$latexSymbols = array(
		$sugar_config['default_currencies']['EUR']['symbol'] => '\\euro', // euro 
		$sugar_config['default_currencies']['USD']['symbol'] => '\\$', // us|australian|canadian|hong kong|singaporean dollar and mexican pesos MXM
		$sugar_config['default_currencies']['BRL']['symbol'] => 'R\\$', // brazilian reais BRL
		$sugar_config['default_currencies']['GBP']['symbol'] => '\\pounds', // british pound
		$sugar_config['default_currencies']['KRW']['symbol'] => '\\textwon', // korean won KRW
		$sugar_config['default_currencies']['THB']['symbol'] => '\\textbaht', // thai baht THB    
		$sugar_config['default_currencies']['YEN']['symbol'] => '\\textyen', // japanese yen JPY
		$sugar_config['default_currencies']['CNY']['symbol'] => '\\textyen', // chinese yuan CNY. TODO this is not identically with the japanese yen but latex does not provide a yuan sign so we fallback to yen because the look almost the same.
        $sugar_config['default_currencies']['INR']['symbol'] => 'Rs', // indian rupees INR. TODO should be translated to the unicode character for the currency.
		$sugar_config['default_currencies']['CHF']['symbol'] => 'SFr.', // swiss franc CHF.       
	);
	
	if (array_key_exists($currencySymbol, $latexSymbols)) {
		// yes we have a latex translation for this currency. use this latex translation in the template instead of the unicode character.
		return $latexSymbols[$currencySymbol]; 
	} else {
		// we do not have a latex translation for currency symbol.
		$GLOBALS['log']->warn("currencySymbolToLatexEquivalent: there is no latex translation for your currency '$currencySymbol'. we cannot replace the unicode representation of the symbol with a latex equivalent. this could destroy the layout in the generated pdf file.");
		return false;
	}
}

/*
 * this method is required for the pdf generation process (see #387). we used to display prices and costs directly in latex templates with the help
 * of sugarcrms smarty function {sugar_currency_format} which calls smarty_function_sugar_currency_format. smarty_function_sugar_currency_format
 * works very well for rendering the user interface in the browser. however, if we use this during pdf generation, the layout of the
 * generated pdf file can be destroyed because latex really does not like characters like $ within the text. other currency symbols have a
 * similiar effect. so we replace them with the appropriate latex codes to avoid problems.
 * 
 * this requires the latex package textcomp.
 * 
 * additionally in the latex templates you should not use the {sugar_currency_format} functions. instead convert the values of prices/costs
 * using this method and insert them directly into the template like {$yourPriceVariable}. since we still call the sugarcrm implementation
 * for formatting the currency value your locale settings for currencies are still applied.
 * 
 * attribute $withCurrencySymbol:
 * 	true: 	return formatted currency value with currency symbol at the front
 * 	false:	return formatted currency value without currency symbol at the front 
 */
function formatCurrencyForSmartyLatex($value, $withCurrencySymbol=true) {
	require_once('include/Smarty/plugins/function.sugar_currency_format.php');
	
	$smartyDummyRef = 0; // only to avoid that smarty_function_sugar_currency_format throws a warning because second parameter is missing
	$formattedCurrency = smarty_function_sugar_currency_format(
		array(
			'var' => $value,
			'round' => true,
			'decimals' => 2,
		),
		$smartyDummyRef // provide a dummy reference to smarty_function_sugar_currency_format to avoid php throwing a warning
	);

	if (empty($formattedCurrency)) {
		return ''; // seems like value was 0. the price has been formatted to an empty string. this should be handled in the template seperately.
	}
	
	if (!preg_match('/^(.*?)([\d\,\.]+)$/', $formattedCurrency, $match)) {
		// could not determine the currency symbol from the formatted currency value. return already formatted value that maybe destroys pdf layout.
		$GLOBALS['log']->warn('formatCurrencyForSmartyLatex: could not  determine the currency symbol. will use price value already formatted by sugarcrm that could destroy pdf layout.');
		return $formattedCurrency;
	} else if (3 > count($match)) {
		// the regular expression matched but the match array does not contain enough elements.
		// we need the 2nd and 3rd elements of $match to access the extracted currency symbol and price value
		$GLOBALS['log']->warn("formatCurrencyForSmartyLatex: not enough elements in match array. cannot access currency symbol in formatted currency value '$formattedCurrency'. falling back to already formatted value. this could destroy pdf layout.");
		return $formattedCurrency;
	} else {
		// currency symbol has been extracted successfully and $match array contains at least three elements so. we can make sure that we can access $match[2].
		
		$currencySymbol = $match[1]; // extract the currency symbol. we assume that it is the first character in the formatted currency
		$priceWithoutCurrencySymbol = $match[2]; // extract formatted currency without the currency symbol
		
		if ($withCurrencySymbol) {
			$latexCurrencySymbol = currencySymbolToLatexEquivalent($currencySymbol);
			
			if ($latexCurrencySymbol) {
				// yes we have a latex translation for this currency. use this latex translation in the template instead of the unicode character.
				return $latexCurrencySymbol . $priceWithoutCurrencySymbol; 
			} else {
				// since we do not have a latex translation for this currency symbol we have to use the original sugarcrm formatted currency that maybe destroys the pdf formatting.
				return $formattedCurrency;
			}
		} else {
			return $priceWithoutCurrencySymbol; 
		}
	}
}

function truncateAtWordBoundaries($str, $maxLength) {
	if ($maxLength > strlen($str)) {
		return $str;
	}
	
	$truncated = '';
	$words = preg_split("/\s+/", $str);
	
	foreach ($words as $word) {
		$truncated .= "$word ";
		if (strlen($truncated) > $maxLength) {
			return $truncated;
		}
	}
	
	return trim($truncated);
}

function getSugarConfig($key) {
        global $sugar_config;
        return $sugar_config[$key];
}

function getSugarCrmLocale($localeName) {
        global $locale;
        return $locale->getPrecedentPreference($localeName);
}

function getLanguageStringsPHP($key) {
        global $app_list_strings;
        return $app_list_strings["oqc"][$key];
}

function getLanguageStrings($key) {
        global $app_list_strings;
        $json = getJSONobj();
        return $json->encode($app_list_strings["oqc"][$key]);
}

// replaces special characters in a given string with their html counterpart
// TODO we should use return htmlspecialchars(utf8_decode($string)); for this instead. but using htmlspecialchars replaces some things like
// TODO " -> &quot; and & -> $amp; which will not be displayed properly (rendered) in the created pdf-files. so at the moment we only handle
// TODO umlaute and ignore the rest using this crap-code.
function replaceSpecialCharactersWithHtml($string) {
	// TODO make sure that has to be created only once
	$specialCharacterToHtml = array(
		"ä" => "&auml;",
		"ü" => "&uuml;",
		"ö" => "&ouml;",
		"Ä" => "&Auml;",
		"Ü" => "&Uuml;",
		"Ö" => "&Ouml;",
		"ß" => "&szlig;",
	);	
	
	foreach ($specialCharacterToHtml as $special => $html) {
		$string = preg_replace("/$special/", $html, $string);
	}
	
	return $string;
}


function getCurrentModuleName() {
	if (isset($_GET['module'])) {
		return $_GET['module'];
	} else if (isset($_POST['module'])) {
		return $_POST['module'];
	} else {
		// TODO raise exception
		// falling back to default module
		return 'oqc_Contract';
	}
}

// transform the date/datetime attributes of the bean to make it possible to save twice
// if you do not do that sugarcrm will set your date values to 1.1.2000 after saving twice
function prepareDateAttributesForSave($bean) {
	if (!is_subclass_of($bean, 'SugarBean')) {
		$GLOBALS['log']->warn('prepareDateAttributesForSave: \$bean is not an instance of SugarBean-class');
		return NULL; // do nothing if this is not a sugarbean instance
	}
	
	global $timedate;
	
	if (!isset($timedate)) {
		$GLOBALS['log']->warn('prepareDateAttributesForSave: cannot access \$timedate variable');
		return NULL;	
	}
	
	foreach ($bean->field_defs as $def) {
		$type = $def['type'];
		$name = $def['name'];
		
		if (!empty($bean->$name)) {
			if ('date' === $type) {
				$bean->$name = $timedate->to_display_date($bean->$name);
			} else if ('datetime' === $type) {
				$bean->$name = $timedate->to_display_date_time($bean->$name);
			}
		}
	}
	
	return $bean;
}

function hasBeenModified($bean, $ignoredFields) {
	if (array_key_exists('isModified', $_REQUEST) && $_REQUEST['isModified'] === 'true') {
		return true; // if isModified flag is set to true we the js code found out that there has been a modification of the custom fields
	}
	global $locale;
	$dateFormat = $locale->getPrecedentPreference('default_date_format');
        if (empty($bean->fetched_row)) { // fetched_row is undefined if we create a new bean. we cannot execute the loop if fetched_row is undefined..
            return true; // return true to indicate that bean has modified to force save.
        }
	foreach ($bean->fetched_row as $key => $value) {
		if (!in_array($key, $ignoredFields) && array_key_exists($key, $_REQUEST)) {
			if ('date' === $bean->field_defs[$key]['type']) {
				// to compare dates, generate timestamps from the datestrings and format them the same way using sugarcrms default date format
				$a = date($dateFormat, strtotime($value));
				$b = date($dateFormat, strtotime($_REQUEST[$key]));
					
				if ($a != $b) {
					// if the formatted strings are not the same, we should have a modification
					return true;
				}
			} else if ('multienum' === $bean->field_defs[$key]['type']) {
				$a = explode('^,^', $value); sort($a);
				$b = $_REQUEST[$key]; sort($b);
				if ($a != $b) {
					return true;
				}
			} else if ($_REQUEST[$key] != $value) {
				return true; // we found a modification
			}
		}
	}
	return false; // no modification has been detected. 
}

?>
