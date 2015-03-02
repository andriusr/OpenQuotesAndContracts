<?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2007 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
$module_name = 'oqc_ProductCatalog';
$_object_name = 'oqc_productcatalog';
$viewdefs = array (
$module_name =>
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
    	'includes' => array (
 		),
    
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DELETE',
 	       2 => array('customCode' => '<input title="{$MOD.LBL_CREATE_PDF}" accessKey="{$MOD.LBL_CREATE_PDF_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_ProductCatalog&action=CreatePdf&record={$fields.id.value}\'" name="createPdf" value="{$MOD.LBL_CREATE_PDF}">'
          ),
          3 => array('customCode' => '<input title="{$MOD.LBL_CREATE_TASK}" accessKey="{$MOD.LBL_TASK_BUTTON_KEY}" type="button" class="button" onClick="document.location=\'index.php?module=oqc_Task&action=EditView&relate_id={$fields.id.value}&relate_to=oqc_ProductCatalog&parent_id={$fields.id.value}&parent_name={$fields.name.value}&parent_type=oqc_ProductCatalog\'" name="createTask" value="{$MOD.LBL_CREATE_TASK}">'
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
        1 => array(
        	array(),
        	array(),
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
          ),
          1 =>
          array (
            'name' => 'attachment',
            'label' => 'LBL_ATTACHMENT',
          ),
        ),
// this would display the document_id        
//        1 =>
//        array (
//          0 =>
//          array (
//            'name' => 'document_id',
//            'label' => 'LBL_DOCUMENT_ID',
//          ),
//        ),
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
