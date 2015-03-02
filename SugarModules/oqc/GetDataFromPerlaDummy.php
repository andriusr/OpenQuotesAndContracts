<?php
header("Content-type: application/json");

$contactsArray = array();

if(!defined('sugarEntry')) define('sugarEntry', true);

chdir("..");
require_once('include/entryPoint.php');
require_once('modules/Contacts/Contact.php');

// TODO only return names according to query parameter
$c = new Contact();

if (!empty($_REQUEST['q'])) {
	// TODO clean string to protect agains XSS
	$q = $_REQUEST['q'];
	
	$limit = 10;
	// TODO take other fields into account
	$where = "(contacts.first_name LIKE '$q%' OR contacts.last_name LIKE '$q%')";
	
	$list = $c->get_list("", $where, 0, $limit);
	$contactBeans = $list['list'];
	
	foreach ($contactBeans as $contact) {
		// $contactsArray[] = $contact->toArray();
		// reduced number of fields available in array to speedup JSON encoding.
		$contactsArray[] = array(
			'id' => $contact->id,
			'first_name' => $contact->first_name,
			'last_name' => $contact->last_name, 
		);
	}
}
require_once('include/utils.php');
$json = getJSONobj();
echo $json->encode(array('ResultSet'=>$contactsArray));

?>
