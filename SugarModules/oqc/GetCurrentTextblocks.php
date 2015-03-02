<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
require_once('include/entryPoint.php');
require_once('modules/oqc_TextBlock/oqc_TextBlock.php');

$textblock = new oqc_TextBlock();
$a = $textblock->get_list('', 'is_default=1');
$a = $a['list'];
$json = getJSONobj();

$b = array();

foreach ($a as $textblock) {
	$b[] = array(
		"id" => $textblock->id,
		"title" => $textblock->name,
		"description" => $textblock->description,
	);
}

$encoded = $json->encode($b);

echo($encoded);

?>