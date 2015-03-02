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
$dictionary['oqc_Service'] = array(
	'table'=>'oqc_service',
	'audited'=>false,
	'fields'=>array (
  'product_id' => 
  array (
    'required' => false,
    'name' => 'product_id',
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
//1.7.7 New field for fixing item position in the table
    'position' => 
  array (
    'required' => false,
    'name' => 'position',
    'vname' => 'LBL_POSITION',
    'type' => 'int',
    'massupdate' => 0,
    //'default' => '1',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '11',
  ),
  //1.7.8 type change to float to allow fractional quantities like kg or m
  'quantity' => 
  array (
    'required' => '1',
    'name' => 'quantity',
    'vname' => 'LBL_QUANTITY',
    'type' => 'float',
    'dbType' => 'double',
    'massupdate' => 0,
    'default' => '1',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '18',
  //  'disable_num_format' => '',
  ),
  'price' => 
  array (
    'required' => '1',
    'name' => 'price',
    'vname' => 'LBL_PRICE',
    'type' => 'float',
    'dbType' => 'double',
    'massupdate' => 0,
    'default' => 0.0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '18',
    'precision' => '',
  ),
  'discount_value' => 
  array (
    'required' => '1',
    'name' => 'discount_value',
    'vname' => 'LBL_DISCOUNT',
    'type' => 'float',
    'dbType' => 'double',
    'massupdate' => 0,
    'default' => '0',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '18',
    'precision' => '',
  ),
  'vat' => 
  array (
    'required' => false,
    'name' => 'vat',
    'vname' => 'LBL_VAT',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
  ),
  // 1.7.8 new vat field for selectable vat value 
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
    'audited' => 0,
    'reportable' => 0,
    'options' => 'oqc_vat_list',
    'studio' => 'visible',
  ),
  
  'zeitbezug' => 
  array (
    'required' => false,
    'name' => 'zeitbezug',
    'vname' => 'LBL_ZEITBEZUG',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'once',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => 100,
    'options' => 'zeitbezug_list',
    'studio' => 'visible',
  ),
  'discount_select' => 
    array (
      'required' => false,
      'name' => 'discount_select',
      'vname' => 'LBL_DISCOUNT_SELECT',
      'type' => 'enum',
      'massupdate' => 0,
      'default' => 'rel',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'len' => 100,
      'options' => 'discount_select_list',
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
      'audited' => 0,
      'reportable' => 0,
      'len' => 100,
      'options' => 'unit_list',
      'studio' => 'visible',
  ), 
  //1.7.8 currency field 
  'service_currency_id' => 
    array (
      'required' => false,
      'name' => 'service_currency_id',
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
),
	'relationships'=>array (
),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('oqc_Service','oqc_Service', array('basic','assignable'));

$dictionary['oqc_Service']['fields']['name']['required'] = false;
$dictionary['oqc_Service']['fields']['description']['required'] = false;
