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
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/oqc_Task/oqc_Task_sugar.php');



class oqc_Task extends oqc_Task_sugar {
	// These fields are stored in oqc_task_users relatioship table
	var $user_relationship_fields = array(
		'progress',
		'accept_status',
		'resolution',
		'comment',
		'attachmentsequence',
		'position',
	);
	
	var $rel_users_table = 'oqc_task_users'; 
	
	function oqc_Task(){	
		parent::oqc_Task_sugar();
	}
	
	function get_list($order_by = "", $where = "", $row_offset = 0, $limit=PHP_INT_MAX, $max=-99) {
		return parent::get_list($order_by, $where, $row_offset, $limit, $max);
	}
	//This function is only for reminders processing 
	function getOverdueTasks() {
		global $timedate;
		global $current_user;
		$time_now = $timedate->nowDb();
		$query = "SELECT oqc_task.id, oqc_task.reminder_interval from oqc_task where oqc_task.isdone=0 AND oqc_task.remind=1 AND oqc_task.date_due < '$time_now' AND oqc_task.date_reminder < '$time_now'AND oqc_task.deleted=0";
		//$GLOBALS['log']->error("Finding overdue TeamTasks that should be reminded: ".$query);
		$result = $this->db->query($query, true);
		$taskList = array();
		$reminderIntervalList = array();
		while($row = $this->db->fetchByAssoc($result)) {
			$taskList[] = $row['id'];
			$reminderIntervalList[] = array($row['id'], $row['reminder_interval']);
			
			}
		//now update Task date_reminder field for next reminder date
		foreach ($reminderIntervalList as $IdInterval) {
			
			if (!empty($IdInterval[1])) {
				if (floatval($IdInterval[1]) < 0 ) {
					$nextReminder = $timedate->asDb($timedate->getNow()->get("+20 years")); }
				elseif (floatval($IdInterval[1]) > 0 ) {
					$nextReminder = $timedate->asDb($timedate->getNow()->get("+".$IdInterval[1]." days")); }
				$updatequery = 'UPDATE oqc_task set date_reminder = "'.$nextReminder.'" where id = "'.$IdInterval[0].'"';
				//$GLOBALS['log']->error("Updating date_reminder field: ".$updatequery);
				$this->db->query($updatequery, false);
			
			}
		}
		$GLOBALS['log']->error("OverDue Tasks are ". var_export($taskList,true));   
		return $taskList;
		}
	// Used in sheduler, but can be used also in save action	
	function oqc_sendReminders() {

	$GLOBALS['log']->error('----->Scheduler fired job of type oqc_sendReminders<-----');
	//global $dictionary;
	//global $app_strings;
	
	
	require_once('modules/oqc_Task/oqc_Task.php');
	$task = new oqc_Task();
	$overdueTasks = $task->getOverdueTasks();
	
	foreach ($overdueTasks as $dueTaskId) {
		$dueTask = new oqc_Task();
		$lazyUsers = array();
		if ($dueTask->retrieve($dueTaskId)) {
			$lazyUsers = $dueTask->getLazyUsers();
			if (!empty($lazyUsers)) {
				$dueTask->sendNotifications($lazyUsers, 'overdue');
			} else {
				$dueTask->sendNotifications(array($dueTask->assigned_user_id), 'overdue');
				}
		}
	}
	return true;
	}
	
	function getLazyUsers() {
		
		if (!empty($this->id)) {
		$query = "SELECT oqc_task_users.user_id from oqc_task_users where oqc_task_users.oqc_task_id='$this->id' AND oqc_task_users.progress != 'Completed' AND oqc_task_users.deleted=0";

		//$GLOBALS['log']->error("Finding lazy Users: ".$query);
		$result = $this->db->query($query, true);
		$userList = array();
		while($row = $this->db->fetchByAssoc($result)) {
			$userList[] = $row['user_id']; 
			
		}
		$GLOBALS['log']->error("Lazy Users are ". var_export($userList,true));   
		return $userList;
		} else { return array();}
		}
	
	
	function getDefaultUsers() {
		
		global $current_user;
		if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");
		$list = array();
		$template = new User();
		
		// Next, get default users from default table
		$query = "SELECT oqc_default.user_id, oqc_default.module, oqc_default.date_modified from oqc_default where oqc_default.deleted=0";
	//	$GLOBALS['log']->error("Finding default users: ".$query);
		$result = $this->db->query($query, true);
		//$i = 2;
		
		while($row = $this->db->fetchByAssoc($result)) {
			$template = new User(); 
			//if ($row['user_id'] != $current_user->id) {
			$record = $template->retrieve($row['user_id']);
			
			
			if($record != null) {
				
				$template->oqc_module = $row['module'];
				$template->oqc_date_modified = $row['date_modified'];
				
				// this copies the object into the array 
				$list[] = $template;
			//	$i++;
				
			}
		//	}
		}
		
		return $list;
	}
	
	function fill_defaultUsersArray($list) {
		$users_array = array();
		if (!empty($list)) {
	//		return array();}
		
		foreach ($list as $user) {
       $users_array[] = array(   'name' => $user->first_name .' '.$user->last_name,
       									'id' => $user->id,
	                              'module_name' => $user->oqc_module,
	                              'date_modified' => $user->oqc_date_modified,
	                         );	
		}
		}
		//$GLOBALS['log']->error("Users Array: ". var_export($users_array, true));
		
		//Create Module array with users 
		global $app_list_strings;
		$modules_list = $app_list_strings["oqc_parent_type_display_list"];
		$modules_array = array();
		foreach ($modules_list as $module_name => $module_string) {
			$mod_user_array = array();
			foreach ($users_array as $user) {
			if (in_array($module_name, $user)) {
				$mod_user_array[] = $user;
				
				}
			}
			$modules_array[] = array( 'module_name' => $module_name,
											  'module_string' => $module_string,
												'users' => $mod_user_array,
												);
			
			}
	
	return $modules_array;
		
	}
	
	 function deleteDefaultUser($user_id) {
		$query = "delete from oqc_default where user_id = '$user_id' ";
		$GLOBALS['log']->error("oqc_Task: Deleting Default User: $query");
        $this->db->query($query);
    }
    
    function addDefaultUser($user_id, $mod_name) {
    	$query = "INSERT INTO oqc_default (id, user_id, module, date_modified, deleted) "
    			."VALUES ( ";
				if($this->db->dbType == 'mysql') {
					$query .= " uuid() ";
				} else if($this->db->dbType == 'mssql') {
					$query .= " lower(newid()) ";
				}
		$query .= ",'$user_id', '$mod_name',".db_convert('','today').",0 )";
	//	$GLOBALS['log']->error("oqc_Task: Save Default User: $query");
      $this->db->query($query);
    }
    
    // returns beans of users participating in oqc_task with some extra fields that are required for oqc_task	
	function get_oqc_task_users($task_id) {
		global $timedate;
		$template = new User();
		// First, get the list of IDs.
		$query = "SELECT oqc_task_users.progress, oqc_task_users.accept_status, oqc_task_users.user_id, oqc_task_users.resolution, oqc_task_users.comment, oqc_task_users.attachmentsequence, oqc_task_users.date_modified, oqc_task_users.position   from oqc_task_users where oqc_task_users.oqc_task_id='$task_id' AND oqc_task_users.deleted=0";
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
	
	function get_conjugate()
	{
		$query = "SELECT oqc_task.conjugate FROM oqc_task WHERE id='$this->id' AND deleted = '0'";
		$result = $this->db->query($query, true);
		
		$row = $this->db->fetchByAssoc($result);

		if($row)
			return $row['conjugate'];
		else
			return true; //default value
	}
	
	 // calculates progress field for Listview 
	function get_oqc_task_users_progress() {
	
		$query = "SELECT oqc_task_users.progress  from oqc_task_users where oqc_task_users.oqc_task_id='$this->id' AND oqc_task_users.deleted=0";
	//	$GLOBALS['log']->error("Finding progress records for oqc_Task: ".$query);
		$result = $this->db->query($query, true);
		$list = array();
		$progress = 0.0;
		$sole_progress = 0.0;

		while($row = $this->db->fetchByAssoc($result)) {
			$list[] = $row['progress'];
			
		}
		$user_count = count($list);
		
		foreach ($list as $usr_prog) {
			
			if ($usr_prog == 'In Progress') {
				$progress += 0.5;
				$sole_progress = 0.5; }
			elseif ($usr_prog == 'Completed') {
				$progress += 1.0;
				$sole_progress = 1.0; }
		
		}
		if ($this->conjugate == '') {
			$this->conjugate = $this->get_conjugate();
		}
	//	$GLOBALS['log']->error("For task ". $this->name. " progress is " . $progress. ' conjugate is '. $this->conjugate . ' user count is ' .$user_count);
		if ($this->conjugate && $user_count != 0) {
			$progress = round($progress/$user_count*100);
			
			}	else {
				
			$progress = round($sole_progress*100);	}
		return $progress;
	}
    
    function get_list_view_data() {
    	
		$oqc_task_fields = $this->get_list_view_array();

		global $app_list_strings, $focus, $action, $currentModule;
		if(isset($this->parent_type))
			$oqc_task_fields['PARENT_MODULE'] = $this->parent_type;
		
		global $timedate;
		$today = $timedate->nowDb();
		$nextday = $timedate->asDbDate($timedate->getNow()->get("+1 day"));
		$mergeTime = $oqc_task_fields['DATE_DUE']; 
		$date_db = $timedate->to_db($mergeTime);
	//	$GLOBALS['log']->error("oqc_Task: Dates are:". $today. ' _ '. $date_db);
		if($date_db	< $today && $this->isdone == 0) {
			$oqc_task_fields['DATE_DUE']= "<font class='overdueTask'>".$oqc_task_fields['DATE_DUE']."</font>";
		}else if($date_db	< $nextday && $this->isdone == 0) {
			$oqc_task_fields['DATE_DUE'] = "<font class='todaysTask'>".$oqc_task_fields['DATE_DUE']."</font>";
		} else {
			$oqc_task_fields['DATE_DUE'] = "<font class='futureTask'>".$oqc_task_fields['DATE_DUE']."</font>";
		}
		$this->fill_in_additional_detail_fields();
		
		$oqc_task_fields['PARENT_NAME'] = $this->parent_name;
		$oqc_task_fields['PROGRESS'] = $this->get_oqc_task_users_progress();
		
      return $oqc_task_fields;
	}
    
    // Fill in default/calculated values for EditView. This is default SugarBean function
    
    function fill_in_additional_detail_fields() {
    	global $app_list_strings;
		global $locale;
		global $current_user;
		// Fill in the assigned_user_name
		$this->assigned_user_name = get_assigned_user_name($this->assigned_user_id);

		
		$this->created_by_name = get_assigned_user_name($this->created_by);
		$this->modified_by_name = get_assigned_user_name($this->modified_user_id);
		
		//Fill parent field 
		$this->fill_in_additional_parent_fields();

		global $timedate;
    
        //preset due_date time based on priority default setting 
		if (is_null($this->date_start))
			$this->date_start = $timedate->now();
		if (is_null($this->date_due)) {
			$default_priority = $app_list_strings['oqc_dropdowns_default']['oqc_priority_default_key'];
			// There is bug in some PHP versions that gives wrong relative weekday date; so we did some workaround here 
		switch($default_priority) {
				case 'Low' :
				$period = 7;
				$now = $timedate->getNow();
				while ($period > 0 ) {
					$weekday = date('l', $now->modify("+1 day")->getTimestamp());
					if ( $weekday != 'Sunday' && $weekday != 'Monday') {
						$period = $period -1;
						}
					}	
				$this->date_due = $timedate->asUser($now);
				break;
				case 'Medium' :
				$period = 3;
				$now = $timedate->getNow();
				while ($period > 0 ) {
					$weekday = date('l', $now->modify("+1 day")->getTimestamp());
					if ( $weekday != 'Sunday' && $weekday != 'Monday') {
						$period = $period -1;
						}
					}	
				$this->date_due = $timedate->asUser($now);
			//	$GLOBALS['log']->error("Date Due is ".$this->date_due . ' Timedate is '. $timedate->now());	
				break;
				case 'High' :
				$period = 1;
				$now = $timedate->getNow();
				while ($period > 0 ) {
					$weekday = date('l', $now->modify("+1 day")->getTimestamp());
					if ( $weekday != 'Sunday' && $weekday != 'Monday') {
						$period = $period -1;
						}
					}	
				$this->date_due = $timedate->asUser($now);
				break;
			}
		}
		
		$parent_types = $app_list_strings['oqc_parent_type_display_list'];
		$disabled_parent_types = ACLController::disabledModuleList($parent_types,false, 'list');
		foreach($disabled_parent_types as $disabled_parent_type){
			if($disabled_parent_type != $this->parent_type){
				unset($parent_types[$disabled_parent_type]);
			}
		}
		$this->parent_type_options = get_select_options_with_id($parent_types, $this->parent_type);
		

		

		if (isset ($_REQUEST['parent_type'])) {
			$this->parent_type = $_REQUEST['parent_type'];
		} elseif (is_null($this->parent_type)) {
			$this->parent_type = $app_list_strings['oqc_dropdowns_default']['oqc_parent_type_default_key'];
		}

	}
	
	function save() {
		
		$this->fixDatetimes();

		$return_id = parent::save();
		
		return $return_id;
	}
	
	//2.1 avoid annoying depracated warnings and date conversion errors in sugarlog
	function fixDatetimes() {
		global $timedate;
		$date_array = array(
		array('datetime', 'date_modified'),
		array('datetime', 'date_entered'),
		array('datetime', 'date_start'),
		array('datetime', 'date_due'),
		array('datetime', 'date_reminder'),
		);
		
		foreach ($date_array as $field) {
			
            if ( !isset($this->$field[1]) || empty($this->$field[1]) ) {
                continue;
                }
            
            switch($field[0]) {
                case 'datetime':
                case 'datetimecombo':
                    if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$this->$field[1]) ) {
                        // This appears to be formatted in user date/time
                        $this->$field[1] = $timedate->to_db($this->$field[1]);
                    }
                    break;
                case 'date':
                    if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$this->$field[1]) ) {
                        // This date appears to be formatted in the user's format
                        $this->$field[1] = $timedate->to_db_date($this->$field[1], false);
                    }
                    break;
                case 'time':
                    if ( preg_match('/(am|pm)/i',$this->$field[1]) ) {
                        // This time appears to be formatted in the user's format
                        $this->$field[1] = $timedate->fromUserTime($this->$field[1])->format(TimeDate::DB_TIME_FORMAT);
                    }
                    break;
                default:
                	  break;
               }
			}
	}
	
	
	// 1.7.6 rewrite of code for unique number generation 
	function fill_in_svnumber() {
		global $timedate;
		$date = date("ymd");
		$fldname = $this->table_name . '_number';
		//2.2RC2 Use translated abbreviations
		global $app_list_strings;
		if (isset($app_list_strings["oqc_task_abbreviation_list"][$this->abbreviation])) {
			$abbreviation = $app_list_strings["oqc_task_abbreviation_list"][$this->abbreviation];
		} else { $abbreviation = $this->abbreviation;}
		$this->svnumber = $abbreviation . $date . '/'. $this->$fldname;
	}
	//end
	
	/**
    * Send assignment notifications and invites for meetings and calls
    */
    function sendNotifications($usersIdArray, $template){
       
            $admin = new Administration();
            $admin->retrieveSettings();
            $notify_list = $this->get_notification_recipients($usersIdArray);
            foreach ($notify_list as $notify_user)
                {
                    $this->send_assignment_notifications($notify_user, $admin, $template);
                }
            return true;
    }
    
    function set_notification_body($xtpl, &$oqc_task) {
    	
		global $sugar_config;
		global $app_list_strings;
		global $current_user;
		global $timedate;


		$xtpl->assign("ACCEPT_URL", $sugar_config['site_url'].
							'/index.php?entryPoint=acceptDecline&module=oqc_Task&user_id='.$oqc_task->current_notify_user->id.'&record='.$oqc_task->id);
		$xtpl->assign("TASK_ID", trim($oqc_task->svnumber));
		$xtpl->assign("TASK_SUBJECT", trim($oqc_task->name));
		$xtpl->assign("TASK_PRIORITY", (isset($oqc_task->priority)? $app_list_strings['oqc_task_priority_list'][$oqc_task->priority]:""));
		$xtpl->assign("TASK_STATUS",(isset($oqc_task->status)? $app_list_strings['oqc_task_status_list'][$oqc_task->status]:""));
		if (!empty($oqc_task->date_due)) {
			if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/',$oqc_task->date_due)) {
                        // This appears to be formatted in user date/time
                        $date_converted = $timedate->to_db($oqc_task->date_due);
                    } else { $date_converted = $oqc_task->date_due;}
			$duedate = $timedate->fromDb($date_converted);
		} else {
			$duedate = $timedate->getNow();}
		//$GLOBALS['log']->error("date due is ". var_export($oqc_task->date_due,true)); 
		//$GLOBALS['log']->error("Timedate is ". var_export($duedate,true)); 
		$xtpl->assign("TASK_DUEDATE", $timedate->asUser($duedate, $oqc_task->current_notify_user)." ".TimeDate::userTimezoneSuffix($duedate, $oqc_task->current_notify_user));
		$xtpl->assign("TASK_DESCRIPTION", $oqc_task->description);
		$task_type = $oqc_task->conjugate ? 'all participants' : 'one participant';
      $xtpl->assign("TASK_TYPE", $task_type);
		return $xtpl;
	}
	
	 function get_notification_recipients($usersIdArray) {
    	
    	$list = array();
		if(!is_array($usersIdArray)) {
			$usersIdArray =	array();
		}

		

		foreach($usersIdArray as $user_id) {
			$notify_user = new User();
			$notify_user->retrieve($user_id);
			$notify_user->new_assigned_user_name = $notify_user->full_name;
			$GLOBALS['log']->info("Notifications: recipient is $notify_user->new_assigned_user_name");
			$list[$notify_user->id] = $notify_user;
		}

		return $list;
	}
	
	/**
    * Handles sending out email notifications when items are first assigned to users
    *
    * @param string $notify_user user to notify
    * @param string $admin the admin user that sends out the notification
    */
    function send_assignment_notifications($notify_user, $admin, $template)
    {
        global $current_user;

            $sendToEmail = $notify_user->emailAddress->getPrimaryAddress($notify_user);
            $sendEmail = TRUE;
            if(empty($sendToEmail)) {
                $GLOBALS['log']->warn("Notifications: no e-mail address set for user {$notify_user->user_name}, cancelling send");
                $sendEmail = FALSE;
            }

            $notify_mail = $this->create_notification_email($notify_user, $template);
            $notify_mail->setMailerForSystem();

            if(empty($admin->settings['notify_send_from_assigning_user'])) {
                $notify_mail->From = $admin->settings['notify_fromaddress'];
                $notify_mail->FromName = (empty($admin->settings['notify_fromname'])) ? "" : $admin->settings['notify_fromname'];
            } else {
                // Send notifications from the current user's e-mail (ifset)
                $fromAddress = $current_user->emailAddress->getReplyToAddress($current_user);
                $fromAddress = !empty($fromAddress) ? $fromAddress : $admin->settings['notify_fromaddress'];
                $notify_mail->From = $fromAddress;
                //Use the users full name is available otherwise default to system name
                $from_name = !empty($admin->settings['notify_fromname']) ? $admin->settings['notify_fromname'] : "";
                $from_name = !empty($current_user->full_name) ? $current_user->full_name : $from_name;
                $notify_mail->FromName = $from_name;
            }

           $oe = new OutboundEmail();
            $oe = $oe->getUserMailerSettings($current_user);
            //only send if smtp server is defined
            if($sendEmail){
                $smtpVerified = false;

                //first check the user settings
                if(!empty($oe->mail_smtpserver)){
                    $smtpVerified = true;
                }

                //if still not verified, check against the system settings
                if (!$smtpVerified){
                    $oe = $oe->getSystemMailerSettings();
                    if(!empty($oe->mail_smtpserver)){
                        $smtpVerified = true;
                    }
                }
                //if smtp was not verified against user or system, then do not send out email
                if (!$smtpVerified){
                    $GLOBALS['log']->fatal("Notifications: error sending e-mail, smtp server was not found ");
                    //break out
                    return;
                }

                if(!$notify_mail->Send()) {
                    $GLOBALS['log']->fatal("Notifications: error sending e-mail (method: {$notify_mail->Mailer}), (error: {$notify_mail->ErrorInfo})");
                }else{
                    $GLOBALS['log']->info("Notifications: e-mail successfully sent");
                }
            }

        
    }

    /**
    * This function handles create the email notifications email.
    * @param string $notify_user the user to send the notification email to
    */
    // 2.1 We need to handle new users, deleted users, and task completion notifications; so we override SugarBean function
    function create_notification_email($notify_user, $template) {
        global $sugar_version;
        global $sugar_config;
        global $app_list_strings;
        global $current_user;
        global $locale;
        global $beanList;
        $OBCharset = $locale->getPrecedentPreference('default_email_charset');


        require_once("include/SugarPHPMailer.php");

        $notify_address = $notify_user->emailAddress->getPrimaryAddress($notify_user);
        $notify_name = $notify_user->full_name;
        $GLOBALS['log']->debug("Notifications: user has e-mail defined");

        $notify_mail = new SugarPHPMailer();
        $notify_mail->AddAddress($notify_address,$locale->translateCharsetMIME(trim($notify_name), 'UTF-8', $OBCharset));

        if(empty($_SESSION['authenticated_user_language'])) {
            $current_language = $sugar_config['default_language'];
        } else {
            $current_language = $_SESSION['authenticated_user_language'];
        }
        $xtpl = new XTemplate($this->get_notify_template_file($current_language));
        
        $template_name = $this->object_name. '_'.$template; 
        

        $this->current_notify_user = $notify_user;

        
        $xtpl = $this->set_notification_body($xtpl, $this);
        
        
        $xtpl->assign("ASSIGNED_USER", $this->current_notify_user->new_assigned_user_name);
        $xtpl->assign("ASSIGNER", $current_user->name);
        $port = '';

        if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443) {
            $port = $_SERVER['SERVER_PORT'];
        }

        if (!isset($_SERVER['HTTP_HOST'])) {
            $_SERVER['HTTP_HOST'] = '';
        }

        $httpHost = $_SERVER['HTTP_HOST'];

        if($colon = strpos($httpHost, ':')) {
            $httpHost    = substr($httpHost, 0, $colon);
        }

        $parsedSiteUrl = parse_url($sugar_config['site_url']);
        $host = $parsedSiteUrl['host'];
        if(!isset($parsedSiteUrl['port'])) {
            $parsedSiteUrl['port'] = 80;
        }

        $port		= ($parsedSiteUrl['port'] != 80) ? ":".$parsedSiteUrl['port'] : '';
        $path		= !empty($parsedSiteUrl['path']) ? $parsedSiteUrl['path'] : "";
        $cleanUrl	= "{$parsedSiteUrl['scheme']}://{$host}{$port}{$path}";

        $xtpl->assign("URL", $cleanUrl."/index.php?module={$this->object_name}&action=DetailView&record={$this->id}");
        $xtpl->assign("SUGAR", "Sugar v{$sugar_version}");
        $xtpl->parse($template_name);
        $xtpl->parse($template_name . "_Subject");

        $notify_mail->Body = from_html(trim($xtpl->text($template_name)));
        $notify_mail->Subject = from_html($xtpl->text($template_name . "_Subject"));

        // cn: bug 8568 encode notify email in User's outbound email encoding
        $notify_mail->prepForOutbound();

        return $notify_mail;
    }
    
    /**
 * get_notify_template_file
 * This function will return the location of the email notifications template to use
 *
 * @return string relative file path to email notifications template file
 */
	function get_notify_template_file($language){
	
	$file = "include/oqc/language/en_us.notify_template.html";

	if(file_exists("include/oqc/language/{$language}.notify_template.html")){
		$file = "include/oqc/language/{$language}.notify_template.html";
	}
	return $file;
	}

	function set_accept_status(&$user,$status) 	{
	
		if($user->object_name == 'User')
		{
			$relate_values = array('user_id'=>$user->id,'oqc_task_id'=>$this->id);
	//		$GLOBALS['log']->debug("Notifications: user has e-mail defined");
			if ($status == 'accept') {
			$data_values = array(
				'accept_status'=>'accepted',
				'progress' => 'In Progress');	}
			elseif ($status == 'decline') {
				$data_values = array(
				'accept_status'=>$status,
				'progress' => 'Completed',
				'resolution' => 'Rejected');	}
			$this->set_relationship($this->rel_users_table, $relate_values, true, true,$data_values);
			}
		}
    
    
	
	function get_summary_text() {
		return "$this->name";
	}
	
	
		
}
	
	

?>