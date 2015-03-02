<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
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
 */



$module_name = 'oqc_Task';
$listViewDefs[$module_name] = array(
	'ISDONE' => array(
		'width' => '5', 
		'label' => 'LBL_ISDONE', 
		'default' => true,
		'link' => false,
      ),  
	'NAME' => array(
		'width' => '25', 
		'label' => 'LBL_NAME', 
		'default' => true,
        'link' => true),  
        
    'SVNUMBER' => array(
    	 'width' => '10', 
        'label' => 'LBL_SVNUMBER', 
        'link' => false,
        'default' => true),
           

    'PARENT_NAME' => array(
        'width'   => '15', 
        'label'   => 'LBL_LIST_RELATED_TO',
        'dynamic_module' => 'PARENT_TYPE',
        'id' => 'PARENT_ID',
        'link' => true, 
        'default' => true,
        'sortable' => false,        
        'ACLTag' => 'PARENT',
        'related_fields' => array('parent_id', 'parent_type')), 
        
     'DATE_START' => array(
        'width' => '15', 
        'label' => 'LBL_LIST_START_DATE', 
        'link' => false,
        'default' => true),
        
      'DATE_DUE' => array(
        'width' => '15', 
        'label' => 'LBL_LIST_DUE_DATE', 
        'link' => false,
        'default' => true),
          
       'PRIORITY' => array(
        'width' => '10', 
        'label' => 'LBL_PRIORITY', 
        'link' => false,
        'default' => true), 
        
     'PROGRESS' => array(
        'width' => '5', 
        'label' => 'LBL_PROGRESS_GENERAL', 
        'link' => false,
        'default' => true),
        
         
      'APPROVAL_RATIO' => array(
        'width' => '5', 
        'label' => 'LBL_APPROVAL', 
        'link' => false,
        'default' => true),           
    
    'ASSIGNED_USER_NAME' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_ASSIGNED_TO_NAME',
        'module' => 'Employees',
        'id' => 'ASSIGNED_USER_ID',
        'default' => true),
   
    'STATUS' => array(
        'width' => '10', 
        'label' => 'LBL_LIST_STATUS', 
        'link' => false,
        'default' => false),
	'DATE_ENTERED' => array (
	    'width' => '15',
	    'label' => 'LBL_DATE_ENTERED',
	    'default' => true), 
	 'CONJUGATE' => array(
		'width' => '5', 
		'label' => 'LBL_CONJUGATE', 
		'default' => false,
      ),             






	
);
?>
