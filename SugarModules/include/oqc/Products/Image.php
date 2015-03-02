<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function getImageHtml($focus, $name, $value, $view) {
    if ('EditView' != $view && 'DetailView' != $view) {
        return ""; // skip the rest of the method if another view calls this method
    }

    global $app_list_strings;
    $languageStrings = $app_list_strings["oqc"]["Services"];

    require_once('include/Sugar_Smarty.php');
    //1.7.6 Workaround for image display without modifying htaccess file  
    require_once('include/oqc/common/Configuration.php');
    	if (isset($focus->image_unique_filename)) {
		global $sugar_config;
		 $conf = Configuration::getInstance();
		 $oqc_uploadDir = $conf->get('fileUploadDir');
		 $uploadDir = $oqc_uploadDir ? $oqc_uploadDir : $sugar_config['upload_dir'];
		if(file_exists( $uploadDir ."th". $focus->image_unique_filename)) {
	 	$imageurl = "oqc/GetImage.php?module=oqc_Product&id=th".$focus->image_unique_filename; }
	 	else { $imageurl = "oqc/GetImage.php?module=oqc_Product&id=".$focus->image_unique_filename; }
	 	} else {$imageurl = '';}
	 	$smarty = new Sugar_Smarty;
    	$smarty->assign('image_url', $imageurl);
    	$smarty->assign('languageStrings', $languageStrings);
    
   	return $smarty->fetch('include/oqc/Products/Image.' . $view . '.html');
  
}
?>
