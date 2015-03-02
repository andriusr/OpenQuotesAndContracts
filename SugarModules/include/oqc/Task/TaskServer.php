<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2011 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  This class is used to include the json server config inline. Previous method
 * of using <script src=json_server.php></script> causes multiple server hits per page load
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('include/utils/db_utils.php');
require_once('modules/oqc_Task/oqc_Task.php');
require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('modules/oqc_Offering/oqc_Offering.php');
require_once('modules/oqc_Addition/oqc_Addition.php');
require_once('modules/oqc_ProductCatalog/oqc_ProductCatalog.php');
require_once('modules/Documents/Document.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');

global $app_strings, $json;
$json = getJSONobj();

class oqc_json_server {
	var $global_registry_var_name = 'OQC_DATA';

	function get_oqc_task_data($id, $view, $parent_module = null, $parent_id, $getStrings = false) {
		global $current_user;
		global $json;
		$str = '';
		$str .= "\nvar ". $this->global_registry_var_name." = new Object();\n";
	
		$userTableArray = $this->task_retrieve($id, $view, $parent_module, $parent_id);
		$str .= "\n".$this->global_registry_var_name.".task_data = ". $json->encode($userTableArray).";\n";
		if($getStrings)	{
			$str .= $this->getStringsJSON('oqc_Task'); }
	
		return array($str, $userTableArray);
	}
	

	function task_retrieve($task_id, $view, $parent_module=null, $parent_id) {

		global $current_user;
		$is_done = false;
		$task = new oqc_Task(); //This might be not required, since if we are at this point, the task could not be unset
		if (!empty($task_id) && $task->retrieve($task_id)) {
			$user_beans = $this->get_oqc_task_users($task_id); 
			$is_done = $task->isdone ? true : false;	
			} else {
				$user_beans = $this->get_oqc_task_default_users($parent_module, $parent_id);	
				}
			$user_array = array();
			if (!empty($user_beans) ) {
			
				foreach($user_beans as $user) {
					//Here we assemble all user information into array for later transfer to browser
					$user_data = array(); 
					
					$user_data = array(
								'User_id' => $user->id,
								'Name' => $user->first_name.' '.$user->last_name,
								'Progress' => $user->progress,
								'Accepted' => $user->accept_status,
								'Resolution' => $user->resolution,
								'Description' => from_html($user->comment),
								'Position' => $user->position,
								'DateModified' => $user->oqc_task_date_modified,
								'isEdtRow' => ($user->id == $current_user->id && $view == 'EditView' && !$is_done) ? true : false,
								'Attachments' => array(),
								);
								
					$attachments = $this->get_oqc_task_attachments($user->attachmentsequence);
					if (!empty($attachments)) {
						foreach($attachments as $attachment) {
							$rev_number = $attachment->revision ? ('_rev.' . $attachment->revision) : '';
							$rev_id = $attachment->doc_rev_id ? $attachment->doc_rev_id : $attachment->document_revision_id;
							$attachment_data = array();
							$attachment_data["id"] = $attachment->id;
							$attachment_data["document_name"] = from_html($attachment->document_name).$rev_number;
							$attachment_data["document_revision_id"] = $rev_id;
							$attachment_data["doc_status"] = 'saved';
							$user_data['Attachments'][] = $attachment_data;
						}
					}	
					$user_array[] = $user_data;
				}
			}
		
		return $user_array;
	
		}
	// Data that needs to be transferred to oqcTask user table
	/*  Position: tablelength,
                    Name: users.user_name,
                    Accepted: languageStrings.NotAccepted,
                    Resolution: languageStrings.'',
                    Progress: languageStrings.NotStarted,
                    Description: "",
                    Attachments: "",
                    User_id: users.user_id,
                    isEdtRow: false	
	*/	
		
		
	// returns beans of users participating in oqc_task with some extra fields that are required for oqc_task	
	function get_oqc_task_users($task_id) {
		global $timedate;
		$template = new User();
		// First, get the list of IDs.
		$query = "SELECT oqc_task_users.progress, oqc_task_users.accept_status, oqc_task_users.user_id, oqc_task_users.resolution, oqc_task_users.comment, oqc_task_users.attachmentsequence, oqc_task_users.date_modified, oqc_task_users.position   from oqc_task_users where oqc_task_users.oqc_task_id='$task_id' AND oqc_task_users.deleted=0 order by oqc_task_users.position";
		//$GLOBALS['log']->error("Finding linked records for oqc_Task: ".$query);
		$result = $template->db->query($query, true);
		$list = array();

		while($row = $template->db->fetchByAssoc($result)) {
			$template = new User(); 
			$record = $template->retrieve($row['user_id']);
			
			
			if($record != null) {
				
				$template->progress = $row['progress'];
				$template->accept_status = $row['accept_status'];
				$template->resolution = $row['resolution'];
				$template->comment = $row['comment'];
				$template->attachmentsequence = $row['attachmentsequence'];
				$template->position = $row['position'];
				$template->oqc_task_date_modified = $timedate->to_display_date_time($row['date_modified']);
				// this copies the object into the array
				$list[] = $template;
			}
		}
		return $list;
	}
	
	function get_oqc_task_default_users($parent_module, $parent_id) {
		
		global $current_user;
		$list = array();
		$users_ids = array();
		$template = new User();
		$i =1;
		// At first, fill in current user
		$current = $this->fill_user_details($current_user->id, $i);
		if ($current) {
		$users_ids[] = $current_user->id;
		$list[] = $current;
		$i++;			
		}
		// Next, get default users from default table
		
		$query = "SELECT oqc_default.user_id   from oqc_default where oqc_default.module='$parent_module' AND oqc_default.deleted=0";
		//$GLOBALS['log']->error("Finding default users for ". $parent_module .": ".$query);
		$result = $template->db->query($query, true);
		
		while($row = $template->db->fetchByAssoc($result)) {
			
			if (!in_array($row['user_id'], $users_ids)) {
				$default = $this->fill_user_details($row['user_id'], $i);
				if ($default) {
				$users_ids[] = $row['user_id'];
				$list[] = $default;
				$i++;
				}
			}
		}
		
		// last, add users from parent module ( Products; Quotes/Contracts/Additions; ProductCatalog - there are 3 distinct cases
		
		if (!empty($parent_id) && !empty($parent_module)) {
			$bean = new $parent_module();
			if ($bean->retrieve($parent_id)) {
				switch($parent_module) {
					case 'oqc_Product' :
					
						if (!empty($bean->personincharge_id) && !in_array($bean->personincharge_id, $users_ids)) { 
						$personincharge = $this->fill_user_details($bean->personincharge_id, $i);
						if ($personincharge) {
						$users_ids[] = $bean->personincharge_id;
						$list[] = $personincharge;
						$i++;
						}
						}
						if (!empty($bean->assigned_employee_id) && !in_array($bean->assigned_employee_id, $users_ids)) { 
						$assignedemployee = $this->fill_user_details($bean->assigned_employee_id, $i);
						if ($assignedemployee) {
						$users_ids[] = $bean->assigned_employee_id;
						$list[] = $assignedemployee;
						$i++;
						}
						}	
						break;
					case 'oqc_Offering' :
					case 'oqc_Contract' :
					case 'oqc_Addition' :
						if (!empty($bean->technicalcontact_id) && !in_array($bean->technicalcontact_id, $users_ids)) { 
						$technicalcontact = $this->fill_user_details($bean->technicalcontact_id, $i);
						if ($technicalcontact) {
						$users_ids[] = $bean->technicalcontact_id;
						$list[] = $technicalcontact;
						$i++;
						}
						}
						if (!empty($bean->contactperson_id) && !in_array($bean->contactperson_id, $users_ids)) { 
						$contact = $this->fill_user_details($bean->contactperson_id, $i);
						if ($contact) {
						$users_ids[] = $bean->contactperson_id;
						$list[] = $contact;
						$i++;
						}
						}
						break;
					case 'oqc_ProductCatalog' :
						if (!empty($bean->assigned_user_id) && !in_array($bean->assigned_user_id, $users_ids)) { 
						$assigned = $this->fill_user_details($bean->assigned_user_id, $i);
						if ($assigned) {
						$users_ids[] = $bean->assigned_user_id;
						$list[] = $assigned;
						$i++;
						}
						}
						break;
				}
			}	
		}

		return $list;
	}
	
	//For default users
	function fill_user_details($id, $i) {
		global $app_list_strings;
		global $mod_strings;
		$template = new User();
		if ($template->retrieve($id)) {
		//	$template->progress = $app_list_strings['oqc_dropdowns_default']['oqc_progress_default_key'];
			$template->progress = $mod_strings['LBL_PROGRESS_DEFAULT'];
		//	$template->accept_status = $app_list_strings['oqc_dropdowns_default']['oqc_accept_status_default_key'];
			$template->accept_status = $mod_strings['LBL_ACCEPTED_DEFAULT'];
		//	$template->resolution = $app_list_strings['oqc_dropdowns_default']['oqc_resolution_default_key'];
			$template->resolution = $mod_strings['LBL_RESOLUTION_DEFAULT'];
			$template->comment = '';
			$template->attachmentsequence = '';
			$template->position = $i;
			$template->oqc_task_date_modified = '';
				// this copies the object into the array
			return $template;
			}
		return null;
		}
	
	function get_oqc_task_attachments($attachmentsequence) {
		if (empty($attachmentsequence)) {
			return '';
			}
		$attachmentIds = explode(' ', trim($attachmentsequence));
		$attachments = array();
		
		foreach ($attachmentIds as $id) {
			$revision = new DocumentRevision();
			if (!$revision->retrieve($id)) {
				// if in old format try to recover by document id	
			
					$attachment = new Document();

					if ($attachment->retrieve($id)) {
						$attachment->revision = '';
						$attachment->doc_rev_id = '';
						$attachments[] = $attachment;
					}
			} else {
				$attachment = new Document();
				if ($attachment->retrieve($revision->document_id)) {
					$attachment->revision = $revision->revision;
					$attachment->doc_rev_id = $revision->id;
					$attachments[] = $attachment;
				}
			
			}
		}
		
		return $attachments;
	}

	

	function getStringsJSON($module) {
	  global $current_language;
	  global $json;
	
	  $currentModule = $module;
	  $mod_strings = return_module_language($current_language,$currentModule);
	  return  "\n".$this->global_registry_var_name.".languageStrings =  ". $json->encode($mod_strings)."\n";
	}


	}
?>
