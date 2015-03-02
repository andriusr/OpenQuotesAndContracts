<?php
require_once('include/MVC/Controller/SugarController.php');
require_once('include/formbase.php');
require_once('modules/oqc_Task/oqc_Task.php');
require_once('modules/Users/User.php');



class oqc_TaskController extends SugarController
{
	
	
	/* protected function sanitizeString($string) {
		$string = str_replace('\"', '"', $string);
		$string = str_replace('\\\\', '\\', $string);

		return $string;
	} */
	
	//Saves User Table data. param $update indicates whether it is new oqcTask bean or one that needs update 

	function saveUserData($update=false) {
		global $sugar_version;
	
		$RelName = 'users'; // NOTE: relationship name in lowercase! otherwise no effect
		$ModuleName = 'Users';

		if($this->bean->load_relationship($RelName)) {
			
			$newUsers = array();
	    	$deleteUsers = array();
	    	$updateUsers = array();
	    	$postUsers = array();
	    	$allUsers = array();
			require_once('include/utils.php');
			$json = getJSONobj();
			//$GLOBALS['log']->error('Users_data: attaching '. var_export($json->decode(from_html($_POST['oqcUsersJsonString'])),true));
			$allUsers = $json->decode(from_html($_POST['oqcUsersJsonString']));
			if (!empty($allUsers)) {
			//we will need to compare existing records with beeing saved in order to see if all users are still present	
			// Get users ids from the POST
			foreach ($allUsers as $user) {
				$postUsers[] = $user['_oData']['User_id'];
	    	}
			} 
			if ($update) {
			
			// Get all users from the oqc_task_users table
	    	$q = 'SELECT oqc_task_users.user_id FROM oqc_task_users WHERE oqc_task_users.oqc_task_id = \''.$this->bean->id.'\' AND oqc_task_users.deleted = 0';
	    	$r = $this->bean->db->query($q);
	    	while($row = $this->bean->db->fetchByAssoc($r)) {
	    		  if(!in_array($row['user_id'], $postUsers)) {
	    		  	 $deleteUsers[] = $row['user_id'];
	    		  } else {
	    		     $updateUsers[] = $row['user_id'];
	    		}
	    	}
			$newUsers = array_diff($postUsers, $updateUsers);
			} else { $newUsers = $postUsers;}		
			
			 			
			foreach ($allUsers as $user) {
				$userdata = $user['_oData'];
				if ($userdata['isEdtRow'] || in_array($userdata['User_id'], $newUsers) || !empty($deleteUsers)) { //Process only row that has changed or is new one
				
					// Get data for auditing if we are updating old relationship
					if (in_array($userdata['User_id'], $updateUsers)) {
						$oldRowString = '';
						$q = 'SELECT * FROM oqc_task_users WHERE oqc_task_users.oqc_task_id = \''.$this->bean->id.'\' AND oqc_task_users.user_id = \'' . $userdata['User_id'] . '\' AND oqc_task_users.deleted = 0';
						$r = $this->bean->db->query($q);
	    				while($row = $this->bean->db->fetchByAssoc($r)) {
	    				$oldRowString = $this->user_data_as_text($row);	//there should be just one row with this where statement
	    				}
					} else { $oldRowString = '<n/a>';} //else it is new user
					
					
					
					$attachments = array();
					if (!empty($userdata['Attachments'])) {
					foreach ($userdata['Attachments'] as $attachment) {
						$attachments[] = $attachment['document_revision_id'];
						
						}
					}
					
					$additional_fields = array(
					'progress' => $userdata['Progress'],
					'accept_status' => $userdata['Accepted'],
					'resolution' => $userdata['Resolution'],
					'comment' => $userdata['Description'],
					'attachmentsequence' => implode(' ',$attachments),
					'position' => $userdata['Position'],
					);
					$this->bean->load_relationship($RelName);
					$this->bean->$RelName->add($userdata['User_id'], $additional_fields);
					
					// Now get new user data that got saved 
					
					$newRowString = '';
					$q = 'SELECT * FROM oqc_task_users WHERE oqc_task_users.oqc_task_id = \''.$this->bean->id.'\' AND oqc_task_users.user_id = \'' . $userdata['User_id'] . '\' AND oqc_task_users.deleted = 0';
					$r = $this->bean->db->query($q);
	    			while($row = $this->bean->db->fetchByAssoc($r)) {
	    			$newRowString = $this->user_data_as_text($row);	//there should be just one row with this where statement
	    			}
					

					if (($oldRowString != $newRowString) && $update) {
						$changes = array('field_name' => trim($userdata['Name']), 'data_type' => 'varchar', 'before' => $oldRowString, 'after' => $newRowString);
						
						if(floatval(substr($sugar_version,0,3)) > 6.3) {
							$this->bean->db->save_audit_records($this->bean, $changes); }
						else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
					}
					
				}
			}
			// Now delete relationships 
			if (count($deleteUsers) > 0) {
			foreach ($deleteUsers as $delete_id) {
				$template = new User();
				if ($template->retrieve($delete_id)) {
					$user_name = $template->first_name. ' '. $template->last_name;
					$this->bean->$RelName->delete($this->bean->id, $delete_id);
					$changes = array('field_name' => 'User', 'data_type' => 'varchar', 'before' => $user_name, 'after' => '<deleted>');
					if(floatval(substr($sugar_version,0,3)) > 6.3) {
							$this->bean->db->save_audit_records($this->bean, $changes); }
						else { $this->bean->dbManager->helper->save_audit_records($this->bean, $changes); }
					} else { $GLOBALS['log']->error("Could not load_user ($delete_id)"); }
				
				}
			}
			return array($newUsers, $deleteUsers, $postUsers);
			
		} else {
			$GLOBALS['log']->fatal("Could not load_relationship ($RelName)");
		}
	}
	
	function user_data_as_text($row)	{
		$audited_fields = array(
					'Progress' => $row['progress'],
					'Accepted' => $row['accept_status'],
					'Resolution' => $row['resolution'],
					'Comment' => $row['comment'],
					'Attachments' => $row['attachmentsequence'],
					'Position' => $row['position'],
					);
		foreach ($audited_fields as $key => $value) {
			$textString[] = $key.':'.$value ;
			}
			return implode(' ', $textString);
	}

	
	function action_save() {
		
		global $mod_strings;
		global $timedate;
		//some default stuff allowing to remove fields from layout and still have it values set
		$notify = (isset($_POST['notify']) && $_POST['notify'] == 1) || (!isset($_POST['notify']) && $mod_strings['LBL_NOTIFY_DEFAULT'] == '1') ? true : false ;
		$remind = (isset($_POST['remind']) && $_POST['remind'] == 1) || (!isset($_POST['remind']) && $mod_strings['LBL_REMIND_DEFAULT'] == '1') ? true : false ;
		$conjugate = (isset($_POST['conjugate']) && $_POST['conjugate'] == 1) || (!isset($_POST['conjugate']) && $mod_strings['LBL_CONJUGATE_DEFAULT'] == '1') ? true : false ;
		$this->bean->notify = $notify;
		$this->bean->remind = $remind;
		$this->bean->conjugate = $conjugate;
		
		if (!isset($_POST['record']) || empty($_POST['record'])) {
			// This task is created for first time, all users are new ones
			// Generate Task svnumber at first
			
			$this->bean->save(); // we first get id and number for this bean
			//retrieve saved bean for oqc...number that is created during save
			$oqc_fld_number = $this->bean->table_name . '_number';
			$savedBean = new $this->bean->object_name ;
			if ($savedBean->retrieve($this->bean->id)) {
				$this->bean->$oqc_fld_number = intval($savedBean->$oqc_fld_number);
				}
			
			// 1.7.6 Keep generated svnumber for all future references
			if (empty($this->bean->svnumber)) {
			$this->bean->fill_in_svnumber();
			}
			$notify_array = $this->saveUserData(false);
			if ($notify) {
				$task_new = $this->bean->sendNotifications($notify_array[0], 'new');
			}
			if ($remind) {
				$this->bean->date_reminder = $timedate->to_db( $_POST['date_due']);
				} else {
				$this->bean->date_reminder = $timedate->asDb($timedate->getNow()->get("+20 years"));	
				}
			
			
			parent::action_save();
			}
			
			else {
			// Here we first need to get old bean in order to make comparison
			$oldTask = new oqc_Task();
			if ($oldTask->retrieve($_POST['record'])) {
			
				if ($oldTask->isdone == 0) {
					// Setup date_reminder based on user actions and previous bean data
					if ($remind) {
						$today = $timedate->nowDb();
						$duedate_db = $_POST['date_due'];
						// Convert all important dates to database format
						if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$_POST['date_due']) ) {
						$duedate_db = $timedate->to_db($_POST['date_due']);}
						if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$oldTask->date_due) ) {
						$oldTask->date_due = $timedate->to_db($oldTask->date_due);}
						if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$oldTask->date_reminder) ) {
						$oldTask->date_reminder = $timedate->to_db($oldTask->date_reminder);}
						// Get team task status
						$is_overdue = $today > $oldTask->date_due ? true : false ;
						// Get user actions 
						$due_change = $oldTask->date_due != $duedate_db ? true : false;
						$remind_change = $remind != $oldTask->remind ? true : false ;
						$interval_change = intval($this->bean->reminder_interval) != intval($oldTask->reminder_interval) ? true : false ;
						
						if ($interval_change) {
							if (!$is_overdue) {
								$this->bean->date_reminder = $oldTask->date_reminder;}
							else {
						//		if (intval($_POST['reminder_interval']) < 0 ) {
									$this->bean->date_reminder = $today; }
							//	elseif (intval($_POST['reminder_interval']) > 0 ) {
							//		$this->bean->date_reminder = $timedate->asDb($timedate->getNow()->get("+".$_POST['reminder_interval']." days")); } 
						//	}
						}
						if ($due_change) {
							if (!$is_overdue) {
								$this->bean->date_reminder = $duedate_db;
								}
							else {
						//		if ($duedate_db > $today) {
									$this->bean->date_reminder = $duedate_db;
									}
							//	else { $this->bean->date_reminder = $oldTask->date_reminder;}
						//	}
						}
						if ($remind_change && $remind) {
							$this->bean->date_reminder = $duedate_db;
						}
						if (!$interval_change && !$due_change && !$remind_change) {
							$this->bean->date_reminder = $oldTask->date_reminder;	
						}	
							
						
					} else { $this->bean->date_reminder = $timedate->asDb($timedate->getNow()->get("+20 years"));	}
						
					$notify_array = $this->saveUserData(true);
			
					if ((floatval($_POST['progress']) > 90.0) || ($_POST['status'] == 'Completed')) {	
						$this->bean->isdone = 1;
						$this->bean->status = 'Completed';
						if ($notify) {
							$task_completed = $this->bean->sendNotifications($notify_array[2], 'completed');
							
						} // All users are notified about task completion
					}	
					else {
						if (!empty($notify_array[0]) && $notify) {
						$task_new = $this->bean->sendNotifications($notify_array[0], 'new');
						
						}
						if (!empty($notify_array[1]) && $notify) {
						$task_delete = $this->bean->sendNotifications($notify_array[1], 'delete');
						}
					}
				if (empty($this->bean->svnumber)) {
					$this->bean->fill_in_svnumber();
				}
				parent::action_save();	
		//		$this->bean->getOverdueTasks(); 	// for testing of schedulers
		//		$this->bean->oqc_sendReminders();
						
				} else {
					$GLOBALS['log']->fatal("This TeamTask is already completed and You could not edit it! id: {$_POST['record']}");
					return header("Location: index.php?action=index&module=oqc_Task");
					}
				 
				}
				else {
						 
						 
						
				$GLOBALS['log']->fatal("Could not update TeamTask {$_POST['record']}");
				}
		}
			
		$return_id = $this->bean->id;
		handleRedirect($return_id, 'oqc_Task');
	
		
	}

  
	function action_delete() {
		
		if(!empty($_REQUEST['record'])){
		
			if(!$this->bean->ACLAccess('Delete')){
				ACLController::displayNoAccess(true);
				sugar_cleanup(true);
			}
			// TODO check if entries from oqc_task_users are deleted as well	
			$this->bean->mark_deleted($_REQUEST['record']);
		}else{
			sugar_die("A record number must be specified to delete");
		}
	}
}

?>
