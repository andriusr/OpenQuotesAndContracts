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
$module_name = 'oqc_Task';
$viewdefs[$module_name]['DetailView'] = array(
		'templateMeta' => 
    		array (
      	'includes' => array(
            // neccessary for yui datatable
            array('file' => 'include/oqc/Services/yuiBuild/yahoo-dom-event/yahoo-dom-event.js'),
            //array('file' => 'include/oqc/Services/yuiBuild/calendar/calendar-min.js'),
           // array('file' => 'include/oqc/Services/yuiBuild/dragdrop/dragdrop-min.js'),
            array('file' => 'include/oqc/Services/yuiBuild/element/element-min.js'),
            array('file' => 'include/oqc/Services/yuiBuild/datasource/datasource-min.js'),
           // array('file' => 'include/oqc/Services/yuiBuild/connection/connection-min.js'),
            array('file' => 'include/oqc/Services/yuiBuild/datatable/datatable-min.js'),
            array('file' => 'include/oqc/Services/yuiBuild/json/json-min.js'),
          //array('file' => 'include/javascript/quicksearch.js'),
          // neccessary for setting up products table
          //array('file' => 'include/JSON.js'),
          array('file' => 'include/oqc/common/OQC.js'),
       // 	 array('file' => 'include/oqc/Task/Attachments.js'),
          array('file' => 'include/oqc/Task/UsersList.js'),
      	),
      	'form' => 
      		array (
        		'buttons' => 
        		array (
          		'EDIT',
          		'DUPLICATE',
          		'DELETE',
         	),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
    ),
 'panels' => 
    array (
      'LBL_PANEL_GENERAL' => 
      array (
         
        array (
           
          array (
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
          array(
            'name' => 'svnumber',
            'label' => 'LBL_SVNUMBER',
            ),
        ),
        array (
        	'status',
        	array(),
        
        
        
        ),
         
        array (
           'date_start',
           
          array (
            'name' => 'parent_name',
            'customLabel' => '{sugar_translate label=\'LBL_MODULE_NAME\' module=$fields.parent_type.value}',
          ),
        ),
         
        array (
           'date_due',
           
          array (
          ),
        ),
         
        array (
           'priority',
           array (
            'name' => 'notify',
            'label' => 'LBL_NOTIFY',
          ),
        ),
        
        array (
           
          array (
            'name' => 'progress',
            'label' => 'LBL_PROGRESS_GENERAL',
            
          ),
          array (
            'name' => 'remind',
            'fields' => 
            array (
              'remind',
              'reminder_interval',
            ),
            'label' => 'LBL_REMINDER',
          ),
           
        ),
        
         array (
           
          array (
            'name' => 'approval_ratio',
            'label' => 'LBL_APPROVAL',
            
          ),
          array (
            'name' => 'conjugate',
            'label' => 'LBL_CONJUGATE',
          ),
           
        ),
         
        array (
           'description',
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' => 
      array (
         
        array (
           
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
          
        ),
         
        array (
           
          array (
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
            'label' => 'LBL_DATE_ENTERED',
          ),
           
          array (
            'name' => 'date_modified',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
      ),
      
      'LBL_PANEL_USER_LIST' =>
      array(
      
      	array(
      	
      		array(
      		  'name'=> 'userslist',
      		  'label' => 'LBL_USERSLIST',
      		  ),
      	),
      		
        array(
          0 => 
          array(),
          1 =>
          array(),
        ),         
      ),
      
     ),
);
?>
