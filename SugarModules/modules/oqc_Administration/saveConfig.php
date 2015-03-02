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
/*********************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/oqc_Task/oqc_Task.php');
require_once('modules/Users/User.php');




		
		if (!isset($_POST["user_status"])) {
			return;
			}

		$task = new oqc_Task();
		
		for ($i = 0; $i < count($_POST["user_status"]); $i++) {
			$user_data = array();
			if ($_POST["user_status"][$i] == 'delete') {
				$user_data = explode(':', $_POST['users_ids'][$i]);
				$module_name = $user_data[0];
				$user_id = $user_data[1];
				$user = new User();
				
				if ($user->retrieve($user_id)) {
					$task->deleteDefaultUser($user_id);
					}
				else { $GLOBALS['log']->error("This is not a valid user id: $user_id");}
				
			} 
			elseif ($_POST["user_status"][$i] == 'new') {
				
				$user_data = explode(':', $_POST['users_ids'][$i]);
				$module_name = $user_data[0];
				$user_id = $user_data[1];
				$user = new User();
				if ($user->retrieve($user_id)) {
					$task->addDefaultUser($user_id, $module_name);
					}
				else { $GLOBALS['log']->error("This is not a valid user id: $user_id");}

				
			}
		}

header("Location: index.php?action={$_POST['return_action']}&module={$_POST['return_module']}");


?>