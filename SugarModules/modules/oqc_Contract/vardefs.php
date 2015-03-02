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
$dictionary['oqc_Contract'] = array(
	'table'=>'oqc_contract',
	'audited'=>true,
	'fields'=>array (
  'idsofadditions' => 
  array (
    'required' => false,
    'name' => 'idsofadditions',
    'vname' => 'LBL_ADDITIONS',
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
  'showadditions' => 
  array (
    'required' => false,
    'name' => 'showadditions',
    'vname' => 'LBL_SHOWADDITIONS',
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
      'name' => 'getAdditionsHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Additions/Additions.php',
    ),
  ),
  'offeringid' => 
  array (
    'required' => false,
    'name' => 'offeringid',
    'vname' => 'LBL_OFFERINGID',
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
      'name' => 'getLinkToOffering',
      'returns' => 'html',
      'include' => 'include/oqc/Offerings/Offerings.php',
    ),
  ),
  'signedcontractdocument_id' =>
  array (
    'required' => false,
    'name' => 'signedcontractdocument_id',
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
    'studio' => 'false',
  ),
  'signedcontractdocument' =>
  array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'signedcontractdocument',
    'vname' => 'LBL_SIGNEDCONTRACTDOCUMENT',
    'type' => 'relate',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => '255',
    'id_name' => 'signedcontractdocument_id',
    //'ext2' => 'Documents',
    'table' => 'documents',
    'module' => 'Documents',
    'studio' => 'visible',
    'rname' => 'name',
 //   'link' => 'signedcontract_link',
  ),

  'issigned' =>
  array (
    'required' => false,
    'name' => 'issigned',
    'vname' => 'LBL_ISSIGNED',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
  ),
  'signedon' =>
  array (
    'required' => false,
    'name' => 'signedon',
    'vname' => 'LBL_SIGNEDON',
    'type' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
  ),
  'periodofnotice' =>
  array (
    'required' => false,
    'name' => 'periodofnotice',
    'vname' => 'LBL_PERIODOFNOTICE',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => '6months',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => 100,
    'options' => 'periodofnotice_list',
    'studio' => 'visible',
  ),
   //1.7.6
  'is_latest' => 
    array (
      'required' => false,
      'name' => 'is_latest',
      'vname' => 'LBL_IS_LATEST',
      'type' => 'bool',
      'massupdate' => 0,
      'default' => '1',
      'comments' => '',
      'help' => '',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => 0,
      'reportable' => 0,
      'studio' => 'false',
    ),
    //2.1 link to oqc_Task
    'oqc_task' =>
    array(
		'name' => 'oqc_task',
		'type' => 'link',
		'module' => 'oqc_Task',
		'bean_name'  => 'oqc_Task',
		'relationship' => 'oqc_task_oqc_contract',
		'source' => 'non-db',
		'vname' => 'LBL_OQC_TASK',
  ), 
),
	'relationships'=>array (
	
    'oqc_task_oqc_contract' => 
    array (
      'lhs_module' => 'oqc_Contract',
      'lhs_table' => 'oqc_contract',
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
VardefManager::createVardef('oqc_Contract','oqc_Contract', array('basic','assignable','issue','oqc_contract_base'));

$dictionary['oqc_Contract']['fields']['name']['required'] = true;
$dictionary['oqc_Contract']['fields']['startdate']['required'] = true;
$dictionary['oqc_Contract']['fields']['enddate']['required'] = false;

// disable massupdate for default fields
$dictionary['oqc_Contract']['fields']['created_by_name']['massupdate'] = 0;
$dictionary['oqc_Contract']['fields']['assigned_user_id']['massupdate'] = 1;
$dictionary['oqc_Contract']['fields']['status']['massupdate'] = 1;
$dictionary['oqc_Contract']['fields']['type']['massupdate'] = 0;
$dictionary['oqc_Contract']['fields']['resolution']['massupdate'] = 0;
$dictionary['oqc_Contract']['fields']['priority']['massupdate'] = 0;

//1.7.6 Make Contracts abbreviation list different from other modules
$dictionary['oqc_Contract']['fields']['abbreviation']['options'] = 'contract_abbreviation_list';
$dictionary['oqc_Contract']['fields']['abbreviation']['default'] = 'Cnt';
//2.0 Default template for each module
$dictionary['oqc_Contract']['fields']['oqc_template']['default'] = 'Contract';
