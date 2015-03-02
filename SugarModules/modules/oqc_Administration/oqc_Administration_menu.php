<?php

$admin_option_defs=array();
$admin_option_defs['Administration']['oqc_configure']= array('oqc_Administration','LBL_OQC_TITLE','LBL_OQC_DESCRIPTION','./index.php?module=oqc_Administration&action=oqc_configure');
$admin_option_defs['Administration']['oqc_task_default_users']= array('oqc_Administration','LBL_OQC_CONFIG_USERS_TITLE','LBL_OQC_TASK_CONFIG_HINT','./index.php?module=oqc_Administration&action=oqc_TaskConfigure');
$admin_option_defs['Administration']['oqc_cleanup']= array('oqc_Administration','LBL_OQC_CLEAN_UP_TITLE','LBL_OQC_CLEAN_UP_HINT','./index.php?module=oqc_Administration&action=oqc_CleanUp');
$admin_group_header[]= array('LBL_OQC_HEADER','',false, $admin_option_defs, '');


?>