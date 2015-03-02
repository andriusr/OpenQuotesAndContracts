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
$dictionary["oqc_task_users"] = array (
 'table' => 'oqc_task_users',
	'fields' => array(
		array(	'name'			=> 'id',
				'type'			=> 'varchar',
				'len'			=> '36',
		),
		array(	'name'			=> 'oqc_task_id',
				'type'			=> 'varchar',
				'len'			=> '36',
		),
		array(	'name'			=> 'user_id',
				'type'			=> 'varchar',
				'len'			=> '36', 
		),
		array(	'name'			=> 'progress',
				'type'			=> 'varchar',
				'len'			=> '25',
				'default'		=> '',
		),
		array(	'name'			=> 'accept_status', 
				'type'			=> 'varchar', 
				'len'			=> '25', 
				'default'		=> '',
		),
		array(	'name'			=> 'date_modified',
				'type'			=> 'datetime',
		),
		array(	'name'			=> 'deleted',
				'type'			=> 'bool', 
				'len'			=> '1', 
				'default'		=> '0', 
				'required'		=> false,
		),
		array (
    			'name' => 'resolution',
    			'type' => 'varchar',
    			'len' => '25',
    	),
  	   array (
    			'name' => 'comment',
    			'type' => 'text',
    			'default' => '',
    	),
    	array (
     			'name' => 'attachmentsequence',
    			'type' => 'text',
    			'default' => '',
  		),
  		array (
     			'name' => 'position',
    			'type' => 'varchar',
    			'len'			=> '4', 
  		),
  	),
	'indices' => array(
		array(	'name'			=> 'oqc_task_usersspk', 
				'type'			=> 'primary', 
				'fields'		=> array('id'),
		),
		array(	'name'			=> 'idx_usr_oqc_task1', 
				'type'			=> 'index', 
				'fields'		=> array('oqc_task_id'),
		),
		array(	'name'			=> 'idx_usr_users2', 
				'type'			=> 'index', 
				'fields'		=> array('user_id'),
		),
		array(	'name'			=> 'idx_oqc_task_users', 
				'type'			=> 'alternate_key', 
				'fields'		=> array('oqc_task_id', 'user_id'),
		),
	),
	'relationships' => array(
		'oqc_task_users' => array(
			'lhs_module'		=> 'oqc_Task',
			'lhs_table'			=> 'oqc_task', 
			'lhs_key'			=> 'id',
			'rhs_module'		=> 'Users', 
			'rhs_table'			=> 'users', 
			'rhs_key'			=> 'id',
			'relationship_type'	=> 'many-to-many',
			'join_table'		=> 'oqc_task_users', 
			'join_key_lhs'		=> 'oqc_task_id', 
			'join_key_rhs'		=> 'user_id',
	//		'relationship_role_column' => 'user_id',
		),
	),
);
?>
