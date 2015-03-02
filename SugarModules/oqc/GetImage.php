<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
//require_once('include/entryPoint.php');
require_once('include/oqc/common/Configuration.php');
require_once('config.php'); // provides $sugar_config

if (empty($_GET['id'])) {
			echo 'No image';
			return; }
		 $conf = Configuration::getInstance();
		 $oqc_uploadDir = $conf->get('fileUploadDir');
		 $uploadDir = $oqc_uploadDir ? $oqc_uploadDir : $sugar_config['upload_dir'];
		 
		 $imageFilename = $uploadDir . $_GET['id'];
       echo file_get_contents($imageFilename);      

?>