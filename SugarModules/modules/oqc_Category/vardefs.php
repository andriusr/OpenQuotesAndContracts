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
$dictionary['oqc_Category'] = array(
	'table'=>'oqc_category',
	'audited'=>false,
	'fields'=>array (
  'subcategories' => 
  array (
    'required' => false,
    'name' => 'subcategories',
    'vname' => 'LBL_SUBCATEGORIES',
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
  'number' =>  // number in product catalog hierarchy
  array (
    'required' => false,
    'name' => 'number',
    'vname' => 'LBL_NUMBER',
    'type' => 'varchar',
    'len' => 36, 
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'studio' => 'visible',
  ),
  'catalog_id' =>  // product catalog id
  array (
    'required' => false,
    'name' => 'catalog_id',
    'type' => 'varchar',
    'len' => 36, 
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'studio' => 'visible',
  ),
  'catalog_name' => 
  array (
    'required' => false,
      'source' => 'non-db',
      'name' => 'catalog_name',
      'vname' => 'LBL_CATALOG_NAME',
      'type' => 'relate',
      'massupdate' => 0,
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'rname' => 'name',
      'link' => 'oqc_category_catalog_link',
      'id_name' => 'catalog_id',
      'table' => 'oqc_productcatalog', //1.7.7
      'module' => 'oqc_ProductCatalog',
      'studio' => 'visible',
  ),
  
  'oqc_category_catalog_link' => //2.0 addition
    array (
    'name' => 'oqc_category_catalog_link',
    'type' => 'link',
    'relationship' => 'oqc_category_catalog_rel',
    'module'=>'oqc_ProductCatalog',
    'bean_name'=>'oqc_ProductCatalog',
    'source'=>'non-db',
    'vname'=>'LBL_PRODUCTCATALOG',
    ),
),
	'relationships'=>array (
	'oqc_category_catalog_rel' => 
  			array(
  			'lhs_module'=> 'oqc_ProductCatalog', 
  			'lhs_table'=> 'oqc_productcatalog', 
  			'lhs_key' => 'id',
  			'rhs_module'=> 'oqc_Category', 
  			'rhs_table'=> 'oqc_category', 
  			'rhs_key' => 'catalog_id',
  			'relationship_type'=>'one-to-many',
  			),		
),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('oqc_Category','oqc_Category', array('basic','assignable'));
$dictionary['oqc_Category']['fields']['name']['required'] = true;
