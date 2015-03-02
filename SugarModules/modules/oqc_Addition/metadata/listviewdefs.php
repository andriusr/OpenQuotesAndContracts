<?php
$module_name = 'oqc_Addition';
$OBJECT_NAME = 'OQC_ADDITION';
$listViewDefs = array (
$module_name =>
array (
  $OBJECT_NAME . '_NUMBER' => 
  array (
    'width' => '5',
    'label' => 'LBL_NUMBER',
    'link' => true,
    'default' => true,
  ),
  'NAME' => 
  array (
    'width' => '32',
    'label' => 'LBL_SUBJECT',
    'default' => true,
    'link' => true,
  ),
  'SVNUMBER' => 
  array (
    'width' => '10',
    'label' => 'LBL_SVNUMBER',
    'sortable' => false,
    'default' => true,
  ),
   'VERSION' => 
  array (
    'width' => '10',
    'label' => 'LBL_VERSION',
    'default' => true,
  ),
  'OFFICENUMBER' => 
  array (
    'width' => '10',
    'label' => 'LBL_OFFICENUMBER',
    'default' => false,
  ),
  'COMPANY' => 
  array (
    'width' => '10',
    'label' => 'LBL_COMPANY',
    'module' => 'Accounts',
    'id' => 'COMPANY_ID',
    'link' => true,
    'related_fields' => 
    array (
      0 => 'company_id',
    ),
    'default' => true,
  ),

  'CLIENTCONTACT' => 
  array (
    'width' => '10',
    'label' => 'LBL_CLIENTCONTACT',
    'module' => 'Contacts',
    'id' => 'CLIENTCONTACT_ID',
    'link' => true,
    'related_fields' => 
    array (
      0 => 'clientcontact_id',
    ),
    'default' => true,
  ),

  'STATUS' => 
  array (
    'width' => '10',
    'label' => 'LBL_STATUS',
    'default' => true,
  ),
  
  'DATE_MODIFIED' => array(
        'width' => '15', 
        'label' => 'LBL_DATE_MODIFIED',
        'default' => true,
        ),
  
  'ASSIGNED_USER_NAME' => array(
		'width' => '5', 
		'label' => 'LBL_LIST_ASSIGNED_USER',
		'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true
        ),
)
);
?>
