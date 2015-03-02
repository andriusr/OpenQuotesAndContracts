<?php
// NOTE post_uninstall needs to be not function and it MUST be included into manifest file
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


function oqc_rmdir($dir) {
    foreach(glob($dir . '/*') as $file) {
        if (is_dir($file)) {
            oqc_rmdir($file);}
        else {
            unlink($file);}
    }
    rmdir($dir);
}

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

//2.1 include/oqc durectory not removed, probably because there are some extra files 
// include/oqc is place for all kinds of custom/extra template files that might not uninstall properly...

	$dir = 'include/oqc';
	//$GLOBALS['log']->error("Directory exists? ". var_export(is_dir($dir),true)); 
	if (is_dir($dir)) {
		oqc_rmdir($dir);
    }
    
// Now cleanup all files in custom/Extension/ that have filename start with oqc 
	$custom_dir = 'custom/Extension';
	//$GLOBALS['log']->error("Custom directory structure is ". var_export(glob($custom_dir.'/*'),true)); 
	if (is_dir($custom_dir)) {
		oqc_cleanup($custom_dir);
    }
    
?>
