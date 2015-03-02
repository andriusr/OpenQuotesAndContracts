<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
require_once('include/entryPoint.php');
require_once('include/oqc/common/ChangeNotifier.php');

/* load php files neccessary for translation of popup depending on the language of the user
 * this is neccessary because the variable app_list_strings is not properly set in this context..
 */
global $sugar_config;
$lang = $sugar_config['default_language'];
require_once("custom/application/Ext/Language/{$lang}.lang.ext.php");	

$notifier = new ChangeNotifier();
$notifier->notifyUsersOfChange();
?>
