<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
$module_name = 'oqc_Contract';
$_object_name = 'oqc_contract';
$searchFields[$module_name] = 
	array (
		'name' => array( 'query_type'=>'default'),
        'status'=> array('query_type'=>'default', 'options' => $_object_name.'_status_dom', 'template_var' => 'STATUS_OPTIONS'),
        'priority'=> array('query_type'=>'default', 'options' => $_object_name. '_priority_dom', 'template_var' => 'PRIORITY_OPTIONS'),
		'resolution'=> array('query_type'=>'default', 'options' => $_object_name. '_resolution_dom', 'template_var' => 'RESOLUTION_OPTIONS'),
		$_object_name. '_number'=> array('query_type'=>'default','operator'=>'in'),
		'current_user_only'=> array('query_type'=>'default','db_field'=>array('assigned_user_id'),'my_items'=>true),
		'assigned_user_id'=> array('query_type'=>'default'),
		'company'=> array('query_type'=>'default','db_field'=>array('accounts.name')),
		'contactperson_id'=> array('query_type'=>'default'),
		//Range Search Support 
	  
       'range_total_cost' => array ('query_type' => 'default', 'enable_range_search' => true),
	   'start_range_total_cost' => array ('query_type' => 'default',  'enable_range_search' => true),
       'end_range_total_cost' => array ('query_type' => 'default', 'enable_range_search' => true),
       
        'range_grand_total' => array ('query_type' => 'default', 'enable_range_search' => true),
	   'start_range_grand_total' => array ('query_type' => 'default',  'enable_range_search' => true),
       'end_range_grand_total' => array ('query_type' => 'default', 'enable_range_search' => true),
       
        'range_startdate' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
	   'start_range_startdate' => array ('query_type' => 'default',  'enable_range_search' => true, 'is_date_field' => true),
	   'end_range_startdate' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
	   
	   'range_enddate' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),
	   'start_range_enddate' => array ('query_type' => 'default',  'enable_range_search' => true, 'is_date_field' => true),
       'end_range_enddate' => array ('query_type' => 'default', 'enable_range_search' => true, 'is_date_field' => true),	
              
		//Range Search Support 
		
		
	);
?>
