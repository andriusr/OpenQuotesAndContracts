<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');
require_once('modules/oqc_TextBlock/oqc_TextBlock.php');
require_once('modules/oqc_EditedTextBlock/oqc_EditedTextBlock.php');

function getDefaultTextblocks() {
	$textblock = new oqc_TextBlock();
	return $textblock->get_list('', 'is_default=1');
}

function getSmartyTextblockArray($textblockArray) {
	$smartyTextblockArray = array();

	foreach ($textblockArray as $textblock) {
		$smartyTextblockArray[] = array(
			'id' => $textblock->id,
			'name' => $textblock->name,
			'description' => $textblock->description,
			// only try to access $textblock->textblock_id if $textblock is an instance of oqc_editedtextblock
			'textblock_id' => (oqc_EditedTextBlock::getFromId($textblock->id) != null && !empty($textblock->textblock_id)) ? $textblock->textblock_id : "",		
		);
	}

	return $smartyTextblockArray;
}

function getDefaultFormattedTextblocks() {
	$defaultTextblocks = getDefaultTextblocks();

	if ($defaultTextblocks) {
		return getSmartyTextblockArray($defaultTextblocks['list']);
	} else {
		return array();
	}
}

function getFreetext($freetextId) {
	$freetext = new oqc_EditedTextBlock();
	$freetext->retrieve($freetextId);
	return $freetext->description;
}

function getSingleTextBlock($id, $object_name) {
	$textBlock = new $object_name();
	$textBlock->retrieve($id);
	return $textBlock->description;
}

// return the referenced [edited] textblocks in correct order
function getTextblocks($textblockIds,$idoffreetextblock, $view) {
	
	global $app_list_strings;
	if (empty($textblockIds) && $view == 'DetailView') {
		return array();
		}
	
	$textblocks = array();
	if ($idoffreetextblock)  {
		if (!in_array($idoffreetextblock, $textblockIds)) {
		$freetext = new oqc_EditedTextBlock();
		$freetext->retrieve($idoffreetextblock);
		$textblocks[] = $freetext;
		}
		}
	if (!empty($textblockIds)) {
	foreach ($textblockIds as $id) {
		$textblock = new oqc_Textblock();
		$editedTextblock = new oqc_EditedTextBlock();

		if ($textblock->retrieve($id)) {
			$textblocks[] = $textblock;
		} else if ($editedTextblock->retrieve($id)) {
			$textblocks[] = $editedTextblock;
		}
	}
	}
	
	else {
//	$GLOBALS['log']->error("creating empty textblock");	
	$newTextblock = new oqc_EditedTextBlock();	
	$newTextblock->id = create_guid();
	$newTextblock->name = $app_list_strings["oqc"]["Textblocks"]["freeText"];
	$newTextblock->description = '';
	$textblocks[0] = $newTextblock;
	}

	return $textblocks;
}

function getTextblocksHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}

	global $app_list_strings;
	$sequenceArray = $focus->textblocksequence ? explode(' ', trim($focus->textblocksequence)) : array();
	$textblocks = getTextblocks($sequenceArray,$focus->idoffreetextblock, $view);
	$smartyTextblocksArray = getSmartyTextblockArray($textblocks);
	
	// setup the popup link
	$popupRequestData = array(
			'call_back_function' => 'handleTextblocksPopUpClosed',
			'formName' => 'EditView',
			'field_to_name_array' => array(
				'id' => 'id',
				'name' => 'name',
			),
	);
	$json = getJSONobj();
	$encodedRequestData = $json->encode($popupRequestData);
	//$encodedDefaultTextblocks = $json->encode($smartyDefaultTextblocks);
	$languageStrings = $json->encode($app_list_strings["oqc"]["Textblocks"]);
	//tinyMCE languege file detection
	$langDefault = 'en';
	$lang = substr($GLOBALS['current_language'], 0, 2);
   if(file_exists('include/oqc/tinymce/langs/'.$lang.'.js')) {
		$langDefault = $lang;
   }
   //directionality detection
	$directionality = SugarThemeRegistry::current()->directionality;
	$smarty = new Sugar_Smarty;
	$smarty->assign('languageStringsTextblocks', $languageStrings);
	$smarty->assign('textblocks', $smartyTextblocksArray);
	$smarty->assign('lang', $langDefault);
	$smarty->assign('initialFilter', '"&deleted=0"');
	$smarty->assign('encoded_request_data', $encodedRequestData);
	$smarty->assign('directionality', $directionality);

	return $smarty->fetch('include/oqc/Textblocks/' . $view . '.html');
}


function getSingleTextblockHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}
 	//tinyMCE languege file detection
 	$langDefault = 'en';
	$lang = substr($GLOBALS['current_language'], 0, 2);
   if(file_exists('include/oqc/tinymce/langs/'.$lang.'.js')) {
		$langDefault = $lang;
   }
   //directionality detection
   $directionality = SugarThemeRegistry::current()->directionality;
	$textblock = $focus->description;
	$smarty = new Sugar_Smarty;
	$smarty->assign('textblock', $textblock);
	$smarty->assign('lang', $langDefault);
	$smarty->assign('directionality', $directionality);
	return $smarty->fetch('include/oqc/Textblocks/' . $view . '_new.html');
}


?>
