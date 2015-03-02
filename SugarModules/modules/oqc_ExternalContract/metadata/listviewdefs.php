<?php
$module_name = 'oqc_ExternalContract';
$OBJECT_NAME = 'OQC_EXTERNALCONTRACT';
$listViewDefs = array (
$module_name =>
array (
	'NAME' => 
  		array (
    	'width' => '8',
    	'label' => 'LBL_SUBJECT',
    	'default' => true,
    'link' => true,
  ),
  'RECORDTOKEN' =>
  array (
    'width' => '1',
    'label' => 'LBL_RECORDTOKEN',
    'default' => true,
    'link' => true,
  ),
  'CONTRACTNUMBER' =>
  array (
    'width' => '1',
    'label' => 'LBL_SHORT_CONTRACTNUMBER',
    'default' => false,
    'link' => true,
  ),
  
  'EXTERNALCONTRACTTYPE' => 
  array (
    'width' => '2',
    'label' => 'LBL_EXTERNALCONTRACTTYPE',
    'default' => true,
  ),
  'EXTERNALCONTRACTMATTER' => 
  array (
    'width' => '2',
    'label' => 'LBL_EXTERNALCONTRACTMATTER',
    'sortable' => false,
    'default' => true,
  ),
  'FINALCOSTS' =>
  array (
    'width' => '2',
    'label' => 'LBL_FINALCOSTS',
    'sortable' => true,
    'default' => true,
    'currency_format' => true,
  ),
  'ACCOUNT' => 
  array (
    'width' => '4',
    'label' => 'LBL_SHORT_ACCOUNT',
    'default' => true,
    'link' => true,
    'module' => 'Accounts',
    'id' => 'ACCOUNT_ID',
    'related_fields' => array('account_id'),
  ),
  'KST' =>
  array (
    'width' => '2',
    'label' => 'LBL_SHORT_KST',
    'default' => false,
  ),
  'ENDDATE' =>
  array (
    'width' => '2',
    'label' => 'LBL_ENDDATE',
    'default' => true,
    'related_fields' => array('endperiod'),
  ),
  'CANCELLATIONDATE' =>
  array (
    'width' => '2',
    'label' => 'LBL_CANCELLATIONDATE',
    'default' => true,
  ),


)
);
?>
