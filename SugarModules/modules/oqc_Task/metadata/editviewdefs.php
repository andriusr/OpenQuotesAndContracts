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
$viewdefs[$module_name]['EditView'] = array(
    'templateMeta' =>
      array (
      'includes' => 
      array(
        // yui datatable includes
        array('file' => 'include/oqc/Services/yuiBuild/yahoo-dom-event/yahoo-dom-event.js'),
        array('file' => 'include/oqc/Services/yuiBuild/get/get-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/element/element-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/datasource/datasource-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/connection/connection-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/datatable/datatable-min.js'),
        array('file' => 'include/oqc/Services/yuiBuild/json/json-min.js'),
      // oqc specific includes
        array('file' => 'include/oqc/common/OQC.js'),
        array('file' => 'include/oqc/Task/UsersList.js'),
        array('file' => 'include/oqc/CreatePopup/CreatePopup.js'),
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
     /* 'form' => 
      array (
        'buttons' => 
        array (
          0 => array('customCode' => '<input type="submit" value="{$APP.LBL_SAVE_BUTTON_LABEL}" name="button" onclick="this.form.action.value=\'Save\'; 
        return check_form(\'EditView\');" class="button" accesskey="{$APP.LBL_SAVE_BUTTON_KEY}" title="{$APP.LBL_SAVE_BUTTON_TITLE}"/>'
           ),
          1 => 'CANCEL',
 	      ),
      ), */
      
    ),
                                            
 'panels' => 
    array (
      'LBL_PANEL_GENERAL' => 
      array (
         
        array (
           
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
           
          array (
            'name' => 'abbreviation',
            'label' => 'LBL_ABBREVIATION',
          ),
        ),
        
        array (
         array (
            'name' => 'status',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
          array(),
          ),
        array (
           
          array (
            'name' => 'date_start',
            'type' => 'datetimecombo',
            'displayParams' => 
            array (
              'showNoneCheckbox' => true,
              'showFormats' => true,
            ),
          ),
           
          array (
            'name' => 'parent_name',
            'label' => 'LBL_LIST_RELATED_TO',
          ),
        ),
         
        array (
           
          array (
            'name' => 'date_due',
            'type' => 'datetimecombo',
            'displayParams' => 
            array (
              'showNoneCheckbox' => true,
              'showFormats' => true,
            ),
          ),
           
          array (
          ),
        ),
         
        array (
           
          array (
            'name' => 'priority',
            'displayParams' => 
            array (
              'required' => true,
            ),
          ),
          array (
            'name' => 'notify',
            'label' => 'LBL_NOTIFY',
          ),
           
        ),
        
         array (
           
          array (
            'name' => 'progress',
            'label' => 'LBL_PROGRESS_GENERAL',
            'customCode' => '<input type="text" title="" maxlength="255" size="30" id="progress_id" name="progress" style="background: rgba(255,255,255,0.0);" readonly="readonly" value="" />',
          ),
          array (
            'name' => 'reminder_interval',
            'label' => 'LBL_REMINDER',
            'customCode' => '{if $fields.remind.value == "1"}{assign var="REMIND_DISPLAY" value="inline"}{assign var="REMIND" value="checked"}{else}{assign var="REMIND_DISPLAY" value="none"}{assign var="REMIND" value=""}{/if}<input name="remind" type="hidden" value="0"><input name="remind" onclick=\'toggleDisplay("oqc_remind_list");\' type="checkbox" class="checkbox" value="1" {$REMIND}><div id="oqc_remind_list" style="display:{$REMIND_DISPLAY}">{$fields.reminder_interval.value}</div>',
          ),
           
        ),
        
         array (
           
          array (
            'name' => 'approval_ratio',
            'label' => 'LBL_APPROVAL',
            'customCode' => '<input type="text" title="" maxlength="255" size="30" id="approval_ratio_id" name="approval_ratio" style="background: rgba(255,255,255,0.0);" readonly="readonly" value="" />',
          ),
          array (
            'name' => 'conjugate',
            'label' => 'LBL_CONJUGATE',
          ),
           
        ),
         
        array (
           
          array (
            'name' => 'description',
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
      
	  'LBL_PANEL_ASSIGNMENT' => array(
	    array(
		    'assigned_user_name',
	    ),
	  ),
      
    ),
                        
);
?>
