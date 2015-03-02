<?php
$module_name = 'oqc_Addition';
$_object_name = 'oqc_addition';
$viewdefs = array (
$module_name =>
array (
  'DetailView' => 
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
        // oqc specific includes
        array('file' => 'include/oqc/common/OQC.js'),
        array('file' => 'include/oqc/Services/Formatting.js'),
      //  array('file' => 'include/oqc/Services/NegotiatedPrice.js'),
        array('file' => 'include/oqc/Services/Services.js'),
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
            'customCode' => '<input title="{$MOD.LBL_CREATE_PDF}" accessKey="{$MOD.LBL_CREATE_PDF_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_Addition&action=CreatePdf&record={$fields.id.value}\'" name="createPdf" value="{$MOD.LBL_CREATE_PDF}">',
          ),
          4 => array('customCode' => '<input title="{$MOD.LBL_CREATE_TASK}" accessKey="{$MOD.LBL_TASK_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_Task&action=EditView&relate_id={$fields.id.value}&relate_to=oqc_Addition&parent_id={$fields.id.value}&parent_name={$fields.name.value}&parent_type=oqc_Addition\'" name="createTask" value="{$MOD.LBL_CREATE_TASK}">'
          ),
          5 => array('customCode' => '<input title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick="open_popup(\'oqc_Audit\', \'600\', \'400\', \'&record={$fields.id.value}&module_name=oqc_Addition\', true, false,  {ldelim} \'call_back_function\':\'set_return\',\'form_name\':\'EditView\',\'field_to_name_array\':[] {rdelim} ); return false;" value="{$APP.LNK_VIEW_CHANGE_LOG}" type="submit">'),
        ),
        'hideAudit' => 'true',
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
          1 => 
          array (
            'name' => 'status',
            'label' => 'LBL_STATUS',
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
            'name' => 'oqc_template',
            'label' => 'LBL_TEMPLATE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'contractid',
            'label' => 'LBL_CONTRACTID',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'version',
            'label' => 'LBL_VERSION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => 
          array(),
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
            	'customCode' => '<input type="text" tabindex="6" title="" maxlength="255" size="30" id="total_cost_id" name="total_cost"  readonly="readonly" style="border: 0px;" />',
            	
          ),
         ),
        3 =>
        array (
        	0=> 
        		array (
        			'name' => 'grand_total_vat',
            	'label' => 'LBL_GRANDTOTALVAT',
            	'customCode' => '<input type="text" tabindex="5" title="" maxlength="255" size="30" id="grand_total_vat_id" name="grand_total_vat"  readonly="readonly" style="border: 0px;"/>',
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
            	'customCode' => '<input type="text" tabindex="4" title="" maxlength="255" size="30" id="grand_total_id" name="grand_total"  readonly="readonly" style="border: 0px;"/>',
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
         array (
          0 => array(),
          1 => array(),
          
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
      'LBL_PANEL_HISTORY' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'previousrevision',
            'label' => 'LBL_PREVIOUSREVISION',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'shownextrevisions',
            'label' => 'LBL_NEXTREVISIONS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (),
          1 =>
          array(),
        ),
      ),
    ),
  ),
)
);
?>
