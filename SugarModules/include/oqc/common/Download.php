<?php
if (false !== strpos($_REQUEST['f'], "..")) {
	die("Ignoring request since _REQUEST[f] contains dots '..'.");
}

// TODO protect this file from being accessed without being logged in
// if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*if(empty($_REQUEST['id']) || empty($_REQUEST['type']) || !isset($_SESSION['authenticated_user_id'])) {
	die("Not a Valid Entry Point");
}*/

function isFileReadable($filename) {
	$handle = 0;

	// TODO avoid that php prints out a big fat warning: permission denied. (try catch does not work)
	if (FALSE === ($handle = fopen($filename, 'r'))) {
		return false;
	}
	
	fclose($handle);
	return true;
}

ini_set('zlib.output_compression','Off');

require_once('Configuration.php');
$conf = Configuration::getInstance();
$rootDir = $conf->get('storageDirectory');

$localLocation = $rootDir . '/' . $_REQUEST['f'];

if(!file_exists($localLocation) || strpos($localLocation, "..")) {
	die("File '$localLocation' not found.");
}

if (!isFileReadable($localLocation)) {
	die("File '$localLocation' is not readable. Check file permissions.");
}

$name = substr($localLocation, 1+strrpos($localLocation, '/'));
$size = filesize($localLocation);
$fileContent = file_get_contents($localLocation);

$contentType = "";

if (function_exists("finfo_open")) {
 	// FileInfo API by default
	$finfo = finfo_open(FILEINFO_MIME);

	// TODO how to guarantee that this was successful?
	if (FALSE === ($contentType = finfo_file($finfo, $localLocation))) {
		die("Cannot download file ${$localLocation} because content type cannot be determined. Please install the php extension FileInfo 'pecl install FileInfo' (requires libmagic-dev, php5-dev)");		
	}
} else if (function_exists("mime_content_type")) {
	$contentType = mime_content_type($localLocation); // TODO using deprecated mime_content_type until php 5.3 is stable and we can use fileinfo instead
} else {
	die("Cannot download file because content type cannot be determined. Please install the php extension FileInfo 'pecl install FileInfo' (requires libmagic-dev, php5-dev)");
}

header("Pragma: public");
header("Cache-Control: maxage=1, post-check=0, pre-check=0");
header("Content-type: $contentType");
header("Content-Length: $size");
header("Content-disposition: attachment; filename=\"".$name."\";");
header("Expires: 0");
set_time_limit(0);

@ob_end_clean();
ob_start();
echo file_get_contents($localLocation);
@ob_flush();
?>