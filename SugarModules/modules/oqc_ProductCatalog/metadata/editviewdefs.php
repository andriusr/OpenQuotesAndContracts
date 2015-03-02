<?php
$module_name = 'oqc_ProductCatalog';
$_object_name = 'oqc_productcatalog';
$viewdefs = array (
$module_name =>
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
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
    /*   'form' => 
      array (
        'buttons' => 
        array (
          0 => array('customCode' => '<input type="submit" value="{$APP.LBL_SAVE_BUTTON_LABEL}" name="button" onclick="this.form.action.value=\'Save\'; 
        return check_form(\'EditView\');" class="button" accesskey="{$APP.LBL_SAVE_BUTTON_KEY}" title="{$APP.LBL_SAVE_BUTTON_TITLE}"/>'
           ),
          1 => 'CANCEL',
 	      ),
      ), */
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
            'name' => 'oqc_template',
            'label' => 'LBL_TEMPLATE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'currency_id',
            'label' => 'LBL_CURRENCY',
          ),
          1 => 
          array (
            'name' => 'oqc_catalog_discount',
            'label' => 'LBL_CATALOG_DISCOUNT',
          ),
        ),
         2 => 
        array (
          0 => 
          array (),
          1 => 
          array (
           'name' => 'pdf_document_name',
            'label' => 'LBL_PDF_NAME',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
		 		'name' => 'oqc_textblockedit',
       		'label' => 'LBL_DESCRIPTION',
        		),
        ),
      ),
      'LBL_PANEL_VALIDITY' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'validfrom',
            'label' => 'LBL_VALIDFROM',
          ),
          1 => 
          array (
            'name' => 'validto',
            'label' => 'LBL_VALIDTO',
          ),
        ),
      ),
      'LBL_PANEL_CATEGORIES' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'products',
            'label' => 'LBL_PRODUCTS',
          ),
        ),
        1 =>
        array(
        		0=> array(),
        		1=> array(),
        	),
      ),
      'LBL_PANEL_APPEARANCE' =>
      array (
        0 =>
        array (
          0 =>
          array (
            'name' => 'frontpage',
            'label' => 'LBL_FRONTPAGE',
          	'customCode' => '<input type="text" name="frontpage" class="sqsEnabled" tabindex="4" id="frontpage" size="" value="{$fields.frontpage.value}" title="frontpage pdf" autocomplete="off" >' .
							'<input type="hidden" name="frontpage_id" id="frontpage_id" value="{$fields.frontpage_id.value}">' .
							'<input type="button" name="btn_frontpage" tabindex="4" title="Select [Alt+T]" accessKey="T" class="button" value="Select" onclick=\'open_popup("Documents", 600, 400, "", true, false, {ldelim}"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{ldelim}"id":"frontpage_id","document_name":"frontpage"{rdelim}{rdelim}, "single", true);\'>' .
							'<input type="button" name="btn_clr_frontpage" tabindex="4" title="Clear [Alt+C]" accessKey="C" class="button" onclick="this.form.frontpage.value = \'\'; this.form.frontpage_id.value = \'\';" value="Clear">',          
          ),
          1 =>
          array (
            'name' => 'attachment',
            'label' => 'LBL_ATTACHMENT',
          	'customCode' => '<input type="text" name="attachment" class="sqsEnabled" tabindex="4" id="attachment" size="" value="{$fields.attachment.value}" title="attachment pdf" autocomplete="off" >' .
							'<input type="hidden" name="attachment_id" id="attachment_id" value="{$fields.attachment_id.value}">' .
							'<input type="button" name="btn_attachment" tabindex="4" title="Select [Alt+T]" accessKey="T" class="button" value="Select" onclick=\'open_popup("Documents", 600, 400, "", true, false, {ldelim}"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{ldelim}"id":"attachment_id","document_name":"attachment"{rdelim}{rdelim}, "single", true);\'>' .
							'<input type="button" name="btn_clr_attachment" tabindex="4" title="Clear [Alt+C]" accessKey="C" class="button" onclick="this.form.attachment.value = \'\'; this.form.attachment_id.value = \'\';" value="Clear">',          
          ),
        ),
      ),
      'LBL_PANEL_WORKLOG' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'work_log',
            'label' => 'LBL_WORK_LOG',
          ),
        ),
      ),

    ),
  ),
)
);
?>
