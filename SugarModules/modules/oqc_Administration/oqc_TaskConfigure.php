<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/oqc_Task/oqc_Task.php');
require_once('modules/oqc_Task/Forms.php');
require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;


if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

$mod_id = "";
$mod_name = "";
if(isset($mod_strings['LBL_MODULE_ID'])) {
	$mod_id = $mod_strings['LBL_MODULE_ID'];
}
if(isset($mod_strings['LBL_MODULE_NAME'])) {
	$mod_name = $mod_strings['LBL_MODULE_NAME'];
}
echo "\n<p>\n";
echo get_module_title($mod_id, $mod_name.": ".$mod_strings['LBL_TASK_CONFIGURE'], true);
echo "\n</p>\n";

$json = getJSONobj();
$smarty = new Sugar_Smarty;

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

$languageStrings = array( 
						"delete" => $mod_strings["LBL_DELETE_HEADER"],
						"addUser" => $mod_strings["LBL_ADD_USER"],
						);
$languageStringsJSON = $json->encode($languageStrings);


$task = new oqc_Task();
$modules_list= $app_list_strings["oqc_parent_type_display_list"];
$defaultUsersBeans = $task->getDefaultUsers();
$module_array= $task->fill_defaultUsersArray($defaultUsersBeans, $modules_list);
$modules_dropdown= $app_list_strings["oqc_parent_type_display_list"];
$modules_dropdownJSON = $json->encode($app_list_strings["oqc_parent_type_display_list"]);
//$GLOBALS['log']->error("Module Array: ". var_export($module_array, true));
$smarty->assign('moduleArray', $module_array);

// setup the popup link
	$user_popup_request_data = array(
		'call_back_function' => 'popup_return_user',
		'formName' => 'EditView',
		'field_to_name_array' => array(
			"id" => "user_id",
			"user_name" => "user_name",
			"name" => "name",
		),
		'passthru_data' => array(),		
	);

$encoded_request_data = $json->encode($user_popup_request_data);

$modules_dropdownJSON = $json->encode($app_list_strings["oqc_parent_type_display_list"]);
$smarty->assign('modulesDropdown', $modules_dropdownJSON);
$smarty->assign('languageStrings', $languageStringsJSON);
$smarty->assign('initialFilter', "\"&status=Active\""); 
$smarty->assign('users_popup_encoded_request_data', $encoded_request_data); 


$outputString = $smarty->fetch('modules/oqc_Administration/oqc_TaskConfigure.html');
echo $outputString ;  

  
?>
