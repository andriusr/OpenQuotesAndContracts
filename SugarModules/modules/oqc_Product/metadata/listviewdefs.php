<?php
$module_name = 'oqc_Product';
$OBJECT_NAME = 'OQC_PRODUCT';
$listViewDefs = array (
$module_name =>
array (
   'OQC_VAT' =>  //1.7.8 Restored since it is required for passing data to Yui tables
  array (
    'width' => '1',
    'label' => 'LBL_VAT',
    'default' => false,
  ), 
  'ACTIVE' => 
  array (
    'width' => '3',
    'label' => 'LBL_ACTIVE',
    'default' => true,
  ),
  
  'NAME' => 
  array (
    'width' => '15',
    'label' => 'LBL_SUBJECT',
    'default' => true,
    'link' => true,
  ),
  
  'SVNUMBER' => 
  array (
    'width' => '5',
    'label' => 'LBL_SVNUMBER',
    'default' => true,
    ),
  
  'VERSION' => 
  array (
    'width' => '5',
    'label' => 'LBL_VERSION',
    'default' => true,
    ),
  
  'STATUS' => 
  array (
    'width' => '5',
    'label' => 'LBL_STATUS',
    'default' => true,
   ),
  'PUBLISH_STATE' =>
  array (
    'width' => '3',
    'label' => 'LBL_PUBLISH_STATE',
    'default' => true,
  ),
  'CATEGORY_NUMBER' =>  //1.7.8- restored sorting to work
  array (
    'width' => '5',
    'label' => 'LBL_CATEGORY_NUMBER_SHORT',
    'default' => true,
    'link' => false,
    //'sortable' => false,
   ), 
   //1.7.8 changes
  'OQC_RELATEDCATEGORY_NAME' => 
  array (
    'width' => '10',
    'label' => 'LBL_RELATEDCATEGORY_NAME',
    'default' => true,
    'link' => false,
  ),
   'SUPPLIER_NAME' => 
  array (
    'width' => '10',
    'label' => 'LBL_SUPPLIER_NAME',
    'default' => false,
    'link' => true,
  ),
  
  'CATALOG_NAME' => 
  array (
    'width' => '10',
    'label' => 'LBL_CATALOG_NAME',
//    'default' => true,
  ),
  'PRICE' => 
  array (
  	 'type' => 'currency',
    'width' => '8',
    'label' => 'LBL_PRICE_SHORT',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'price_text',
    ),
    'currency_format' => true,
  ),
  'IS_RECURRING' => 
  array (
    'width' => '3',
    'label' => 'LBL_IS_RECURRING_SHORT',
    'default' => true,
  ),
  
 /* 'PRICE_RECURRING' => 
  array (
    'type' => 'currency',
    'width' => '5',
    'label' => 'LBL_PRICE_RECURRING_SHORT',
    'default' => true,
    'related_fields' => 
    array (
      0 => 'price_recurring_text',
    ),
    'currency_format' => true,
  ), */
  'UNIT' => 
  array (
    'width' => '5',
    'label' => 'LBL_UNIT',
  //  'default' => true,
  ),
// 1.7.8 Restored with "false" tag- required for passing data to YUI tables  
  'CANCELLATIONPERIOD' => 
  array (
    'width' => '5',
    'label' => 'LBL_CANCELLATIONPERIOD',
    'default' => false,
  ), 
  'MONTHSGUARANTEED' => 
  array (
    'width' => '5',
    'label' => 'LBL_MONTHSGUARANTEED',
    'default' => false,
  ), 
  'DATE_MODIFIED' => array(
        'width' => '8', 
        'label' => 'LBL_DATE_MODIFIED',
        'default' => true,
        ),
  
  'ASSIGNED_USER_NAME' => array(
		'width' => '8', 
		'label' => 'LBL_LIST_ASSIGNED_USER',
		'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true),
    'CURRENCY_ID' => 
  			array (
    		'width' => '5',
    		'label' => 'LBL_CURRENCY',
    		'default' => false,
  			), 
	)
);
?>
