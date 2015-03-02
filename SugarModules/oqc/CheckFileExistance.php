<?php
header("Content-type: application/json");

$fileExists = false;

if (array_key_exists('n', $_REQUEST)) {
	$name = $_REQUEST['n'];

	if (array_key_exists('id', $_REQUEST)) {
		$id = $_REQUEST['id'];

		if(!defined('sugarEntry')) define('sugarEntry', true);

		chdir("..");
		require_once('include/entryPoint.php');
		require_once('modules/oqc_ExternalContract/oqc_ExternalContract.php');

		$e = new oqc_ExternalContract();
			
		if ($e->retrieve($id)) {
			$normalizedName = trim($e->$name);
			
			if (empty($normalizedName)) {
				// if no file location has been set for this field we reply true
				// because returning false would generate a warning in all cases (with or without a file set).
				// thus, returning true in this case results in nothing being displayed.
				$fileExists = true; 
			} else {
				require_once('include/oqc/common/Configuration.php');
				$conf = Configuration::getInstance();
				$rootDir = $conf->get('storageDirectory');
				
				// note that we must not use the normalized name at this point because the filename could actually contain leading or trailing spaces.
				$fileExists = file_exists($rootDir . $e->$name);
			}
		}
	}
}

echo $fileExists ? 1 : 0;
?>
