<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/dir_inc.php');

function post_install() {
 
	// create directory for external contract pdf files
	
	$externalContractsPdfDir = "{$GLOBALS['sugar_config']['cache_dir']}/modules/Emails/attachments/";

	mkdir_recursive($externalContractsPdfDir);
	
	if (file_exists($externalContractsPdfDir)) {
		$GLOBALS['log']->debug("Successfully created directory '$externalContractsPdfDir'");
	} else {
		$GLOBALS['log']->fatal("Could not create directory for creation of pdf files: '$externalContractsPdfDir'");
	}
	
	global $sugar_config;
	global $sugar_version;
	
	$module_list =array( 
		'oqc_TextBlock',
		'oqc_Offering',
		'oqc_Product',
		'oqc_Contract',
		'oqc_ExternalContract',
		'oqc_ProductCatalog',
		'oqc_Addition',
		'oqc_Task'
		);

	// Add banning of AjaxUI for openqc modules 

	require_once('modules/Configurator/Configurator.php');

        $cfg = new Configurator();
        $overrideArray = $cfg->readOverride();
        if(array_key_exists('addAjaxBannedModules',$overrideArray)) {
        $disabled_modules = $overrideArray['addAjaxBannedModules'];
        $updatedArray = array_merge($disabled_modules, array_diff($module_list, $disabled_modules));}
        else { $updatedArray = $module_list;}
        $cfg->config['addAjaxBannedModules'] = empty($updatedArray) ? FALSE : $updatedArray;
        $cfg->handleOverride();

	// Configure documents.properties file depending on OS. There is three choices atm 
	//1. Default- Linux (OpenSuse, Ubuntu); 2. WinXP; 3. MACOSX
	$oqc_config_directory = 'include/oqc/conf/';
	if (strtoupper(substr(php_uname('s'), 0, 3)) === 'WIN') {

	if (file_exists($oqc_config_directory.'documents_linux.properties')) {
		unlink( $oqc_config_directory.'documents_linux.properties');}
   rename($oqc_config_directory.'documents.properties',$oqc_config_directory.'documents_linux.properties');
   rename($oqc_config_directory.'documents_windows.properties', $oqc_config_directory.'documents.properties');
   }
   elseif(strtoupper(substr(php_uname('s'), 0, 3)) === 'DAR') {
   	
   		if (file_exists($oqc_config_directory.'documents_linux.properties')) {
			unlink( $oqc_config_directory.'documents_linux.properties');}
   rename($oqc_config_directory.'documents.properties',$oqc_config_directory.'documents_linux.properties');
   rename($oqc_config_directory.'documents_macosx.properties', $oqc_config_directory.'documents.properties');
   }
   	
   //Do some sanity checks before installing scheduler file if sugar version is lower than 6.3
   if(floatval(substr($sugar_version,0,3)) < 6.3) {
   	$scheduler_directory = 'custom/modules/Schedulers/';
   	if (file_exists($scheduler_directory.'_AddJobsHere.php')) {
   		//rename existing file; User can merge oqc file with original one manually
   		if (file_exists($scheduler_directory.'_AddJobsHere_original.php')) {
   			unlink($scheduler_directory.'_AddJobsHere_original.php');}
   		rename($scheduler_directory.'_AddJobsHere.php',$scheduler_directory.'_AddJobsHere_original.php');
   		}
      rename($scheduler_directory.'oqc_AddJobsHere.php', $scheduler_directory.'_AddJobsHere.php');
  
	}
	// Rebuild Roles after install
	
	require_once('modules/ACL/install_actions.php');
	
	//Last, Do a Quick Repair & Rebuild
	$module = array('All Modules');
	$selected_actions = array('clearAll');
	require_once ('modules/Administration/QuickRepairAndRebuild.php');
	$randc = new RepairAndClear ();
	$randc->repairAndClearAll ($selected_actions, $module, false, false);	
	
}
?>
