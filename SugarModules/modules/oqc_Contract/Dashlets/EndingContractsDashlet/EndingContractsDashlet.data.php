<?php
$dashletData['EndingContractsDashlet']['searchFields'] = array(
	// search for all contracts with an end date in the next month
	/*'enddate' => array(
		'default' => 'DATE_ADD((NOW(), INTERVAL 1 MONTH)',
		'operator' => '<=',
	)*/
);

$dashletData['EndingContractsDashlet']['columns'] = array(
	'name' => array(
		'width' => '20', 
		'label' => 'LBL_NAME',
		'link'    => true, // is the column clickable  
		'default' => true // is this column displayed by default
	),
	'enddate' => array(
		'width' => '20', 
		'label' => 'LBL_ENDDATE',
		'link'    => true, // is the column clickable  
		'default' => true // is this column displayed by default
	),
	'signedon' => array(
		'width' => '20', 
		'label' => 'LBL_SIGNEDON',
		'link'    => true, // is the column clickable  
		'default' => true // is this column displayed by default
	),
);
?>
