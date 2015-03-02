<?php
$module_name = 'oqc_Product';
$_object_name = 'oqc_product';
$viewdefs = array (
$module_name =>
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'form' => array(
        'enctype' => 'multipart/form-data' ,// this sets the enctype attribute in the detail view form. it is neccessary for uploading files.
  	  ),
      'includes' => array(
            // neccessary for yui datatable
            array('file' => 'include/oqc/Services/yuiBuild/yahoo-dom-event/yahoo-dom-event.js'),
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
         
          //scriptaculous files
          	array('file' => 'include/oqc/scriptaculous/lib/prototype.js'),
				array('file' => 'include/oqc/scriptaculous/src/scriptaculous.js'),
          // neccessary for setting up products table
        
          array('file' => 'include/oqc/common/OQC.js'),
          array('file' => 'include/oqc/Products/Products.js'),
          array('file' => 'include/oqc/ProductOptions/ProductOptions.js'),
          array('file' => 'include/oqc/CreatePopup/CreatePopup.js'),
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
      'LBL_PANEL_SUBJECT' => 
      array (
        array (
          0 => 
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'size' => 60,
            ),
            'label' => 'LBL_SUBJECT',
          ),
          1 => 
          array (
            'name' => 'svnumber',
            'label' => 'LBL_SVNUMBER',
          ),
        ),
      ),
      
      "LBL_PANEL_GENERAL" =>
      array (
      	array(
    			array('name'=>'currency_id',
    			'label'=>'LBL_CURRENCY'),
    			array(),
    		),
        array (
          0 => 
          array (
            'name' => 'price',
            'label' => 'LBL_PRICE',
          ),
          1 => 
          array (
            'name' => 'active',
            'label' => 'LBL_ACTIVE',
          ),
        ),
        array (
          0 => 
          array (
            'name' => 'price_text',
            'label' => 'LBL_PRICE_TEXT',
          ),
          1 => 
          array (
            'name' => 'is_recurring',
            'label' => 'LBL_IS_RECURRING',
          ),
        ),
        //1.7.5 modification
         array (
        0 => array (
            'name' => 'changes_from_previous',
            'label' => 'LBL_CHANGES_FROM_PREVIOUS',
          ),
        1 => array (
        		'name' => 'is_option',
            'label' => 'LBL_IS_OPTION',
         ),
        ),
        //end
        array (
          0 => 
          array (
            'name' => 'unit',
            'label' => 'LBL_UNIT',
          ),
        ),
        array (
	  0 =>
          array (
            'name' => 'oqc_vat',
            'label' => 'LBL_VAT',
          ),
        ),
        array (
          0 => 
          array (
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
        ),
        array (
          0 =>
          array (
            'name' => 'publish_state',
            'label' => 'LBL_PUBLISH_STATE',
          ),
        ),
         array (
          0 =>
          array (
            'name' => 'status',
            'label' => 'LBL_STATUS',
          ),
        ),
        array (
        	0 => array (
			'customCode' => '<input type="text" tabindex="4" title="" value="{$fields.monthsguaranteed.value}" maxlength="3" size="3" id="monthsguaranteed" name="monthsguaranteed"/>&nbsp; {$MOD.LBL_MONTHS}',
        		'name' => 'monthsguaranteed',
        		'label' => 'LBL_MONTHSGUARANTEED',
        	),
        	1 => array (
			'customCode' => '<input type="text" tabindex="4" title="" value="{$fields.cancellationperiod.value}" maxlength="3" size="3" id="cancellationperiod" name="cancellationperiod"/>&nbsp; {$MOD.LBL_MONTHS}',
        		'name' => 'cancellationperiod',
        		'label' => 'LBL_CANCELLATIONPERIOD',
        	),
        ),
        array (
        	array (
			 'name' => 'supplier_name',
            'label' => 'LBL_SUPPLIER_NAME',
        	),
        ),
        array (
          0 => 
          array (
            'name' => 'oqc_relatedcategory_name',
            'label' => 'LBL_RELATEDCATEGORY_NAME',
          ),
        ),   
        array (
          0 => 
          array (
            'name' => 'personincharge',
            'label' => 'LBL_PERSONINCHARGE',
          ),
        ),
        array (
          0 => 
          array (
            'name' => 'assigned_employee',
            'label' => 'LBL_ASSIGNED_EMPLOYEE',
          ),
        ),
       /* array (
          0 =>
          array (
            'name' => 'catalog_position',
            'label' => 'LBL_CATALOG_POSITION',
          ),
        ), */
        array (
          0 =>
          array (
            'name' => 'select_image',
            'label' => 'LBL_IMAGE_FILENAME',
          ),
        ),
        array (
          0 => 
          array (
            'name' => 'oqc_textblockedit',
	         'label' => 'LBL_DESCRIPTION',
          ),
        ),
      ),
      'LBL_PANEL_PRODUCTOPTIONS' => 
      array (
        0 => 
        array (
          0 => 
          array(
            'name' => 'product_options',
            'label' => 'LBL_PRODUCTOPTIONS',
          ),
        ),
         1 => 
        array(
          0 => 
          array(),
          1 =>
          array(),
        ),         
      ),
      
      "LBL_PANEL_NEW_PACKAGE" =>
      array (
      	0 =>
      	array ( 
      		array (
      			'name' => 'services',
      			'label' => 'LBL_SERVICES',
      		),
      	),
      	1 => 
        array (
          0 => 
          array(),
          1 =>
          array(),
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
        array (
          0 => array(),
          1 => array(),
        ),                  
      ),
    ),
  ),
),
);
?>
