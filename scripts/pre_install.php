<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/dir_inc.php');
require_once('include/utils/sugar_file_utils.php');

function oqc_cleanup($dir) {
	foreach(glob($dir . '/*') as $file) {
        if (is_dir($file)) {
            oqc_cleanup($file);}
        else {
        		if (substr(basename($file), 0, 3) == 'oqc') {
            unlink($file);}
    	  }
	}
}

function pre_install() {
    
//2.1 remove legacy layout and vardefs files from custom/Extension/modules that are 'forgotten' by uninstaller 
$file_list = array( 
	'Accounts',
	'Contacts',
	'Documents',
	'Opportunities',
	'Project',
	);
$dir = 'custom/Extension/modules/';
foreach ($file_list as $file) {
	if ( file_exists( $dir.$file.'/Ext/Layoutdefs/'.$file.'.php')) {
		unlink( $dir.$file.'/Ext/Layoutdefs/'.$file.'.php' );}
		
	if ( file_exists( $dir.$file.'/Ext/Vardefs/'.$file.'.php')) {
		unlink( $dir.$file.'/Ext/Vardefs/'.$file.'.php' );}
}

// Now cleanup all files in custom/Extension/ that have filename start with oqc 
	$custom_dir = 'custom/Extension';
	//$GLOBALS['log']->error("Custom directory structure is ". var_export(glob($custom_dir.'/*'),true)); 
	if (is_dir($custom_dir)) {
		oqc_cleanup($custom_dir);
    }

// This is the hack to make oqc_CreatePopup available for non-admin users
// Required for button Create Attachement to work in Quotes and Contracts
//TODO Make oqc_Create_popup work without this hack

$str = "<?php \n //WARNING: The contents of this file are auto-generated\n";
$str .= "\$modules_exempt_from_availability_check['oqc_CreatePopup'] = 'oqc_CreatePopup';\n";
$str .= "\$modInvisList[] = 'oqc_CreatePopup';\n";
$str.= "\n?>";
	if(!file_exists("custom/Extension/application/Ext/Include")){
						mkdir_recursive("custom/Extension/application/Ext/Include", true);
					}
	if(file_exists("custom/Extension/application/Ext/Include/oqc_CreatePopup.php")){
						unlink("custom/Extension/application/Ext/Include/oqc_CreatePopup.php");
					}				
$out = sugar_fopen("custom/Extension/application/Ext/Include/oqc_CreatePopup.php", 'w');
fwrite($out,$str);
fclose($out);
	

}
?>
