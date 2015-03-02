<?php
$module_name = 'oqc_ExternalContract';
$_object_name = 'oqc_externalcontract';
$viewdefs = array (
$module_name =>
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'includes' => array(
          array('file' => 'include/oqc/common/OQC.js'),
          array('file' => 'include/oqc/Services/yuiBuild/yahoo-dom-event/yahoo-dom-event.js'),
          array('file' => 'include/oqc/Services/yuiBuild/json/json-min.js'),
          //scriptaculous files
          array('file' => 'include/oqc/scriptaculous/lib/prototype.js'),
			 array('file' => 'include/oqc/scriptaculous/src/scriptaculous.js'),
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
            'displayParams' => array ('size'=>75)          
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
      ),
      'LBL_PANEL_CONTACT' => 
      array (
	0 =>
	array (
	  0 => 
          array (
            'label' => 'LBL_ACCOUNT',
            'name' => 'account',
          ),
	),
        1 => 
        array (
          0 => 
          array (
            'label' => 'LBL_CLIENTCONTACTPERSON',
            'name' => 'clientcontactperson',
          ),
	),
	2 =>
	array (
          0 => 
          array (
            'label' => 'LBL_TECHNICALCONTACTPERSON',
            'name' => 'technicalcontactperson',
          ),
        ),
	3 => 
        array (
	  0 => 
	  array (
	    'label' => 'LBL_CONTACTPERSON',
	    'name' => 'contactperson',
	  ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'deliveryaddress',
            'label' => 'LBL_DELIVERYADDRESS',
          ),
        ),
        5 => 
        array(
          0 => 
          array (
            'name' => 'completionaddress',
            'label' => 'LBL_COMPLETIONADDRESS',
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
        2 => 
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
        3 => 
        array (
          0 => 
          array (
            'label' => 'LBL_MINIMUMDURATION',
            'name' => 'minimumduration',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'label' => 'LBL_WARN_IN_MONTHS',
            'name' => 'warn_in_months',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'label' => 'LBL_WARRANTEEDEADLINE',
            'name' => 'warranteedeadline',
          ),
        ),
	6 => 
        array (
          0 => 
          array (
            'label' => 'LBL_MONTHSGUARANTEED',
            'name' => 'monthsguaranteed',
          ),
        ),
      ),
      'LBL_PANEL_COSTS' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'label' => 'LBL_COSTS',
            'name' => 'costs',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'label' => 'LBL_PAYFOREFFORD',
            'name' => 'payforefford',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'label' => 'LBL_PAYTRAVELCOSTS',
            'name' => 'paytravelcosts',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'label' => 'LBL_PAYEXTRACOSTS',
            'name' => 'payextracosts',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'label' => 'LBL_PAYFOREXPENSE',
            'name' => 'payforexpense',
          ),
          1 => array (
            'label' => 'LBL_PAYFOREXPENSEDESCRIPTION',
            'name' => 'payforexpensedescription',
	      ),
        ),        
        5 => 
        array (
          0 => 
          array (
            'customCode' => '<input type="text" tabindex="6" title="" maxlength="255" size="30" id="finalcosts" name="finalcosts" style="border: 0px; background: rgba(255,255,255,0.0);" readonly="readonly" />',
            'label' => 'LBL_FINALCOSTS',
            'name' => 'finalcosts',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'label' => 'LBL_MINPAYMENT',
            'name' => 'minpayment',
          ),
	  1 => 
          array (
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
        ),
        1 => 
        array (
          0 => 
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
        1 => array(
         	 0=> array(),
        		 1=> array(),
          ),
      ),
      
    ),
  ),
)
);
?>
