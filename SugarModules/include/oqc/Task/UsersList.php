<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');
require_once('include/oqc/Task/TaskServer.php');

function getUsersListHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}
 	

   global $app_list_strings;
   global $mod_strings;
   global $current_user;
   
   if (isset($_GET['parent_type']) && isset($_GET['parent_id']) ) {
   //We have creation of Task from Products, Quotes, Contract or Addition
   //Add to the participants users from Products etc if parent_id is available. 	
   $module_name = $_GET['parent_type'];	
	$parent_id = $_GET['parent_id'];
	} else {
	$module_name = 'oqc_Task';
	$parent_id = '';	

	}
	$users_list_data = array();
	$allowRowEdit = false;
	$json_server = new oqc_json_server();
	$users_data_array = $json_server->get_oqc_task_data($focus->id, $view, $module_name, $parent_id, true);
	$users_string = $users_data_array[0];
	$users_list_data = $users_data_array[1];
	// Configure UserEdit and RowEdit variables
	//$GLOBALS['log']->error('Users_data: attaching '. var_export($users_list_data,true));
	if (count($users_list_data) > 0) {
		foreach ($users_list_data as $user_data) {
			if ($current_user->id == $user_data['User_id']) {
				$allowRowEdit = true;
			}
		
		}
	}
	$allowUserEdit = ($focus->created_by == $current_user->id) || ($focus->assigned_user_id == $current_user->id) || is_admin($current_user) ? true : false;
	
	
   $smarty = new Sugar_Smarty;
  
	// setup the popup link
	$user_popup_request_data = array(
		'call_back_function' => 'OqcTask.handleUserPopUpClosed',
		'formName' => 'EditView',
		'field_to_name_array' => array(
			"id" => "user_id",
			"user_name" => "user_name",
			"name" => "name",
		),
		'passthru_data' => array(
			
		), 	
	);
	
	$document_popup_request_data = array(

			'call_back_function' => 'OqcTask.handleDocumentPopUpClosed',
			'formName' => 'EditView',
			'field_to_name_array' => array(
				"id" => "document_id",
				"document_name" => "document_name",
				"document_revision_id" => "document_revision_id",
				"category_id" => "document_category_id",
				"revision" => "revision",
	        ),
			'passthru_data' => array(
	      ),
		);
	
	
	$json = getJSONobj();
	$encoded_user_request_data = $json->encode($user_popup_request_data);
	$encoded_document_request_data = $json->encode($document_popup_request_data);
	
        // $_GLOBALS['log']->fatal("asasdasd " . $languageStrings['totalNegotiatedPrice']);

	global $timedate;
	global $locale;
	global $app_strings;
	$oqcYUI = array();
	$oqcYUI['LBL_NO_RECORDS_MESSAGE'] = $app_strings['LBL_NO_RECORDS_MESSAGE'];
	$oqcYUI['LBL_DATA_ERROR_MESSAGE'] = $app_strings['LBL_DATA_ERROR_MESSAGE'];
	$oqcYUI['LBL_LOADING_MESSAGE'] = $app_strings['LBL_LOADING_MESSAGE'];
	$oqcYUIjson = $json->encode($oqcYUI);
	$smarty->assign('oqcYUIMessages', $oqcYUIjson);
	
	

	$smarty->assign("MOD", $mod_strings);
	$smarty->assign('OQC_DATA', $users_string);
	$smarty->assign('allowUserEdit', $allowUserEdit);
	$smarty->assign('allowRowEdit', $allowRowEdit);
	$smarty->assign('isDone', $focus->isdone ? true : false);
	$smarty->assign('dropdownLabelsProgressJSON', $json->encode($app_list_strings['oqc_task_user_status_list']));
	$smarty->assign('dropdownLabelsResolutionJSON', $json->encode($app_list_strings['oqc_task_resolution_list']));
	$smarty->assign('dropdownLabelsAcceptedJSON', $json->encode($app_list_strings['oqc_task_accepted_list']));
	$smarty->assign('dateFormat', $locale->getPrecedentPreference('default_date_format'));
	$smarty->assign('encodedDocumentRequestData', $encoded_document_request_data);
	$smarty->assign('encodedUserRequestData', $encoded_user_request_data);
	$smarty->assign('user_id', $current_user->id);
	$smarty->assign('moduleName', $focus->object_name);

	return $smarty->fetch('include/oqc/Task/' . $view . '.html');
}

?>
