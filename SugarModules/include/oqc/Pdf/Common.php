<?php

require_once('include/dir_inc.php');
require_once('include/utils/sugar_file_utils.php');
require_once('include/oqc/common/Configuration.php');

$conf = Configuration::getInstance();
if (strtoupper(substr(php_uname('s'), 0, 3)) === 'WIN') {
	// if it windows we need redefine tmp directory, so it do not have spaces in paths since this breaks pdflatex 
    if(!file_exists("C:/Temp/pdflatex")){
		mkdir_recursive("C:/Temp/pdflatex", true);
		
		}
	 	define('TMP_DIR', "C:/Temp/pdflatex");
	 	define('SUGAR_INSTANCE', $conf->get('pathSugarCE'));	
	 	define('WINDOWS', true);
    }
    else {
		define('TMP_DIR', sys_get_temp_dir());
		define('SUGAR_INSTANCE', '');
		define('WINDOWS', false);
		 }

define('PDFLATEX', $conf->get('pathPdflatex'));
define('PDFTK', $conf->get('pathPdftk'));
define('CENTOS_PATCH', $conf->get('CentOSpatch'));
define('DEBUG_PDF_CREATION', $conf->get('debugPdfCreation'));
define('COMMAND_CANNOT_EXECUTE', 126);
define('COMMAND_NOT_FOUND', 127);
define('TEXTBLOCK_TMP_PREFIX', 'html2tex');
define('TEMPLATE_TMP_PREFIX', 'tpl');
// for WIN systems strange string with quotes works only; pdflatex accepts only / slash
if (strtoupper(substr(php_uname('s'), 0, 3)) === 'WIN') {
	define("LATEX_GRAPHICS_DIR", str_replace("\\", "/", '"'. getcwd() .'/include/oqc/Pdf/Graphics"/'));
	} else { define('LATEX_GRAPHICS_DIR', getcwd() . DIRECTORY_SEPARATOR . 'include/oqc/Pdf/Graphics/'); }
		
define("SUGAR_DIR", str_replace("\\", "/", '"'. getcwd() .'"'));

function getTemplatesPath($beanName) {
	$templates = array();
	switch ($beanName) {
		case "Contract" :
			$templates['TITLE_PAGE_TEMPLATE'] = 'include/oqc/Pdf/Contract/TitlePage.tpl';
			$templates['SERVICES_TEMPLATE'] = 'include/oqc/Pdf/Contract/Services.tpl';
			$templates['CONTRACT_TEMPLATE'] = 'include/oqc/Pdf/Contract/Contract.tpl';
			$templates['TEXTBLOCKS_TEMPLATE'] = 'include/oqc/Pdf/Contract/TextBlocksSkeleton.tpl';
			break;
		case "Offering" :
			$templates['TITLE_PAGE_TEMPLATE'] = 'include/oqc/Pdf/Offering/TitlePage.tpl';
			$templates['SERVICES_TEMPLATE'] = 'include/oqc/Pdf/Offering/Services.tpl';
			$templates['CONTRACT_TEMPLATE'] = 'include/oqc/Pdf/Offering/Offering.tpl';
			$templates['TEXTBLOCKS_TEMPLATE'] = 'include/oqc/Pdf/Offering/TextBlocksSkeleton.tpl';
			break;
		case "Offering2" :
			$templates['TITLE_PAGE_TEMPLATE'] = 'include/oqc/Pdf/Offering2/TitlePage.tpl';
			$templates['SERVICES_TEMPLATE'] = 'include/oqc/Pdf/Offering2/Services.tpl';
			$templates['CONTRACT_TEMPLATE'] = 'include/oqc/Pdf/Offering2/Offering.tpl';
			$templates['TEXTBLOCKS_TEMPLATE'] = 'include/oqc/Pdf/Offering2/TextBlocksSkeleton.tpl';
			break;	
		case "Addition" :
			$templates['TITLE_PAGE_TEMPLATE'] = 'include/oqc/Pdf/Addition/TitlePage.tpl';
			$templates['SERVICES_TEMPLATE'] = 'include/oqc/Pdf/Addition/Services.tpl';
			$templates['CONTRACT_TEMPLATE'] = 'include/oqc/Pdf/Addition/Addition.tpl';
			$templates['TEXTBLOCKS_TEMPLATE'] = 'include/oqc/Pdf/Addition/TextBlocksSkeleton.tpl';
			break;
		case "ProductCatalog" :
			$templates['PRODUCT_CATALOG_TEMPLATE'] = 'include/oqc/Pdf/ProductCatalog/ProductCatalog.tpl';
			break;
		case "ProductCatalog2" :
			$templates['PRODUCT_CATALOG_TEMPLATE'] = 'include/oqc/Pdf/ProductCatalog2/ProductCatalog.tpl';
			break;
		case "ProductCatalog3" :
			$templates['PRODUCT_CATALOG_TEMPLATE'] = 'include/oqc/Pdf/ProductCatalog3/ProductCatalog.tpl';
			break;
		case "ProductCatalog4" :
			$templates['PRODUCT_CATALOG_TEMPLATE'] = 'include/oqc/Pdf/ProductCatalog4/ProductCatalog.tpl';
			break;	
		default:
			break;	
		}
		
	
	
	//require_once('include/oqc/common/Configuration.php');
	//$conf = Configuration::getInstance();
	
	return $templates;
}
// ********Smarty resource functions for string processing
function oqc_string_get_template($tpl_name, &$tpl_source, &$smarty_obj) {
    $tpl_source = $tpl_name;
    return true;
}

function oqc_string_get_timestamp($tpl_name, &$tpl_timestamp, &$smarty_obj) {
    $tpl_timestamp = time();
    return true;
}

function oqc_string_get_secure($tpl_name, &$smarty_obj) {
    return true;
}

function oqc_string_get_trusted($tpl_name, &$smarty_obj) {}

//******** End of Smarty functions





function execute($app, $args = '', &$output = null) {
	//for Windows we need to construct exec in different way since spaces in cmd is not allowed (at least for winXP)
	if (strtoupper(substr(php_uname('s'), 0, 3)) === 'WIN') {
	$cmd = '"'.$app.'" '.$args ;
	
	}
	else {$cmd = $app . ' ' . $args ;}
	$GLOBALS['log']->error('Execute command '.$cmd);
	exec($cmd, $output, $returnValue);
	if ($returnValue !== 0) {
		$GLOBALS['log']->error('execute: ' . $app . ', return value is '.$returnValue);
		}

	return $returnValue;
}

function debugPdfCreation($filename) {
	$pdfLatexDir = dirname($filename);
	$pdfLatexArgs = '-interaction=nonstopmode -output-directory=' . $pdfLatexDir . ' ' . $filename . ' 2>&1';
	$pdfTestArgs = '-version';
	$returnTestValue = null;
	$consoleOutput = array();
	//try to use value from config file first
	$defaultPath = PDFLATEX;
	$found = '';
	$addString = '';
	$filenameWithoutExtension = str_replace("\\", "/", $pdfLatexDir . DIRECTORY_SEPARATOR . basename($filename, '.tmp')); 
	$pdfFilename = $filenameWithoutExtension . '.pdf';
	
	$returnTestValue = execute(PDFLATEX, $pdfTestArgs, $consoleOutput);
	if ($returnTestValue === 0) {
		$addString = "\npdflatex file is found at location entered in config file.\n";
		if (!empty($consoleOutput)) {
			$addString .= "pdflatex -version output: \n\r" . implode("\n",$consoleOutput)	;
		} else {
			$addString .= "\npdflatex -version output: null"; }
	} else {
		$addString = "\npdflatex executable is not found at default location, trying to find it at some other locations\n";
		$defaultPath = DIRECTORY_SEPARATOR .'usr'. DIRECTORY_SEPARATOR .'bin' .DIRECTORY_SEPARATOR .'pdflatex';
		$defaultTexName = 'pdflatex'; 
		if (strtoupper(substr(php_uname('s'), 0, 3)) === 'WIN') {
			$defaultTexName = 'pdflatex.exe'; 
			$defaultPath= 'C:/Program Files/MiKTeX 2.9/miktex/bin/pdflatex.exe';
		}
	 	elseif(strtoupper(substr(php_uname('s'), 0, 3)) === 'DAR') {
	 		$defaultPath = '/usr/texbin/pdflatex';
	 	}
	
		if (file_exists($defaultPath)) {
			//$addString .= "pdflatex file is found at location {$defaultPath} that is different to one in Your config file. Modify config file and re-run pdf creation\n";
			$found = $defaultPath;
		} else {
		//try more complicated search
			$apachePath = getenv('PATH');
			$addString .= "Trying paths in PATH variable: {$apachePath}\n";
			//$GLOBALS['log']->error('latexToPdf: $PATH variable is ' . getenv('PATH'));	
			$paths = explode(PATH_SEPARATOR, $apachePath);
			foreach($paths as $p) {
				$fullname = $p.DIRECTORY_SEPARATOR.$defaultTexName;
				$addString .= "Looking for pdflatex at: {$fullname}\n";
					//$GLOBALS['log']->error('latexToPdf: looking for pdflatex at ' . $fullname);	
				if(is_file($fullname)) {
    				$found = $fullname;
					break;
  				}
			}
		}
		if ($found) { //check if we found correct file
			$defaultPath = $found;
			$addString .= "pdflatex file is found at location {$defaultPath} that is different to one in Your config file. Modify config file and re-run pdf creation\n"; 
			$consoleOutput = array();
			$returnTestValue = execute($defaultPath, $pdfTestArgs, $consoleOutput);
			if (!empty($consoleOutput) && $returnTestValue === 0 ) {
				$addString .= "pdflatex -version output: \n" . implode("\n",$consoleOutput)	;
			} else {
				$addString .= "npdflatex -version output: null.\nThere still is problem with running of pdflatex; check file permissions.\n";
				sugar_file_put_contents($filename, $addString, FILE_APPEND | LOCK_EX);
				//Rewrite old log file
				rename($filename, $filenameWithoutExtension.'.log');
				return  $filenameWithoutExtension.'.log';
			}
		} else {
			$addString .= "Most likely You do not have pdflatex package installed\n";
			sugar_file_put_contents($filename, $addString, FILE_APPEND | LOCK_EX);
			//Rewrite old log file
			rename($filename, $filenameWithoutExtension.'.log');
			return  $filenameWithoutExtension.'.log';
		}
	}
	if (CENTOS_PATCH) {
		putenv('HOME=/tmp/'); 
	}
	$consoleOutput = array();
	$returnValue = execute($defaultPath, $pdfLatexArgs, $consoleOutput);
	if (!empty($consoleOutput)) {
		$addString .= "\n\rBELOW IS CONSOLE OUTPUT OF PDFLATEX RUN:\n\r". implode("\n",$consoleOutput)	;
	} else {
		$addString .= "\n\rConsole output is empty for some reason.";
	}
	if (file_exists($filenameWithoutExtension . '.log')) {
		$addString .= "\n\rBELOW IS LOG FILE OF PDFLATEX RUN: \n\r" . sugar_file_get_contents($filenameWithoutExtension . '.log');
	} else {
		$addString .= "\n\rLog file does not exists";
	}
	sugar_file_put_contents($filename, $addString, FILE_APPEND | LOCK_EX);
		//Rewrite old log file
	rename($filename, $filenameWithoutExtension.'.log');
	return  $filenameWithoutExtension.'.log';
}

function latexToPdf($filename, $count = 2) {
	
	if (DEBUG_PDF_CREATION) {
	$logFileName = debugPdfCreation($filename);
	return $logFileName;
	}
	$pdfLatexDir = dirname($filename);
	$pdfLatexArgs = '-interaction=batchmode -output-directory=' . $pdfLatexDir . ' ' . $filename;
	$pdfTestArgs = '-version';
	$returnTestValue = null;
	$filenameWithoutExtension = str_replace("\\", "/", $pdfLatexDir . DIRECTORY_SEPARATOR . basename($filename, '.tmp')); 
	$pdfFilename = $filenameWithoutExtension . '.pdf';
	$returnTestValue = execute(PDFLATEX, $pdfTestArgs);
	if ($returnTestValue === 0) {
		$GLOBALS['log']->error('latexToPdf: pdflatex executable file found at ' . PDFLATEX);
	} else {
		$GLOBALS['log']->error('latexToPdf: pdflatex executable file is not found. Set debugPdfCreation=1 in config file and re-run creation of file to get error log.');
		return null;
	}
	if (CENTOS_PATCH) {
		putenv('HOME=/tmp/'); 
	}
	// run pdflatex multiple times in order to correctly layout the longtable
	for ($i = 1; $i <= $count; $i++) {
		$returnValue = execute(PDFLATEX, $pdfLatexArgs);
		//$GLOBALS['log']->error('latexToPdf: $returnValue is: ' .$returnValue);
		if ($returnValue !== 0 && !file_exists($pdfFilename)) {
			break; //Do not run it next times if no pdf file was created
		}
	}
	if (! file_exists($pdfFilename)) {
		$GLOBALS['log']->error("Failed to create PDF! Set debugPdfCreation=1 in config file and re-run creation of file to get error log.");
		$pdfFilename = null;
	}
		
	// unlink pdflatex generated files
	if (file_exists($filenameWithoutExtension . '.aux')) {
	unlink($filenameWithoutExtension . '.aux');}
	if (file_exists($filenameWithoutExtension . '.log')) {
	unlink($filenameWithoutExtension . '.log');}
	if (file_exists($filenameWithoutExtension . '.toc')) {
	unlink($filenameWithoutExtension . '.toc'); }
	if (file_exists($filenameWithoutExtension . '.out')) {
	unlink($filenameWithoutExtension . '.out'); }
	if (file_exists($filename)) {
	unlink($filename); 
	} 
	return $pdfFilename;
}

function templateToLatex($templateFilename, $variables) {
	$smarty = new Sugar_Smarty;
	$smarty->left_delimiter = '<';
	$smarty->right_delimiter = '>';

	if (! $smarty->template_exists($templateFilename)) {
		$GLOBALS['log']->error('Failed to open smarty template ' . $templateFilename);
		return null;
		}

	// insert some translated labels into the variables array to make sure we can use translation in the latex templates
	if (!array_key_exists('language', $variables)) {
		global $app_list_strings;
		$variables['language'] = $app_list_strings['oqc'];

		// insert sugarcrm default langauge as well because we have to do some language specific includes in the latex templates
		global $sugar_config;
		$variables['default_language'] = $sugar_config['default_language']; 
	}


        require_once('include/oqc/common/Configuration.php');
	$conf = Configuration::getInstance();
	
	// add some company-specific data that might be useful in all latex templates
	$variables['pdfCompanyName']            = $conf->get('pdfCompanyName');
	$variables['pdfCompanyAddress']         = $conf->get('pdfCompanyAddress');
	$variables['pdfCompanyContactPhone']    = $conf->get('pdfCompanyContactPhone');
	$variables['pdfCompanyContactFax']      = $conf->get('pdfCompanyContactFax');
	$variables['pdfCompanyContactMail']     = $conf->get('pdfCompanyContactMail');
	$variables['pdfCompanyContactInternet'] = $conf->get('pdfCompanyContactInternet');
	$variables['pdfCopyrightNotice']        = $conf->get('pdfCopyrightNotice');
	//$GLOBALS['log']->error('Smarty variables: '. var_export($variables,true));		
	$smarty->assign($variables);
	$latex = $smarty->fetch($templateFilename);

	$latexFilename = tempnam(TMP_DIR, TEMPLATE_TMP_PREFIX);
	//$GLOBALS['log']->error('OQC: Temp directory name: '.TMP_DIR);
	// TODO: open_basedir restriction??
	if (! file_put_contents($latexFilename, $latex)) {
		return null;
		}
	
	return str_replace("\\","/",$latexFilename); //make sure only / will be ever used.
}

function templateToPdf($templateFilename, $variables, $count = 2) {
	$latexFilename = templateToLatex($templateFilename, $variables);
	$pdfFilename = latexToPdf($latexFilename, $count);
		
	
//	unlink($latexFilename);
	
	return $pdfFilename;
}

function getDocumentFilename($id) {
	global $sugar_config;
	//return clean_path(SUGAR_INSTANCE.$sugar_config['upload_dir'] . $id);
	return clean_path($sugar_config['upload_dir'] . $id);
}

function htmlToLatex($html) {
	if (empty($html)) {
		return $html; }
		
		
		$latex_output = '';
		$convertor = new oqc_HtmlToLatexConverter();
		$latex_output = $convertor->html2latex('<html><head></head><body>'.$html.'</body></html>'); // need to add head section for correct utf-8 handling
	return $latex_output;
}

function stringToLatex($html) {
	if (empty($html)) {
		return $html; }
		$latex_output = '';
		$convertor = new oqc_HtmlToLatexConverter();
		$latex_output = $convertor->html2latex_formattext($html); // just replaces symbols with LaTex commands
	return $latex_output;
}

function sanatizeBeanArrayForLatex($beanArray) {
	foreach ($beanArray as $key=>$value) {
			$output_string = '';
		if (is_string($value) && !empty($value)) {
			$output_string = sanatizeAccentsForLatex($value);
			// escape special Latex symbols
			//$GLOBALS['log']->error('Trying to sanitize string for Latex:'. var_export($value,true));	
			$output_string = str_replace("\\", '\textbackslash', $output_string); 
			$output_string = str_replace('_', '\_', $output_string);
			$output_string = str_replace('{', '\{', $output_string);
			$output_string = str_replace('}', '\}', $output_string);
			$output_string = str_replace('&', '\&', $output_string);
			$output_string = str_replace('$', '\$', $output_string);
			$output_string = str_replace('%', '\%', $output_string);
			$output_string = str_replace('#', '\#', $output_string);
			$output_string = str_replace('~', '\~{}', $output_string);
			$output_string = str_replace('^', '\^{}', $output_string);
			$output_string = str_replace('&', '\&', $output_string);
			$beanArray[$key] = $output_string;
		}
	}
	
	return $beanArray;
}

// This makes sure that accents are properly displayed in latex template and generated pdf file.
function sanatizeAccentsForLatex($string) {
	$string = str_replace('&#039;', '\'', $string);	// replace apostrophe
	$string = str_replace('´', '$\acute{}$', $string);// accent acute 1
	$string = str_replace('`', '\`{}', $string);		// accent acute 2
	return $string;
}

?>
