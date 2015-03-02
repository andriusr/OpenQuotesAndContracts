<?php
$module_name = 'oqc_Offering';
$OBJECT_NAME = 'OQC_OFFERING';
$listViewDefs = array (
$module_name =>
array (
	'NAME' => 
 	 array (
    	'width' => '20',
   	 'label' => 'LBL_SUBJECT',
    	'default' => true,
    	'link' => true,
  		),
  
  	'SVNUMBER' => 
  		array (
    	'width' => '10',
    	'label' => 'LBL_SVNUMBER',
    	'default' => true,
    	),
  
	 'VERSION' => 
  		array (
    	'width' => '10',
    	'label' => 'LBL_VERSION',
    	'default' => true,
    	),
    
  'STATUS' => 
  array (
    'width' => '10',
    'label' => 'LBL_STATUS',
    'default' => true,
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
  
   'TOTAL_COST' => 
  array (
  	 'type' => 'currency',
    'width' => '10',
    'label' => 'LBL_TOTALCOST',
    'default' => true,
    'currency_format' => true,
  ),
  
  'GRAND_TOTAL' => 
  array (
  	 'type' => 'currency',
    'width' => '10',
    'label' => 'LBL_GRANDTOTAL',
    'default' => false,
    'currency_format' => true,
    'currency_symbol' => true,
  ),
  'STARTDATE' => array(
        'width' => '10', 
        'label' => 'LBL_STARTDATE',
        'default' => false,
        ),
   'ENDDATE' => array(
        'width' => '10', 
        'label' => 'LBL_ENDDATE',
        'default' => true,
        ),
  
  'DATE_MODIFIED' => array(
        'width' => '5', 
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
  'CURRENCY_ID' => 
  			array (
    		'width' => '5',
    		'label' => 'LBL_CURRENCY',
    		'default' => false,
  			),
  
  )
);
?>
