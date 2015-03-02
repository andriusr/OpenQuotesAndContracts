<?php
$module_name = 'oqc_Offering';
$_object_name = 'oqc_offering';
$viewdefs = array (
$module_name =>
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'includes' => array(
        // yui datatable includes
        array('file' => 'include/oqc/Services/yuiBuild/yahoo-dom-event/yahoo-dom-event.js'),
        array('file' => 'include/oqc/Services/yuiBuild/get/get-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/calendar/calendar-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/dragdrop/dragdrop-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/element/element-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/datasource/datasource-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/connection/connection-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/datatable/datatable-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/json/json-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/container/container-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/menu/menu-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/button/button-min.js'),
        // oqc specific includes
        array('file' => 'include/oqc/common/OQC.js'),
        array('file' => 'include/oqc/Services/Formatting.js'),
    //    array('file' => 'include/oqc/tinymce/tiny_mce.js'),
        array('file' => 'include/oqc/Services/Services.js'),
        
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
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'abbreviation',
            'label' => 'LBL_ABBREVIATION',
          ),
          1 => 
          array (
            'name' => 'status',
            'label' => 'LBL_STATUS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'oqc_template',
            'label' => 'LBL_TEMPLATE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),
      'LBL_PANEL_CONTACT' => 
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'company',
            'label' => 'LBL_COMPANY',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'clientcontact',
            'label' => 'LBL_CLIENTCONTACT',
          ),
          1 => 
          array (
            'name' => 'contactperson',
            'label' => 'LBL_CONTACTPERSON',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'clienttechnicalcontact',
            'label' => 'LBL_CLIENTTECHNICALCONTACT',
          ),
          1 => 
          array (
            'name' => 'technicalcontact',
            'label' => 'LBL_TECHNICALCONTACT',
          ),
        ),
      ),
  		'LBL_PANEL_DEADLINES' => 
      array (
       0 => 
        array (
          0 => 
          array (
            'name' => 'startdate',
            'label' => 'LBL_STARTDATE',
          ),
       
          1 => 
          array (
            'name' => 'enddate',
            'label' => 'LBL_ENDDATE',
          ),
        ),
       1 => 
        array (
          0 => 
          array (
            'name' => 'warranty',
            'label' => 'LBL_WARRANTY',
          ),
        ),
       2 => 
        array (
          0 => 
          array (
            'name' => 'quote_leadtime',
            'label' => 'LBL_LEADTIME',
          ),
       
          1 => 
          array (
            'name' => 'quote_validity',
            'label' => 'LBL_QUOTEVALIDITY',
          ),
        ),
      ),
      'LBL_PANEL_SERVICES' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'label' => 'LBL_CURRENCY',
          ),
        ),
      
        1 => 
        array (
          0 => 
          array (
            'name' => 'services',
            'label' => 'LBL_SERVICES',
          ),
        ),
        2 =>
        array (
        	0=> 
        		array (
        			'name' => 'total_cost',
            	'label' => 'LBL_TOTALCOST',
            	'customCode' => '<input type="text" tabindex="6" title="" maxlength="255" size="30" id="total_cost_id" name="total_cost" style="background: rgba(255,255,255,0.0);" readonly="readonly" value="" />',
          ),
         ),
        3 =>
        array (
        	0=> 
        		array (
        			'name' => 'grand_total_vat',
            	'label' => 'LBL_GRANDTOTALVAT',
            	'customCode' => '<input type="text" tabindex="6" title="" maxlength="255" size="30" id="grand_total_vat_id" name="grand_total_vat" style="background: rgba(255,255,255,0.0);" readonly="readonly" value=""/>',
          ),
         1=> 
        		array (
        			'name' => 'shipment_terms',
            	'label' => 'LBL_SHIPMENTTERMS',
          ), 
         ),
        
        4 =>
        array (
        	0=> 
        		array (
        			'name' => 'grand_total',
            	'label' => 'LBL_GRANDTOTAL',
            	'customCode' => '<input type="text" tabindex="6" title="" maxlength="255" size="30" id="grand_total_id" name="grand_total" style="background: rgba(255,255,255,0.0);" readonly="readonly" value=""/>',
          ),
         1=> 
        		array (
        			'name' => 'payment_terms',
            	'label' => 'LBL_PAYMENTTERMS',
          ), 
          
         ),
          
      ),
      'LBL_PANEL_TEXTBLOCKS' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'textblockediting',
            'label' => 'LBL_TEXTBLOCKEDITING',
          ),
        ),
          1 =>
        array(
        		0=> array(),
        		1=> array(),
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
