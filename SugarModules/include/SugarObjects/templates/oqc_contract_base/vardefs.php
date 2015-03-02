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
$vardefs = array(
 'fields'=>array (
  'services' => 
  array (
    'required' => false,
    'name' => 'services',
    'vname' => 'LBL_SERVICES',
    'type' => 'varchar',
    'massupdate' => 0,
    'source' => 'non-db',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '25',
    'function' => 
    array (
      'name' => 'getServicesHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Services/Services.php',
    ),
  ),
  'attachments' => 
  array (
    'required' => false,
    'name' => 'attachments',
    'vname' => 'LBL_ATTACHMENTS',
    'type' => 'varchar',
    'function' => 
    array (
      'name' => 'getAttachmentsHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Attachments/Attachments.php',
    ),
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
  'abbreviation' => 
  array (
    'required' => true,
    'name' => 'abbreviation',
    'vname' => 'LBL_ABBREVIATION',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'WEB',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => 100,
    'options' => 'abbreviation_list',
    'studio' => 'visible',
  ),
  'company_id' => 
  array (
    'required' => false,
    'name' => 'company_id',
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
  'company' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'company',
    'vname' => 'LBL_COMPANY',
    'type' => 'relate',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => '255',
    'id_name' => 'company_id',
    'table' => 'accounts', //1.7.7
    'module' => 'Accounts',
    'studio' => 'visible',
    'rname' => 'name',
    'link' => 'company_link',
  ),
    'company_link' => 
    array (
      'name' => 'company_link',
      'type' => 'link',
      'relationship' =>  strtolower($object_name) . '_company_search',
      'vname' => 'LBL_COMPANY',
      'side' => 'right',
      'module' => 'Accounts',
      'bean_name' => 'Account',
      'source' => 'non-db',
    ),  
  'technicalcontact_id' => 
  array (
    'required' => false,
    'name' => 'technicalcontact_id',
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
  'technicalcontact' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'technicalcontact',
    'vname' => 'LBL_TECHNICALCONTACT',
    'type' => 'relate',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'dbType' => 'varchar',
    'len' => '255',
    'id_name' => 'technicalcontact_id',
    'table' => 'users', //1.7.7
    'module' => 'Users',
    'studio' => 'visible',
  ),
  'contactperson_id' => 
  array (
    'required' => false,
    'name' => 'contactperson_id',
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
  'contactperson' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'contactperson',
    //'rname' => 'last_name', //1.7.7
    'vname' => 'LBL_CONTACTPERSON',
    'type' => 'relate',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'dbType' => 'varchar',
    'len' => '255',
    'id_name' => 'contactperson_id',
    //'ext2' => 'Employees',
    'module' => 'Users',
	'table' => 'users', //1.7.7
//	'db_concat_fields'=> array(0=>'first_name', 1=>'last_name'),
    'studio' => 'visible',
  ),
  'textblockediting' => 
  array (
    'required' => false,
    'name' => 'textblockediting',
    'vname' => 'LBL_TEXTBLOCKEDITING',
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
      'name' => 'getTextblocksHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Textblocks/Textblocks.php',
    ),
  ),
  'clienttechnicalcontact_id' => 
  array (
    'required' => false,
    'name' => 'clienttechnicalcontact_id',
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
  'clienttechnicalcontact' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'clienttechnicalcontact',
    'vname' => 'LBL_CLIENTTECHNICALCONTACT',
    'type' => 'relate',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => '255',
    'id_name' => 'clienttechnicalcontact_id',
    'table' => 'contacts', //1.7.7
    'module' => 'Contacts',
    'studio' => 'visible',
  ),
  'clientcontact_id' => 
  array (
    'required' => false,
    'name' => 'clientcontact_id',
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
  'clientcontact' => 
  array (
    'required' => true,
    'source' => 'non-db',
    'name' => 'clientcontact',
    'vname' => 'LBL_CLIENTCONTACT',
    'type' => 'relate',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
  	 'rname' => 'name',
  	 'link' =>  strtolower($object_name) .'_contact_link',	
    'id_name' => 'clientcontact_id',
    'table' => 'contacts', //1.7.7
	 'module' => 'Contacts',
    'studio' => 'visible',
  ),
  
    strtolower($object_name) .'_contact_link' =>
    array (
    'name' =>  strtolower($object_name) .'_link',
    'type' => 'link',
    'relationship' =>  strtolower($object_name) .'_contact_rel',
    'module'=>'Contacts',
    'bean_name'=>'Contact',
    'source'=>'non-db',
    'side' => 'right',
    'vname'=>'LBL_CONTACTS',
    ),
  
  
  'officenumber' => 
  array (
    'required' => false,
    'name' => 'officenumber',
    'vname' => 'LBL_OFFICENUMBER',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '25',
    'source' => 'non-db',
    'studio' => 'false',
  ), 
    
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
  'textblocksequence' => 
  array (
    'required' => false,
    'name' => 'textblocksequence',
    'vname' => 'LBL_TEXTBLOCKSEQUENCE',
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
    'studio' => 'false',
  ),
  'idoffreetextblock' => 
  array (
    'required' => false,
    'name' => 'idoffreetextblock',
    'vname' => 'LBL_IDOFFREETEXTBLOCK',
    'type' => 'id',
    'len' => '36',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'false',
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
  'startdate' => 
  array (
    'required' => true,
    'name' => 'startdate',
    'vname' => 'LBL_STARTDATE',
    'type' => 'date',
    'dbType' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
  ),
  'enddate' => 
  array (
    'required' => false,
    'name' => 'enddate',
    'vname' => 'LBL_ENDDATE',
    'type' => 'date',
    'dbType' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
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
 
  //1.7.6 extra fields for use with quotes
   'quote_leadtime' => 
  array (
    'required' => true,
    'name' => 'quote_leadtime',
    'vname' => 'LBL_LEADTIME',
    'type' => 'varchar',
    'massupdate' => 0,
    'default' => '1 month',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
//    'len' => 100,
//    'options' => 'quote_leadtime_list',
    'studio' => 'visible',
  ),
  'shipment_terms' => 
  array (
    'required' => true,
    'name' => 'shipment_terms',
    'vname' => 'LBL_SHIPMENTTERMS',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => '',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => 100,
    'options' => 'shipment_terms_list',
    'studio' => 'visible',
  ),
  'payment_terms' => 
  array (
    'required' => true,
    'default' => '30 days net',
    'name' => 'payment_terms',
    'vname' => 'LBL_PAYMENTTERMS',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'visible',
  ),
   'quote_validity' => 
  array (
    'required' => true,
    'default' => '60 days',
    'name' => 'quote_validity',
    'vname' => 'LBL_QUOTEVALIDITY',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'visible',
  ),
  'total_cost' => 
  array (
    'required' => false,
    'name' => 'total_cost',
    'vname' => 'LBL_TOTALCOST',
    'type' => 'currency',
    'dbType' => 'double', //1.7.5 fix Quick Repair errror
    'massupdate' => 0,
    'comments' => '',
    'duplicate_merge' => '1',
    'audited' => 1,
    'options' => 'numeric_range_search_dom',
    'enable_range_search' => true,
    'importable' => 'required',
  ),
  //1.7.8 extra fields for grand total calculation
   'grand_total_vat' => 
  array (
    'required' => false,
    'name' => 'grand_total_vat',
    'vname' => 'LBL_GRANDTOTALVAT',
    'type' => 'currency',
    'dbType' => 'double', //1.7.5 fix Quick Repair errror
    'massupdate' => 0,
    'comments' => '',
    'duplicate_merge' => '1',
    'audited' => 1,
 	 'importable' => 'required',
  ),
  'grand_total' => 
  array (
    'required' => false,
    'name' => 'grand_total',
 //   'source' => 'non-db',
    'vname' => 'LBL_GRANDTOTAL',
    'type' => 'currency',
    'dbType' => 'double', //1.7.5 fix Quick Repair errror
    'massupdate' => 0,
    'comments' => '',
    'duplicate_merge' => '1',
    'audited' => 1,
  	 'options' => 'numeric_range_search_dom',
    'enable_range_search' => true,
   ),
  
  'install_cost' => 
  array (
    'required' => false,
    'name' => 'install_cost',
    'vname' => 'LBL_INSTALLCOST',
    'type' => 'currency',
    'dbType' => 'double', //1.7.5 fix Quick Repair errror
    'massupdate' => 0,
    'comments' => '',
    'duplicate_merge' => '1',
    'audited' => 1,
  	'importable' => 'required',
  	),
  	'shipment_cost' => 
  array (
    'required' => false,
    'name' => 'shipment_cost',
    'vname' => 'LBL_SHIPMENTCOST',
    'type' => 'currency',
    'dbType' => 'double', //1.7.5 fix Quick Repair errror
    'massupdate' => 0,
    'comments' => '',
    'duplicate_merge' => '1',
    'audited' => 1,
    'importable' => 'required',
  	), 
    'warranty' => 
  array (
    'required' => true,
    'name' => 'warranty',
    'default' => '30 days',
    'vname' => 'LBL_WARRANTY',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'visible',
  ),
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
  //2.0 template selection field
  'oqc_template' => 
  array (
    'required' => true,
    'name' => 'oqc_template',
    'vname' => 'LBL_TEMPLATE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'Contract',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => 36,
    'options' => 'oqc_templates_list',
    'studio' => 'visible',
  ),
// End extra fields  
  
  
),
	'relationships'=>array (
 strtolower($object_name) . '_company_search' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => $object_name,
      'rhs_table' => strtolower($object_name),
      'rhs_key' => 'company_id',
      'relationship_type' => 'one-to-many',
    ),  
 strtolower($object_name) . '_officenumber_search' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts_cstm',
      'lhs_key' => 'id_c',
      'rhs_module' => $object_name,
      'rhs_table' => strtolower($object_name),
      'rhs_key' => 'company_id',
      'relationship_type' => 'one-to-many',
    ),
    strtolower($object_name) .'_contact_rel' => //1.7.8 for contact name showup in Listview
  			array(
  			'lhs_module'=> 'Contacts', 
  			'lhs_table'=> 'contacts', 
  			'lhs_key' => 'id',
  			'rhs_module'=> $object_name, 
  			'rhs_table'=> strtolower($object_name), 
  			'rhs_key' => 'clientcontact_id',
  			'relationship_type'=>'one-to-many',
  			),		
      
),
);
