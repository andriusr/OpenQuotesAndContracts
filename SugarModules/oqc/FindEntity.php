<?php
session_start();
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
// chdir('..');
require_once('include/entryPoint.php');
require_once('data/SugarBean.php');
require_once('modules/Documents/Document.php');


function create_array($bean)
{
	$data = array();

	foreach ($bean->field_defs as $field_def) 
	{ 
      $fieldname = $field_def['name'];  
	  $data[] = array($fieldname => $bean->$fieldname);
	}
	
	return $data;
}

function toJSON($data)
{
	require_once('include/utils.php');	
	$json = getJSONobj();
	return $json->encode($data);	
}

function findEntity() 
{
	$document = new Document();
	// Dokument wiederfinden -> Todo: anhand der field_defs generisch suchen
	$result = $document->get_list('', 'document_name = "' . $_REQUEST['document_name'] . '"');

	return $result['list'][0];
}
header("Content-type: application/json");
echo(toJSON(create_array(findEntity())));

session_write_close();
?>
 