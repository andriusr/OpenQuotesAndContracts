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
$dictionary['oqc_Product'] = array(
	'table'=>'oqc_product',
	'audited'=>true,
	'fields'=>array (
	
	//2.2RC1 rewrite of price logic - now there is single price field and is_recurring flag for indicating that this is recurring expenses product
	 'price' =>
  array (
    'name' => 'price',
    'vname' => 'LBL_PRICE',
    'type' => 'currency',
    'dbType' => 'double',
    'comment' => 'Product price, unconverted',
    'importable' => 'required',
    'duplicate_merge'=>'1',
    'required' => true,
  	'options' => 'numeric_range_search_dom',
    'enable_range_search' => true,
  ),
   'cost' =>
  array (
    'name' => 'cost',
    'vname' => 'LBL_COST',
    'type' => 'currency',
    'dbType' => 'double',
    'comment' => 'Cost',
    'importable' => 'required',
    'duplicate_merge'=>'1',
    'required' => true,
  	'options' => 'numeric_range_search_dom',
    'enable_range_search' => true,
  ),
   'supplier_id' => 
  array (
    'required' => false,
    'name' => 'supplier_id',
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
  'supplier_name' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'supplier_name',
    'vname' => 'LBL_SUPPLIER_NAME',
    'type' => 'relate',
    'massupdate' => 1,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => '255',
    'id_name' => 'supplier_id',
    'table' => 'accounts', //1.7.7
    'module' => 'Accounts',
    'studio' => 'visible',
    'rname' => 'name',
    'link' => 'supplier_link',
  ),
    'supplier_link' => 
    array (
      'name' => 'supplier_link',
      'type' => 'link',
      'relationship' =>  'account_oqc_product_rel',
      'vname' => 'LBL_SUPPLIER_NAME',
      'side' => 'right',
      'module' => 'Accounts',
      'bean_name' => 'Account',
      'source' => 'non-db',
    ),  
  
  
  //2.2RC1 this field no longer is used. Will be disabled in future releases
  'price_recurring' =>
  array (
    'name' => 'price_recurring',
    'vname' => 'LBL_PRICE_RECURRING',
    //'function'=>array('vname'=>'getCurrencyType'),
    'type' => 'currency',
//    'disable_num_format' => true,
    'dbType' => 'double',
    'comment' => 'This field will be removed in future releases',
    'help' => 'This field will be removed in future releases',
    'importable' => 'required',
    'duplicate_merge'=>'1',
    'required' => false,
  	'options' => 'numeric_range_search_dom',
    'enable_range_search' => true,
  ), 
 
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
	
	 'is_recurring' => 
    array (
      'required' => false,
      'name' => 'is_recurring',
      'vname' => 'LBL_IS_RECURRING',
      'type' => 'bool',
      'massupdate' => 1,
      'default' => 0,
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 1,
      'reportable' => 1,
    ),
	//2.2RC1 end of price logic rewrite

    //2.0RC2 required for Category name display without link
    'category_name' => 
   array (
     'required' => false,
     'name' => 'category_name',
     'vname' => 'LBL_RELATEDCATEGORY_NAME',
     'type' => 'varchar',
     'source' => 'non-db',
     'function' => 
     array (
       'name' => 'getCategoryNameHtml',
       'returns' => 'html',
       'include' => 'include/oqc/Products/Products.php',
     ),
   ),
   
      'oqc_relatedcategory_name' => // 2.0 for quicksearch to work field should end with _name
    	array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'oqc_relatedcategory_name',
      'vname' => 'LBL_RELATEDCATEGORY_NAME',
      'type' => 'relate',
      'massupdate' => 1,
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'rname' => 'name',
      'link' => 'oqc_category_link',
      'id_name' => 'relatedcategory_id',
      'table' => 'oqc_category', //1.7.7
      'module' => 'oqc_Category',
      'studio' => 'visible',
    
    ),
    
    'oqc_category_link' => //1.7.8 addition for Listview Category column
    array (
    'name' => 'oqc_category_link',
    'type' => 'link',
    'relationship' => 'oqc_product_category_rel',
    'module'=>'oqc_Category',
    'bean_name'=>'oqc_Category',
    'source'=>'non-db',
    'vname'=>'LBL_CATEGORY',
    ),
    'active' => 
    array (
      'required' => false,
      'name' => 'active',
      'vname' => 'LBL_ACTIVE',
      'type' => 'bool',
      'massupdate' => 1,
      'default' => '1',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 1,
      'reportable' => 0,
    ),
    //1.7.8 new vat field 
    'oqc_vat' => 
    array (
      'required' => false,
      'name' => 'oqc_vat',
      'vname' => 'LBL_VAT',
      'type' => 'enum',
      'massupdate' => 0,
      'default' => '',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 1,
      'reportable' => 0,
      'len' => 10,
      'options' => 'oqc_vat_list',
      'studio' => 'visible',
    ),
 
    'relatedcategory_id' => 
    array (
      'required' => false,
      'name' => 'relatedcategory_id',
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
      'table' => 'oqc_product',
      'module' => 'oqc_Product',
      //'rname' => 'id',
    ),
    'personincharge_id' => 
    array (
      'required' => false,
      'name' => 'personincharge_id',
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
    'personincharge' => 
    array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'personincharge',
      'vname' => 'LBL_PERSONINCHARGE',
      'type' => 'relate',
      'massupdate' => 1,
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'id_name' => 'personincharge_id',
      //'ext2' => 'Employees',
      'table' => 'users',
      'module' => 'Users',
      'studio' => 'visible',
    ),
    'assigned_employee_id' => 
    array (
      'required' => false,
      'name' => 'assigned_employee_id',
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
    'assigned_employee' => 
    array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'assigned_employee',
      'vname' => 'LBL_ASSIGNED_EMPLOYEE',
      'type' => 'relate',
      'massupdate' => 0,
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'len' => '255',
      'id_name' => 'assigned_employee_id',
      //'ext2' => 'Employees',
      'table' => 'users',
      'module' => 'Users',
      'studio' => 'visible',
    ),
    'unit' => 
    array (
      'required' => false,
      'name' => 'unit',
      'vname' => 'LBL_UNIT',
      'type' => 'enum',
      'massupdate' => 0,
      'default' => 'pieces',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 1,
      'reportable' => 0,
      'len' => 100,
      'options' => 'unit_list',
      'studio' => 'visible',
    ),
   'catalog_id' => 
    array (
      'required' => false,
      'name' => 'catalog_id',
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
      'table' => 'oqc_product',
      'module' => 'oqc_Product',
    ),
  'catalog_name' => 
  array (
    'required' => false,
      'source' => 'non-db',
      'name' => 'catalog_name',
      'vname' => 'LBL_CATALOGNAME',
      'type' => 'relate',
      'massupdate' => 0,
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'rname' => 'name',
      'link' => 'oqc_catalog_link',
      'id_name' => 'catalog_id',
      'table' => 'oqc_productcatalog', //1.7.7
      'module' => 'oqc_ProductCatalog',
      'studio' => 'visible',
  ),
  
  'oqc_catalog_link' => //2.0 addition
    array (
    'name' => 'oqc_catalog_link',
    'type' => 'link',
    'relationship' => 'oqc_product_catalog_rel',
    'module'=>'oqc_ProductCatalog',
    'bean_name'=>'oqc_ProductCatalog',
    'source'=>'non-db',
    'vname'=>'LBL_PRODUCTCATALOG',
    ),
    
  'price_text' =>
  array (
    'required' => false,
    'name' => 'price_text',
    'vname' => 'LBL_PRICE_TEXT',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'studio' => 'visible',
    'len' => '255'
  ),
  //2.2RC1 This field is no longer used. Will be removed in future releases
  'price_recurring_text' =>
  array (
    'required' => false,
    'name' => 'price_recurring_text',
    'vname' => 'LBL_PRICE_RECURRING_TEXT',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => 'This field will be removed in future releases',
    'help' => 'This field will be removed in future releases',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'studio' => 'visible',
    'len' => '255'
  ), 
  'category_number' => 
  array (
      'required' => false,
      'source' => 'non-db',
      'name' => 'category_number',
      'vname' => 'LBL_CATEGORY_NUMBER',
      'type' => 'relate',
      'massupdate' => 0,
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
    //  'len' => '255',
    	'rname' => 'number',
      'link' => 'oqc_category_link',
      'id_name' => 'relatedcategory_id',
     // 'ext2' => 'oqc_Category',
      'table' => 'oqc_category', //1.7.7
      'module' => 'oqc_Category',
      'studio' => 'visible',
    
   ),
  'monthsguaranteed' => 
  array (
    'required' => false,
    'name' => 'monthsguaranteed',
    'vname' => 'LBL_MONTHSGUARANTEED',
    'type' => 'int',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => 0,
    'len' => '3',
    'disable_num_format' => '',
  ),
  'cancellationperiod' => 
  array (
    'required' => false,
    'name' => 'cancellationperiod',
    'vname' => 'LBL_CANCELLATIONPERIOD',
    'type' => 'int',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => 0,
    'len' => '3',
    'disable_num_format' => '',
  ),
  'services' => 
  array (
    'required' => false,
    'name' => 'services',
    'vname' => 'LBL_SERVICES',
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
      'name' => 'getProductsHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Products/Products.php',
    ),
  ),
  'packaged_product_ids' => 
  array (
    'required' => false,
    'name' => 'packaged_product_ids',
    'type' => 'text',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'false',
  ),
 //1.7.5 Field for description of revision changes 
   'changes_from_previous' => 
  array (
    'required' => true,
    'name' => 'changes_from_previous',
    'vname' => 'LBL_CHANGES_FROM_PREVIOUS',
    'type' => 'text',
    'comments' => 'Indicate changes from previous revision here',
    'default' => 'Enter changes from previous revision here',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'studio' => 'visible',
  ),
  'previousrevision' =>
  array (
    'required' => false,
    'name' => 'previousrevision',
    'vname' => 'LBL_PREVIOUSREVISION',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '36',
    'function' =>
    array (
      'name' => 'getPreviousVersionsHtml',
      'returns' => 'html',
      'include' => 'include/oqc/PreviousVersions/PreviousVersions.php',
    ),
  ),
  'shownextrevisions' =>
  array (
    'required' => false,
    'name' => 'shownextrevisions',
    'vname' => 'LBL_NEXTREVISIONS',
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
      'name' => 'getNextRevisionsHtml',
      'returns' => 'html',
      'include' => 'include/oqc/NextRevisions/NextRevisions.php',
    ),
  ),
  'nextrevisions' =>
  array (
    'required' => false,
    'name' => 'nextrevisions',
    'vname' => 'LBL_NEXTREVISIONS',
    'type' => 'text',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'false',
  ),
  'version' =>
  array (
    'required' => false,
    'name' => 'version',
    'vname' => 'LBL_VERSION',
    'type' => 'int',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '11',
    'disable_num_format' => '',
  ),
  'attachments' => 
  array (
    'required' => false,
    'name' => 'attachments',
    'vname' => 'LBL_ATTACHMENTS',
    'type' => 'varchar',
    'source' => 'non-db',
    'function' => 
    array (
      'name' => 'getAttachmentsHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Attachments/Attachments.php',
    ),
  ),
  'attachmentsequence' => 
  array (
    'required' => false,
    'name' => 'attachmentsequence',
    'vname' => 'LBL_ATTACHMENTSEQUENCE',
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
  'publish_state' =>
    array (
      'required' => false,
      'name' => 'publish_state',
      'vname' => 'LBL_PUBLISH_STATE',
      'type' => 'enum',
      'massupdate' => 1,
      'default' => 'pending',
      'comments' => '',
      'help' => '',
   //   'duplicate_merge' => 'disabled',
   //   'duplicate_merge_dom_value' => 0,
      'audited' => 1,
      'reportable' => 0,
      'len' => 100,
      'options' => 'publish_state_list',
      'studio' => 'visible',
    ),
    'unique_identifier' =>
    array (
    'required' => false,
    'name' => 'unique_identifier',
    'vname' => 'LBL_UNIQUE_IDENTIFIER',
    'type' => 'int',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '11',
    'disable_num_format' => true, // this has to be set to true. otherwise we cannot prepend "0"s to the field in detail view. because "0001" would be parsed and displayed as the integer value 1.
    ),
   'packages' => 
   array (
     'required' => false,
     'name' => 'packages',
     'vname' => 'LBL_PACKAGES',
     'type' => 'varchar',
     'source' => 'non-db',
     'function' => 
     array (
       'name' => 'getPackagesHtml',
       'returns' => 'html',
       'include' => 'include/oqc/Products/Packages.php',
     ),
   ),
   'select_image' => 
   array (
     'required' => false,
     'name' => 'select_image',
     'vname' => 'LBL_IMAGE_FILENAME',
     'type' => 'varchar',
     'source' => 'non-db',
     'function' => 
     array (
       'name' => 'getImageHtml',
       'returns' => 'html',
       'include' => 'include/oqc/Products/Image.php',
     ),
   ),
   'image_filename' => // this stores the original filename
   array (
     'name' => 'image_filename',
     'vname' => 'LBL_IMAGE_FILENAME',
     'type' => 'text', // use text type instead of varchar to allow filenames longer than 255 characters
     'studio' => 'false',
   ),
   'image_unique_filename' => // this stores a "uniquified"-version of the filename. to avoid name conflicts in the upload directory
   array (
     'name' => 'image_unique_filename',
     'vname' => 'LBL_IMAGE_FILENAME',
     'type' => 'text', // use text type instead of varchar to allow filenames longer than 255 characters
     'studio' => 'false',
   ),
   'image_mime_type' =>
   array (
     'name' => 'image_mime_type',
     'vname' => 'LBL_MIME',
     'type' => 'varchar',
     'len' => '10', // TODO how long is the longest image mime-type??
     'studio' => 'false',
   ),
   'catalog_position' =>
   array (
     'name' => 'catalog_position',
     'vname' => 'LBL_CATALOG_POSITION',
     'type' => 'int',
     'massupdate' => true,
   ),
   //1.7.6
   'is_latest' => 
    array (
      'required' => false,
      'name' => 'is_latest',
      'vname' => 'LBL_IS_LATEST',
      'type' => 'bool',
      'massupdate' => 0,
      'default' => 1,
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'studio' => 'false',
    ),
   // Product code field 
    'svnumber' => 
  array (
    'required' => false,
    'name' => 'svnumber',
    'vname' => 'LBL_SVNUMBER',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
  ),
  // 2.0 new tinyMCE editor
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
  //2.0 ProducOptions fields
  'is_option' => 
    array (
      'required' => false,
      'name' => 'is_option',
      'vname' => 'LBL_IS_OPTION',
      'type' => 'bool',
      'massupdate' => 0,
      'default' => '0',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'studio' => 'false',
    ),
   'product_options' => 
  array (
    'required' => false,
    'name' => 'product_options',
    'vname' => 'LBL_PRODUCTOPTIONS',
    'type' => 'varchar',
    'source' => 'non-db',
    'function' => 
    array (
      'name' => 'getProductOptionsHtml',
      'returns' => 'html',
      'include' => 'include/oqc/ProductOptions/ProductOptions.php',
    ),
  ),
  'optionssequence' => 
  array (
    'required' => false,
    'name' => 'optionssequence',
    'vname' => 'LBL_OPTIONSSEQUENCE',
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
  //2.1 link to oqc_Task
    'oqc_task' =>
    array(
		'name' => 'oqc_task',
		'type' => 'link',
		'module' => 'oqc_Task',
		'bean_name'  => 'oqc_Task',
		'relationship' => 'oqc_task_oqc_product',
		'source' => 'non-db',
		'vname' => 'LBL_OQC_TASK',
  ),
),
	'relationships'=>array (
		'oqc_product_category_rel' => 
  			array(
  			'lhs_module'=> 'oqc_Category', 
  			'lhs_table'=> 'oqc_category', 
  			'lhs_key' => 'id',
  			'rhs_module'=> 'oqc_Product', 
  			'rhs_table'=> 'oqc_product', 
  			'rhs_key' => 'relatedcategory_id',
  			'relationship_type'=>'one-to-many',
  			),	
  			
  		'oqc_product_catalog_rel' => 
  			array(
  			'lhs_module'=> 'oqc_ProductCatalog', 
  			'lhs_table'=> 'oqc_productcatalog', 
  			'lhs_key' => 'id',
  			'rhs_module'=> 'oqc_Product', 
  			'rhs_table'=> 'oqc_product', 
  			'rhs_key' => 'catalog_id',
  			'relationship_type'=>'one-to-many',
  			),
  		'oqc_task_oqc_product' => 
    		array (
      'lhs_module' => 'oqc_Product',
      'lhs_table' => 'oqc_product',
      'lhs_key' => 'id',
      'rhs_module' => 'oqc_Task',
      'rhs_table' => 'oqc_task',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
     ),
     'account_oqc_product_rel' => 	
     array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'oqc_Product',
      'rhs_table' => 'oqc_product',
      'rhs_key' => 'supplier_id',
      'relationship_type' => 'one-to-many',
      )
	),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('oqc_Product','oqc_Product', array('basic','assignable','issue'));

$dictionary['oqc_Product']['fields']['name']['required'] = true;
$dictionary['oqc_Product']['fields']['description']['required'] = false;
$dictionary['oqc_Product']['fields']['status']['options'] = 'oqc_product_status_list';

$dictionary['oqc_Product']['fields']['created_by_name']['massupdate'] = 0;
$dictionary['oqc_Product']['fields']['type']['massupdate'] = 0;
$dictionary['oqc_Product']['fields']['resolution']['massupdate'] = 0;
$dictionary['oqc_Product']['fields']['priority']['massupdate'] = 0;
//$dictionary['oqc_Product']['fields']['assigned_user_id']['massupdate'] = 0;
//dictionary['oqc_Product']['fields']['assigned_user_name']['massupdate'] = 1;
