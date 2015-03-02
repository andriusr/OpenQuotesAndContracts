<?php
$dashletData['EndingExternalContractsDashlet']['searchFields'] = array(
	'warn_in_months' => array('default' => ''),
);

$dashletData['EndingExternalContractsDashlet']['columns'] = array(
	'name' => array(
		'width' => '40', 
		'label' => 'LBL_NAME',
		'link'    => true, // is the column clickable  
		'default' => true // is this column displayed by default
	),
	'enddate' => array(
		'width' => '10', 
		'label' => 'LBL_ENDDATE',
		'link'    => false, // is the column clickable  
		'default' => true // is this column displayed by default
	),
	'cancellationperiod' => array(
		'width' => '10', 
		'label' => 'LBL_CANCELLATIONPERIOD',
		'link'    => false, // is the column clickable  
		'default' => true // is this column displayed by default
	),
);
?>
