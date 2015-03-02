Running pre_uninstall...
<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


//2.1 include/oqc durectory not removed, probably because of this extra file

function pre_uninstall() {

	$oqc_config_directory = 'include/oqc/conf/';
	if (file_exists($oqc_config_directory.'documents_linux.properties')) {
		unlink( $oqc_config_directory.'documents_linux.properties');}
 
}


?>
