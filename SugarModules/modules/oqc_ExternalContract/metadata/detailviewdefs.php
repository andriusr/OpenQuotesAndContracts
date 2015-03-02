<?php
$module_name = 'oqc_ExternalContract';
$_object_name = 'oqc_externalcontract';
$viewdefs = array (
$module_name =>
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'includes' => array(
          array('file' => 'include/oqc/common/OQC.js'),
          array('file' => 'include/oqc/ExternalContracts/Documents.js'),
      	),
      'form' => 
    array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 
          array (
            'customCode' => '<input title="{$APP.LBL_DUP_MERGE}"                     accesskey="M"                     class="button"                     onclick="this.form.return_module.value=\'oqc_ExternalContract\';this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Step1\'; this.form.module.value=\'MergeRecords\';"                     name="button"                     value="{$APP.LBL_DUP_MERGE}"                     type="submit">',
          ),
          4 => array('customCode' => '<input title="{$MOD.LBL_CREATE_PDF}" accessKey="{$MOD.LBL_CREATE_PDF_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_ExternalContract&action=CreatePdf&record={$fields.id.value}\'" name="createPdf" value="{$MOD.LBL_CREATE_PDF}">'
          ),
     //     5 => array('customCode' => '<input title="{$MOD.LBL_CREATE_TASK}" accessKey="{$MOD.LBL_TASK_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_Task&action=EditView&relate_id={$fields.id.value}&relate_to=oqc_ExternalContract&parent_id={$fields.id.value}&parent_name={$fields.name.value}&parent_type=oqc_ExternalContract\'" name="createTask" value="{$MOD.LBL_CREATE_TASK}">'
      //    ),
          5 => array('customCode' => '
		{if $fields.is_archived.value}
<input title="{$MOD.LBL_RESTORE}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_ExternalContract&action=Restore&record={$fields.id.value}\'" name="restore" value="{$MOD.LBL_RESTORE}">
		{else}
<input title="{$MOD.LBL_ARCHIVE}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_ExternalContract&action=Archive&record={$fields.id.value}\'" name="archive" value="{$MOD.LBL_ARCHIVE}">
		{/if}'
	  		),
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
    ),
    'panels' => 
    array (
      'LBL_PANEL_GENERAL' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'label' => 'LBL_SUBJECT',
            'name' => 'name',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'label' => 'LBL_RECORDTOKEN',
            'name' => 'recordtoken',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'label' => 'LBL_CONTRACTNUMBER',
            'name' => 'contractnumber',
          ),
          1 => 
          array (
            'label' => 'LBL_CONTRACTNUMBERCLIENT',
            'name' => 'contractnumberclient',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'label' => 'LBL_SVNUMBERS',
            'name' => 'svnumbers',
          ),
          1 => 
          array (
            'label' => 'LBL_DMSNUMBER',
            'name' => 'dmsnumber',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'label' => 'LBL_ABBREVIATION',
            'name' => 'abbreviation',
          ),
        ),
		  5 => 
        array (
          0 => 
          array (
            'label' => 'LBL_KST',
            'name' => 'kst',
          ),
	  			1 => 
          array (
            'label' => 'LBL_PRODUCTNUMBER',
            'name' => 'productnumber',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'label' => 'LBL_EXTERNALCONTRACTTYPE',
            'name' => 'externalcontracttype',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'label' => 'LBL_EXTERNALCONTRACTMATTER',
            'name' => 'externalcontractmatter',
          ),
        ),
		  8 => 
        array (
          0 => 
          array (
            'label' => 'LBL_POSITIONS',
            'name' => 'positions',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'label' => 'LBL_DESCRIPTION',
            'name' => 'description',
          ),
        ),
			10 => 
			array (
		0 =>
		array (
			'label' => 'LBL_CREATED_BY',
			'name' => 'created_by_name',
		),
	),
        11 => 
        array (
          0 => 
          array (
            'label' => 'LBL_DATE_ENTERED',
            'name' => 'date_entered',
          ),
          1 => 
	  array('name'=>'date_modified', 'label'=>'LBL_DATE_MODIFIED', 'customCode'=>'{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}'),
        ),

      ),
      'LBL_PANEL_CONTACT' => 
      array (
        0 =>
	array (
	  0 => array (
	    'label' => 'LBL_ACCOUNT',
	    'name' => 'account',
	  ),
	),
        1 =>
        array (
	  0 => array (
	    'label' => 'LBL_CLIENTCONTACTPERSON',
	    'name' => 'clientcontactperson',
	  ),
        ),
        2 =>
        array (
	  0 => array (
	    'label' => 'LBL_TECHNICALCONTACTPERSON',
	    'name' => 'technicalcontactperson',
	  ),
        ),
	3 => 
	array (
	  0 => array (
	    'label' => 'LBL_CONTACTPERSON',
	    'name' => 'contactperson',
	  ),
	),
        4 => 
        array (
          0 => 
          array (
            'label' => 'LBL_DELIVERYADDRESS',
            'name' => 'deliveryaddress',
          ),
          1 => 
          array (
            'label' => 'LBL_COMPLETIONADDRESS',
            'name' => 'completionaddress',
          ),
        ),
      ),
      'LBL_PANEL_DEADLINES' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'label' => 'LBL_STARTDATE',
            'name' => 'startdate',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'label' => 'LBL_ENDPERIOD',
            'name' => 'endperiod',
          ),
          1 => 
          array (
            'label' => 'LBL_ENDDATE',
            'name' => 'enddate',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'label' => 'LBL_CANCELLATIONPERIOD',
            'name' => 'cancellationperiod',
          ),
          1 => 
          array (
            'label' => 'LBL_CANCELLATIONDATE',
            'name' => 'cancellationdate',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'label' => 'LBL_MINIMUMDURATION',
            'name' => 'minimumduration',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'label' => 'LBL_WARN_IN_MONTHS',
            'name' => 'warn_in_months',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'label' => 'LBL_WARRANTEEDEADLINE',
            'name' => 'warranteedeadline',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'label' => 'LBL_MONTHSGUARANTEED',
            'name' => 'monthsguaranteed',
          ),
        ),
      ),
      'LBL_PANEL_COSTS' => 
      array(
	0 =>
	array(
	  0 => array (
            'label' => 'LBL_COSTS',
            'name' => 'costs',
	  ),
        ),
	1 =>
	array(
	  0 => array (
            'label' => 'LBL_PAYFOREFFORD',
            'name' => 'payforefford',
	  ),
        ),
	2 =>
	array(
	  0 => array (
            'label' => 'LBL_PAYTRAVELCOSTS',
            'name' => 'paytravelcosts',
	  ),
        ),
	3 =>
	array(
	  0 => array (
            'label' => 'LBL_PAYEXTRACOSTS',
            'name' => 'payextracosts',
	  ),
        ),
    4 =>
	array(
	  0 => array (
            'label' => 'LBL_PAYFOREXPENSE',
            'name' => 'payforexpense',
	  ),
	  1 => array (
            'label' => 'LBL_PAYFOREXPENSEDESCRIPTION',
            'name' => 'payforexpensedescription',
	  ),
        ),
	5 =>
	array(
	  0 => array (
            'label' => 'LBL_FINALCOSTS',
            'name' => 'finalcosts',
	  ),
        ),
	6 =>
	array(
	    0 =>
	    array(
	      'label' => 'LBL_MINPAYMENT',
	      'name' => 'minpayment',
	    ),
	    1 =>
	    array(
	      'label' => 'LBL_MAXPAYMENT',
	      'name' => 'maxpayment',
	    ),
        ),	
      ),
      'LBL_PANEL_DOCUMENTATION' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'label' => 'LBL_COPYDOCUMENTATIONALLOWED',
            'name' => 'copydocumentationallowed',
          ),
       
          1 => 
          array (
            'label' => 'LBL_NUMBEROFDOCUMENTATIONCOPIES',
            'name' => 'numberofdocumentationcopies',
          ),
        ),
      ),
	 'LBL_PANEL_ATTACHMENTS' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'attachments',
            'label' => 'LBL_ATTACHMENTS',
          ),
        ),
       	1 =>
        		array(
        			0=> array(),
        			1=> array(),
        	), 
      ),
	'LBL_PANEL_HISTORY' =>
	array (
		array ( 
			0 =>
				array(
				'name' => 'version',
				'label' => 'LBL_VERSION_CURRENT',
					),
			1 =>
				array(
				'name' => 'work_log',
				'label' => 'LBL_WORK_LOG',
					), 
				), 
	
		array (
	  		0 =>
	  			array (
	    'name' => 'previousrevision',
	    'label' => 'LBL_PREVIOUSREVISION',
	  ),
	),
	
		array (
	  		0 =>
	  			array (
	    'name' => 'shownextrevisions',
	    'label' => 'LBL_NEXTREVISIONS',
	  ),
	),
      )
    ),
  ),
 ),
);
?>
