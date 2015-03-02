<h2>Edit OpenQuotesAndContracts configuration file</h2>
<form action='index.php' method='post'>
<input name='module' value='oqc_Administration' type='hidden'>
<input name='action' value='oqc_configure' type='hidden'>

<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


	global $app_strings;
	global $mod_strings;
	
	if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");
	
	
	
	if (isset($_REQUEST['filename'])) {
		$filename = $_REQUEST['filename'];
		$contents = $_REQUEST['contents']; }
	else { $filename = '';}
		
	if (empty($filename)){
		
		$filename = "include/oqc/conf/documents.properties";
			
		echo "<input type='hidden' name='filename' value='$filename'>\n";
		
		if (file_exists($filename)) {
			$contents = file_get_contents($filename); }

		echo "<textarea rows='41' cols='160' name='contents'>$contents</textarea>\n";
		echo "<br>\n<div><input type='submit' value='{$app_strings['LBL_SAVE_BUTTON_LABEL']}'> 
				<input class=\"button\" onclick=\"this.form.action.value='index'; this.form.module.value='Administration';\" type=\"submit\" value=\"{$app_strings['LBL_CANCEL_BUTTON_LABEL']} \"> </div> \n";
	}
	else	{

		if (isset($contents) && !empty($contents)) {
			file_put_contents($filename,html_entity_decode($contents,ENT_QUOTES)); 
			echo "<br><br><h3>{$mod_strings['LBL_UPDATED_MESSAGE']}</h3><br>\n"; }
		else {
			echo "<br><br><h3>{$mod_strings['LBL_NOT_UPDATED_MESSAGE']}</h3><br>\n"; }
			
		if (file_exists($filename)) {
			$contents_updated = file_get_contents($filename); }
		echo "<textarea rows='41' cols='160' name='contents' readonly='readonly'>$contents_updated </textarea>\n";
		echo "<br>";
		$url = "index.php?module=oqc_Administration&action=oqc_configure";
		echo "<br>\n<div><button class=\"button\" type='button' onclick=\"location.href='". $url ."'\"> {$mod_strings['LBL_EDIT_AGAIN_LABEL']} </button>
				<input class=\"button\" onclick=\"this.form.action.value='index'; this.form.module.value='Administration';\" type=\"submit\" value=\"{$app_strings['LBL_CANCEL_BUTTON_LABEL']} \"> </div> \n";
		
	}
?>
</form>
