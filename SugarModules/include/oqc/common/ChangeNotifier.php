<?php
require_once('modules/Users/User.php');
require_once('include/oqc/common/common.php');
require_once('include/oqc/common/Configuration.php');
require_once('modules/oqc_ExternalContract/oqc_ExternalContract.php');

class ChangeNotifier {
	const FROM_NAME = 'SugarCRM';
	
	var $role;
	var $fromAddr;
	var $emailTranslation;

	function __construct() {
		$this->emailTranslation = getLanguageStringsPHP('Email');
		$conf = Configuration::getInstance();
		
		$this->role = $conf->get('notificationRole');
		$this->fromAddr = $conf->get('changeNotifierEmailAddress');
	}

	function notifyUsersOfChange() {
		$message = $this->getChangeMessage();
		
		if (empty($message)) {
			return; // do nothing if message is empty because an empty message indicates that nothing has changed
		}
		
		$users = $this->usersWithRole($this->role);
		
		$this->notifyUsersInternal($users, utf8_decode($message));
	}

	private function notifyUsersInternal($users = array(), $message) {
		// echo "message == $message"; // for debugging
		
		foreach ($users as $user) {
			$user->emailAddress->handleLegacyRetrieve($user);
			if (!empty($user->email1) || !empty($user->email2)) {
				// can send to email2 because we already know it is not empty
				$to = !empty($user->email1) ? $user->email1 : $user->email2; 

				// put a nice, user specific 'welcome' in front of the message
				mail(
					$to,
					$this->emailTranslation['subject'],
					sprintf(
						"<html><head><title>%s</title></head><body>%s</body></html>",
						utf8_decode($this->emailTranslation['subject']),
						sprintf(
							$this->emailTranslation['hello'] . $message,
							"{$user->first_name} {$user->last_name}"
						)
					),
					"From: " . self::FROM_NAME . " <" . $this->fromAddr . ">\r\n" .
					"MIME-Version: 1.0\n" .
					"Content-type: text/html; charset=iso-8859-1"
				);
			}		
		}
	
		// send admin a copy of notification email (for testing)
		if (false) { 	
			mail('ingo.jaeckel@student.hpi.uni-potsdam.de', $this->emailTranslation['subject'], sprintf($this->emailTranslation['hello'] . $message, 'Ingo Jaeckel'), "From: " . self::FROM_NAME . "  <" . $this->fromAddr . ">\r\n");
		}
	}

	private function usersWithRole($role = 'ev') {
		$interestedUsers = array();
		$u = new User();
		$users = $u->get_full_list();

		foreach ($users as $user) {
			if ($user->check_role_membership($role, $user->id)) {
				$interestedUsers[] = $user;
			}
		}

		return $interestedUsers;
	}
	
	private function getChangeMessage() {
		$endingContracts = $this->getEndingContracts();
		
		if (empty($endingContracts)) {
			return ""; // return an empty message to indicate that nothing has changed because no ending contracts exist
		}
		
		$message = $this->emailTranslation['introduction'];
		$baseUrl = getSugarConfig('site_url') . '/index.php?module=oqc_ExternalContract&action=DetailView&record=';
			
		foreach ($endingContracts as $contract) {
			$contract->already_notified = true;
			$contract = prepareDateAttributesForSave($contract);
			
			if (isset($contract)) {
				$contract->save(); // TODO make sure that this does not create a new version
			
				$url = $baseUrl . $contract->id;
				$message .= sprintf($this->emailTranslation['notificationLine'], $contract->enddate, $contract->name, $url);
			} else {
				$GLOBALS['log']->warn('ChangeNotifier::getChangeMessage: have to ignore message because it could not be prepared for save(). prepareDateAttributesForSave() returned NULL.');
			}
		}

		return $message . $this->emailTranslation['greetings'];
	}
	
	// return an array containing the contracts that actually end (and have not been notified already) 
	private function getEndingContracts() {
		$endingContracts = array();
		
		$c = new oqc_ExternalContract();
		$contracts = $c->get_full_list('', 'already_notified=0 and enddate >= NOW()');
		$nowTimestamp = time();
		
		if (!empty($contracts)) {
			foreach ($contracts as $contract) {
				$enddate = date_parse($contract->enddate);
	
				// make sure that foreach contract the notification is sent only once && if this contract ends in the warning interval
				if (!$contract->already_notified && $nowTimestamp >= mktime(0, 0, 0, $enddate['month']-$contract->warn_in_months, $enddate['day'], $enddate['year'])) {
					$endingContracts[] = $contract;
				}
			}
		}
		
		return $endingContracts;
	}
}

?>
