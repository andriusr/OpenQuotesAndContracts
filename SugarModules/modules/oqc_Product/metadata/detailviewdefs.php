<?php
$module_name = 'oqc_Product';
$_object_name = 'oqc_product';
$viewdefs = array (
$module_name =>
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
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
          array('file' => 'include/javascript/quicksearch.js'),
          // neccessary for setting up products table
          //array('file' => 'include/JSON.js'),
          array('file' => 'include/oqc/common/OQC.js'),
          array('file' => 'include/oqc/Products/Products.js'),
          array('file' => 'include/oqc/Products/Packages.js'),
      ),
      'form' => 
      array (
        'buttons' => 
        array (
          'EDIT',
          'DUPLICATE',
          'DELETE',
          
           array('customCode' => '<input title="{$MOD.LBL_CREATE_TASK}" accessKey="{$MOD.LBL_TASK_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_Task&action=EditView&relate_id={$fields.id.value}&relate_to=oqc_Product&parent_id={$fields.id.value}&parent_name={$fields.name.value}&parent_type=oqc_Product\'" name="createTask" value="{$MOD.LBL_CREATE_TASK}">'
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
    
     'LBL_PANEL_SUBJECT' => 
      array (
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
          1 => 
          array (
            'name' => 'svnumber',
            'label' => 'LBL_SVNUMBER',
          ),
        ),
        array(
        	array(
				'name' => 'version',
				'label' => 'LBL_VERSION',
					),
		  ),
      ), 
    'LBL_PANEL_GENERAL' =>
      array (
      
        array (
          0 => 
          array (
            'name' => 'price',
            'label' => '{$MOD.LBL_PRICE} ({$CURRENCY})',
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
         1 =>
          array (
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
            'label' => '{$MOD.LBL_COST} ({$CURRENCY})',
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
         0 =>
        	array (
        		'name' => 'monthsguaranteed',
        		'label' => 'LBL_MONTHSGUARANTEED',
        	),
        	1 =>
        		array (
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
            'name' => 'category_name',
            'label' => 'LBL_RELATEDCATEGORY_NAME',
           ),
/*          1 =>
          array (
          	'name' => 'catalog_name',
          	'label' => 'LBL_CATALOG_NAME',
          ),*/
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
        //This is set from Product catalog, so remove it 
      /*  array (
          0 =>
          array (
            'name' => 'catalog_position',
            'label' => 'LBL_CATALOG_POSITION',
          ),
        ), */
        array (
          0 => 
          array (
            'name' => 'unique_identifier',
            'label' => 'LBL_UNIQUE_IDENTIFIER',
          ),
        ),
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
          array (
            'name' => 'product_options',
            'label' => 'LBL_PRODUCTOPTIONS',
          ),
        ),
         1 => 
        array (
          0 => 
          array (),
          1 =>
          array(),
        ),         
      ),
            
      "LBL_PANEL_PACKAGE" =>
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
          array (),
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
          0 => 
          array (),
          1 =>
          array(),
        ),                 
      ),
      'LBL_PANEL_PACKAGES' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'packages',
            'label' => 'LBL_PACKAGES',
          ),
        ), 
       1 => 
        array (
          0 => 
          array (),
          1 =>
          array(),
        ),                  
      ),      
	'LBL_PANEL_HISTORY' =>
		array ( 
			
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
			array (
				array(),
				array(),
			),
      ),
    ),
  ),
)
);
?>
