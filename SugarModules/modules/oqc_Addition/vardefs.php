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
$dictionary['oqc_Addition'] = array(
	'table'=>'oqc_addition',
	'audited'=>true,
	'fields'=>array (
  'contractid' => 
  array (
    'required' => false,
    'name' => 'contractid',
    'vname' => 'LBL_CONTRACTID',
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
    array(
      'name' => 'getLinkToContract',
      'returns' => 'html',
      'include' => 'include/oqc/Contracts/Contracts.php',    
    )
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
		'relationship' => 'oqc_task_oqc_addition',
		'source' => 'non-db',
		'vname' => 'LBL_OQC_TASK',
  		), 
),
	'relationships'=>array (
	'oqc_task_oqc_addition' => 
    array (
      'lhs_module' => 'oqc_Addition',
      'lhs_table' => 'oqc_addition',
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
VardefManager::createVardef('oqc_Addition','oqc_Addition', array('basic','assignable','issue','oqc_contract_base'));

$dictionary['oqc_Addition']['fields']['name']['required'] = true;

// disable massupdate for default fields
$dictionary['oqc_Addition']['fields']['created_by_name']['massupdate'] = 0;
$dictionary['oqc_Addition']['fields']['assigned_user_id']['massupdate'] = 1;
$dictionary['oqc_Addition']['fields']['status']['massupdate'] = 1;
$dictionary['oqc_Addition']['fields']['type']['massupdate'] = 0;
$dictionary['oqc_Addition']['fields']['resolution']['massupdate'] = 0;
$dictionary['oqc_Addition']['fields']['priority']['massupdate'] = 0;

//1.7.6 Make Additions abbreviation list different from contracts
$dictionary['oqc_Addition']['fields']['abbreviation']['options'] = 'addition_abbreviation_list';
$dictionary['oqc_Addition']['fields']['abbreviation']['default'] = 'Ad';
//2.0 Default template for each module
$dictionary['oqc_Addition']['fields']['oqc_template']['default'] = 'Addition';
?>
