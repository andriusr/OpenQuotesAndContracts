<?php
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
	header("Content-type: application/xhtml+xml");
} else {
	header("Content-type: text/xml");
}

require_once('../include/oqc/common/DirectoryPrinter.php');

$p = new DirectoryPrinter();

if (isset($_REQUEST['id'])) {
	$directory = $_REQUEST['id'];
	echo $p->getFilesInDirectoryAsXML($directory);
} 
else {
	echo $p->getFilesInDirectoryAsXML(0); // get subdirectories of root directory
}

?>
