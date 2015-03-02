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
$dictionary['oqc_Task'] = array(
	'table'=>'oqc_task',
	'audited'=>true,
	'fields'=>array (
	
	'name' =>
  array (
    'name' => 'name',
    'vname' => 'LBL_SUBJECT',
    'dbType' => 'varchar',
    'link' => true, // bug 39288 
    'type' => 'name',
    'len' => '50',
	'unified_search' => true,
    'importable' => 'required',
    'required' => 'true',
    'audited' => 1,
  ),
  
  'oqc_task_number' => array (
			'name' => 'oqc_task_number',
			'vname' => 'LBL_NUMBER',
			'type' => 'int',
         'readonly' => true,
			'len' => 11,
			'required' => true,
			'auto_increment' => true,
			'unified_search' => true,
			'comment' => 'Visual unique identifier',
			'duplicate_merge' => 'disabled',
			'disable_num_format' => true,
		),
	 'abbreviation' => 
  array (
    'required' => true,
    'name' => 'abbreviation',
    'vname' => 'LBL_ABBREVIATION',
    'type' => 'enum',
    'massupdate' => 0,
    'default' => 'Tsk',
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'len' => 50,
    'options' => 'oqc_task_abbreviation_list',
    'studio' => 'visible',
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
		
  'status' =>
  array (
    'name' => 'status',
    'vname' => 'LBL_STATUS',
    'type' => 'enum',
    'options' => 'oqc_task_status_list',
    'len' => 100,
    'required' => 'true',
    'default' => 'Not Started',
    'audited' => 1,
  ),
  'date_due_flag' =>
  array (
    'name' => 'date_due_flag',
    'vname' => 'LBL_DATE_DUE_FLAG',
    'type' =>'bool',
    'default'=>0,
    'group'=>'date_due',
  	'studio' => false,
  ),
  'date_due' =>
  array (
    'name' => 'date_due',
    'vname' => 'LBL_DUE_DATE',
    'type' => 'datetimecombo',
    'dbType' => 'datetime',
    'required' => 'true',
    'group'=>'date_due',
    'studio' => array('required' => true, 'no_duplicate' => true),
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
    'audited' => 1,
    ),
  
  'date_start_flag' =>
  array (
    'name' => 'date_start_flag',
    'vname' => 'LBL_DATE_START_FLAG',
    'type' =>'bool',
    'group'=>'date_start',
    'default'=>0,
  	'studio' => false,
  ),
  'date_start' =>
  array (
    'name' => 'date_start',
    'vname' => 'LBL_START_DATE',
    'type' => 'datetimecombo',
    'dbType' => 'datetime',
    'group'=>'date_start',
    'required' => 'true',
    'validation' => array('type' => 'isbefore', 'compareto' => 'date_due', 'blank' => false),
    'studio' => array('required' => true, 'no_duplicate' => true),
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
     'audited' => 1,
    ),
    
     'notify'=>
   array(
    'name' => 'notify',
    'vname' => 'LBL_NOTIFY',
    'type' => 'bool',
    'default' => true,
    'comment' => 'Checkbox indicating if Users should be notified on assignment',
    'massupdate'=>false,
     'audited' => 1,
   ),
    
    
    'remind'=>
   array(
    'name' => 'remind',
    'vname' => 'LBL_REMINDER',
    'type' => 'bool',
    'default' => true,
    'comment' => 'Checkbox indicating if Users should be reminded after due date',
    'massupdate'=>false,
     'audited' => 1,
   ),

  'reminder_interval' =>
  array (
    'name' => 'reminder_interval',
    'vname' => 'LBL_REMINDER_INTERVAL',
    'type' => 'int',
    'function' => array('name'=>'getReminderTime', 'returns'=>'html', 'include'=>'include/oqc/Task/Reminder.php' ),
    'reportable' => false,
    'default'=>-1,
    'comment' => 'Specifies interval between reminders; -2 means once; otherwise the number of days'
  ),
  
  'date_reminder' =>
  array (
    'name' => 'date_reminder',
    'vname' => 'LBL_REMINDER_DATE',
    'type' => 'datetime',
    'dbType' => 'datetime',
    'studio' => false,
    'audited' => 0,
    ),
  
 'parent_type'=>
  array(
  	'name'=>'parent_type',
  	'vname'=>'LBL_PARENT_NAME',
    'type' => 'parent_type',
    'dbType'=>'varchar',
  	 'group'=>'parent_name',
  	'required'=>false,
	'len'=>'255',
    'comment' => 'The Sugar object to which the oqc_Task is related',
    'options' => 'oqc_parent_type_display_list',
),

  'parent_name'=>
  array(
	'name'=> 'parent_name',
	'parent_type'=>'record_type_display' ,
	'type_name'=>'parent_type',
	'id_name'=>'parent_id',
    'vname'=>'LBL_LIST_RELATED_TO',
	'type'=>'parent',
	'group'=>'parent_name',
	'source'=>'non-db',
	'options'=> 'oqc_parent_type_display_list',
  ),

  'parent_id' =>
  array (
    'name' => 'parent_id',
    'type' => 'id',
    'group'=>'parent_name',
    'reportable'=>false,
    'vname'=>'LBL_PARENT_ID',
  ),
 
  
  
  'priority' =>
  array (
    'name' => 'priority',
    'vname' => 'LBL_PRIORITY',
    'type' => 'enum',
    'options' => 'oqc_task_priority_list',
    'len' => 100,
    'required' => 'true',
     'default' => 'Medium',
  ),
  
  'progress' => 
  array (
    'required' => false,
    'name' => 'progress',
    'vname' => 'LBL_PROGRESS_GENERAL',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
   ),
   
   'approval_ratio' => 
  array (
    'required' => false,
    'name' => 'approval_ratio',
    'vname' => 'LBL_APPROVAL',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
   ),
  
  
  
	'oqc_product'=>	array(
		'name' => 'oqc_product',
		'type' => 'link',
		'relationship' => 'oqc_task_oqc_product',
		'source'=>'non-db',
		'vname'=>'LBL_OQC_PRODUCT',
	),
	'oqc_contract'=>	array(
		'name' => 'oqc_contract',
		'type' => 'link',
		'relationship' => 'oqc_task_oqc_contract',
		'source'=>'non-db',
		'vname'=>'LBL_OQC_CONTRACT',
	),
	'oqc_offering'=>	array(
		'name' => 'oqc_offering',
		'type' => 'link',
		'relationship' => 'oqc_task_oqc_offering',
		'source'=>'non-db',
		'vname'=>'LBL_OQC_OFFERING',
	),
	'oqc_addition'=>	array(
		'name' => 'oqc_addition',
		'type' => 'link',
		'relationship' => 'oqc_task_oqc_addition',
		'source'=>'non-db',
		'vname'=>'LBL_OQC_ADDITION',
	), 
 
    'fellowtasks' =>
  array (
  	'name' => 'fellowtasks',
    'type' => 'link',
    'relationship' => 'oqctask_fellowtasks',
    'module'=>'oqc_Task',
    'bean_name'=>'oqc_Task',
    'source'=>'non-db',
	 'vname'=>'LBL_TASK',
  ),
  'oqctask' =>
  array (
  	'name' => 'oqctask',
    'type' => 'link',
    'relationship' => 'oqctask_fellowtasks',
    'module'=>'oqc_Task',
    'bean_name'=>'oqc_Task',
    'source'=>'non-db',
	 'vname'=>'LBL_TASK',
  ),
  
  'notes' =>
  array (
  	'name' => 'notes',
    'type' => 'link',
    'relationship' => 'oqc_task_notes',
    'module'=>'Notes',
    'bean_name'=>'Note',
    'source'=>'non-db',
	 'vname'=>'LBL_NOTES',
  ),
  
   'userslist' => 
  array (
    'required' => false,
    'name' => 'userslist',
    'vname' => 'LBL_USERSLIST',
    'type' => 'varchar',
    'function' => 
    array (
      'name' => 'getUsersListHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Task/UsersList.php',
    ),
  ),
  
  'users' =>
  array (
  	'name' => 'users',
    'type' => 'link',
    'relationship' => 'oqc_task_users',
    'source'=>'non-db',
	 'vname'=>'LBL_USERS',
  ), 
  
  'isdone' => 
  array (
    'required' => false,
    'name' => 'isdone',
    'vname' => 'LBL_ISDONE',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'studio' => false,
   ),
  
  'conjugate' => 
  array (
    'required' => false,
    'name' => 'conjugate',
    'vname' => 'LBL_CONJUGATE',
    'type' => 'bool',
    'default' => true,
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    ),
    
    
),
	'relationships'=>array (
	
	'oqctask_fellowtasks' => array(
			'lhs_module'		=> 'oqc_Task',
			'lhs_table'			=> 'oqc_task',
			'lhs_key'			=> 'id',
			'rhs_module'		=> 'oqc_Task',
			'rhs_table'			=> 'oqc_task',
			'rhs_key'			=> 'parent_id',
			'relationship_type'	=> 'one-to-many',
		),	
	'oqc_task_notes' => 
    array (
      'lhs_module' => 'oqc_Task',
      'lhs_table' => 'oqc_task',
      'lhs_key' => 'id',
      'rhs_module' => 'Notes',
      'rhs_table' => 'notes',
      'rhs_key' => 'parent_id',
      'relationship_type' => 'one-to-many',
    ),
	
	'oqc_task_assigned_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'oqc_Task', 'rhs_table'=> 'oqc_task', 'rhs_key' => 'assigned_user_id',
   'relationship_type'=>'one-to-many'),

   'oqc_task_modified_user' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'oqc_Task', 'rhs_table'=> 'oqc_task', 'rhs_key' => 'modified_user_id',
   'relationship_type'=>'one-to-many'),

   'oqc_task_created_by' =>
   array('lhs_module'=> 'Users', 'lhs_table'=> 'users', 'lhs_key' => 'id',
   'rhs_module'=> 'oqc_Task', 'rhs_table'=> 'oqc_task', 'rhs_key' => 'created_by',
   'relationship_type'=>'one-to-many'),
	
	
),

	'indices' => array (
	
    	 array('name' => 'oqc_tasknumk', 'type' => 'unique','fields' => array ('oqc_task_number')),
       array('name' =>'idx_oqc_tsk_name', 'type'=>'index', 'fields'=>array('name')),
       array('name' =>'idx_oqc_tsk_par_del', 'type'=>'index', 'fields'=>array('parent_id','parent_type','deleted')),
       array('name' => 'idx_oqc_tsk_stat_del', 'type' => 'index', 'fields'=> array('assigned_user_id', 'status', 'deleted')),
       ),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('oqc_Task','oqc_Task', array('basic','assignable'));
