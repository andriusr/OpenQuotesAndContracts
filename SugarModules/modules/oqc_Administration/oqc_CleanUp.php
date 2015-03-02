<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
global $timedate;

if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_ID'], $mod_strings['LBL_CLEANUP_NAME'].": ".$mod_strings['LBL_CLEANUP_TITLE'], true);
echo "\n</p>\n";

$smarty = new Sugar_Smarty;

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

//Calculate time & date formatting (may need to calculate this depending on a setting)
       

        $smarty->assign('CALENDAR_DATEFORMAT', $timedate->get_cal_date_format());
        $smarty->assign('USER_DATEFORMAT', $timedate->get_user_date_format());
        $time_format = $timedate->get_user_time_format();
       $smarty->assign('TIME_FORMAT', $time_format);

        $date_format = $timedate->get_cal_date_format();
        $time_separator = ':';
        if (preg_match('/\d+([^\d])\d+([^\d]*)/s', $time_format, $match))
        {
            $time_separator = $match[1];
        }

        // Create Smarty variables for the Calendar picker widget
        $t23 = strpos($time_format, '23') !== false ? '%H' : '%I';
        if (!isset($match[2]) || $match[2] == '')
        {
           $smarty->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . '%M');
        }
        else
        {
            $pm = $match[2] == 'pm' ? '%P' : '%p';
            $smarty->assign('CALENDAR_FORMAT', $date_format . ' ' . $t23 . $time_separator . '%M' . $pm);
        }

        $smarty->assign('CALENDAR_FDOW', $current_user->get_first_day_of_week());
        $smarty->assign('TIME_SEPARATOR', $time_separator);
        
        $presetDate = $timedate->asUserDate($timedate->getNow()->get("-3 months"));
        $smarty->assign('PRESET_DATE', $presetDate);


//Versioned modules list; records of other modules can be removed in "normal" way
$module_list = array(
	'OQC_PRODUCT' => $app_list_strings["moduleList"]["oqc_Product"],
	'OQC_OFFERING' => $app_list_strings["moduleList"]["oqc_Offering"],
	'OQC_CONTRACT' => $app_list_strings["moduleList"]["oqc_Contract"],
	'OQC_EXTERNALCONTRACT' => $app_list_strings["moduleList"]["oqc_ExternalContract"],
);
$oqc_bean_list = array(
	'OQC_PRODUCT' => "oqc_Product",
	'OQC_OFFERING' => "oqc_Offering",
	'OQC_CONTRACT' => "oqc_Contract",
	'OQC_EXTERNALCONTRACT' => "oqc_ExternalContract",
);

$smarty->assign('MODULE_LIST', $module_list);
$smarty->assign('BEAN_LIST', $oqc_bean_list);


$outputString = $smarty->fetch('modules/oqc_Administration/oqc_CleanUp.html');
echo $outputString ;  

  
?>
