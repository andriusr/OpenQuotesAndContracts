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
$dictionary['oqc_ProductCatalog'] = array(
	'table'=>'oqc_productcatalog',
	'audited'=>true,
	'fields'=>array (
  'active' => 
  array (
    'required' => false,
    'name' => 'active',
    'vname' => 'LBL_ACTIVE',
    'type' => 'bool',
    'default' => 1,
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
  ),
  'validfrom' => 
  array (
    'required' => true,
    'name' => 'validfrom',
    'vname' => 'LBL_VALIDFROM',
    'type' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
  ),
  'validto' => 
  array (
    'required' => true,
    'name' => 'validto',
    'vname' => 'LBL_VALIDTO',
    'type' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
  ),
  'products' => 
  array (
    'required' => false,
    'name' => 'products',
    'vname' => 'LBL_PRODUCTS',
    'type' => 'varchar',
    'source' => 'non-db',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '25',
    'function' =>
    array (
      'name' => 'getProductCategoriesHTML',
      'returns' => 'html',
      'include' => 'include/oqc/ProductCatalog/ProductCatalog.php',
    ),
  ),
 /* 'publication_text' =>
  array (
    'required' => false,
    'name' => 'publication_text',
    'vname' => 'LBL_PUBLICATION_TEXT',
    'type' => 'varchar',
    'default' => '',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'studio' => 'visible',
    'len' => '255'
  ), */
  'frontpage_id' => 
  array (
    'required' => false,
    'name' => 'frontpage_id',
    'vname' => '',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => 36,
  ),
  'frontpage' => 
  array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'frontpage',
    'vname' => 'LBL_FRONTPAGE',
    'type' => 'relate',
    'massupdate' => 1,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => '255',
    'id_name' => 'frontpage_id',
 //   'ext2' => 'Documents', //for 6.1.2 to work
    'module' => 'Documents',
    'table' => 'documents', //1.7.6 
    'studio' => 'visible',
  ),
  'attachment_id' => 
  array (
    'required' => false,
    'name' => 'attachment_id',
    'vname' => '',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => 36,
  ),
  'attachment' => 
  array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'attachment',
    'vname' => 'LBL_ATTACHMENT',
    'type' => 'relate',
    'massupdate' => 1,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => '255',
    'id_name' => 'attachment_id',
    'table' => 'documents', //1.7.6 
//    'ext2' => 'Documents', // For 6.1.2 to work
    'module' => 'Documents',
    'studio' => 'visible',
  ),
  'document_id' => 
  array (
    'required' => false,
    'name' => 'document_id',
    'vname' => '',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => 36,
  ),
  'category_ids' => 
  array (
    'required' => false,
    'name' => 'category_ids',
    'type' => 'text',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'visible',
  ),
  'oqc_textblockedit' => array (
    'required' => false,
    'name' => 'oqc_textblockedit',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'varchar',
    'source' => 'non-db',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'function' => 
    array (
      'name' => 'getSingleTextblockHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Textblocks/Textblocks.php',
    ),
  ),
   //2.0 template selection field
  'oqc_template' => 
  array (
    'required' => true,
    'name' => 'oqc_template',
    'vname' => 'LBL_TEMPLATE',
    'type' => 'enum',
    'massupdate' => 1,
    'default' => 'Contract',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => 36,
    'options' => 'oqc_catalog_templates_list',
    'studio' => 'visible',
  ),
 /* 'currency_id' => 
  array (
    'required' => false,
    'name' => 'currency_id',
    'vname' => 'LBL_CURRENCY',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'visible',
    'function' => 
    array (
      'name' => 'oqc_getCurrencyNameDropDown',
      'returns' => 'html',
      'include' => 'include/oqc/Services/Services.php',
    ),
  ), */
  
  //2.2RC1 Return to standard currency dropdown for Contracts, Quotes and additions  	
  'currency_id' =>
  array (
    'name' => 'currency_id',
    'type' => 'id',
    'group'=>'currency_id',
    'vname' => 'LBL_CURRENCY',
	'function'=>array('name'=>'getCurrencyDropDown', 'returns'=>'html'),
    'reportable'=>false,
    'comment' => 'Currency used for display purposes'
  ),
  'currency_name'=>
   	   array(
		'name'=>'currency_name',
		'rname'=>'name',
		'id_name'=>'currency_id',
		'vname'=>'LBL_CURRENCY_NAME',
		'type'=>'relate',
		'isnull'=>'true',
		'table' => 'currencies',
		'module'=>'Currencies',
		'source' => 'non-db',
        'function'=>array('name'=>'getCurrencyNameDropDown', 'returns'=>'html'),
        'studio' => 'false',
   	    'duplicate_merge' => 'disabled',
	),
   'currency_symbol'=>
   	   array(
		'name'=>'currency_symbol',
		'rname'=>'symbol',
		'id_name'=>'currency_id',
		'vname'=>'LBL_CURRENCY_SYMBOL',
		'type'=>'relate',
		'isnull'=>'true',
		'table' => 'currencies',
		'module'=>'Currencies',
		'source' => 'non-db',
        'function'=>array('name'=>'getCurrencySymbolDropDown', 'returns'=>'html'),
        'studio' => 'false',
   	    'duplicate_merge' => 'disabled',
	),
  
  'oqc_catalog_discount' => 
  array (
    'required' => false,
    'name' => 'oqc_catalog_discount',
    'vname' => 'LBL_CATALOG_DISCOUNT',
    'type' => 'float',
    'massupdate' => 0,
    'default' => '0.00',
    'disable_num_format' => true,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => '5',
    'precision' => '2',
  ),
  'pdf_document_name' => 
  array (
    'required' => false,
    'name' => 'pdf_document_name',
    'vname' => 'LBL_PDF_NAME',
    'type' => 'varchar',
    'default' => '',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'studio' => 'visible',
  ),
  //2.1 link to oqc_Task
    'oqc_task' =>
    array(
		'name' => 'oqc_task',
		'type' => 'link',
		'module' => 'oqc_Task',
		'bean_name'  => 'oqc_Task',
		'relationship' => 'oqc_task_oqc_productcatalog',
		'source' => 'non-db',
		'vname' => 'LBL_OQC_TASK',
  ),
),
	'relationships'=>array (
	'oqc_task_oqc_productcatalog' => 
    		array (
      'lhs_module' => 'oqc_ProductCatalog',
      'lhs_table' => 'oqc_productcatalog',
      'lhs_key' => 'id',
      'rhs_module' => 'oqc_Task',
      'rhs_table' => 'oqc_task',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
 //     'relationship_role_column'=>'parent_type',
//		'relationship_role_column_value'=>'oqc_Contract'
    ),	
),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('oqc_ProductCatalog','oqc_ProductCatalog', array('basic','assignable','issue'));

$dictionary['oqc_ProductCatalog']['fields']['created_by_name']['massupdate'] = 0;
$dictionary['oqc_ProductCatalog']['fields']['assigned_user_id']['massupdate'] = 1;
$dictionary['oqc_ProductCatalog']['fields']['status']['massupdate'] = 0;
$dictionary['oqc_ProductCatalog']['fields']['type']['massupdate'] = 0;
$dictionary['oqc_ProductCatalog']['fields']['resolution']['massupdate'] = 0;
$dictionary['oqc_ProductCatalog']['fields']['priority']['massupdate'] = 0;

$dictionary['oqc_ProductCatalog']['fields']['name']['required'] = true;

