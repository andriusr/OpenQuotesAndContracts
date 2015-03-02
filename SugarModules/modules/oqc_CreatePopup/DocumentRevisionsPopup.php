<?php

//1.7.7 method of creation of DocumentRevisions popup is different from the Documents
// Parameters for creation are transfered as metadata

	global $sugar_config, $theme, $current_user, $sugar_version, $sugar_flavor, $mod_strings, $app_strings, $app_list_strings, $module, $action, $timezones, $theme_colors, $js_custom_version, $view;
  $starting_color_name = 'sugar'; //$theme_colors[0];			
  $starting_font_name = 'normal'; //$theme_fonts[0];

if ($_REQUEST['metadata'] != '' && $_REQUEST['metadata'] != 'undefined') {
	$module = 'DocumentRevisions';
	$view = 'EditView';	
	$parameters = explode('_', trim($_REQUEST['metadata']));
	// Update REQUEST variable
	// 0-doc_id, 1-doc_rev_id, 2- doc_name
	
	$_REQUEST['document_id'] = $parameters[0];
	$_REQUEST['record'] = '';
	$_REQUEST['document_revision_id'] = $parameters[1];
	$_REQUEST['document_name'] = $parameters[2];
	//$_REQUEST['parent_id'] = $parameters[0];
	//$_REQUEST['parent_name'] = $parameters[2];
	//$_REQUEST['parent_type'] = 'Documents';
	$_REQUEST['metadata'] = 'undefined';
	$_REQUEST['return_id'] = $parameters[0];
	$_REQUEST['return_module'] = 'Documents'; 
	
	$create_popup_60 = <<<EOT
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<title>Upload New Document Revision</title>
<link rel="stylesheet" type="text/css" href="themes/$theme/css/yui.css?s=$sugar_version&c=$js_custom_version" />
<link rel="stylesheet" type="text/css" href="themes/$theme/css/deprecated.css?s=$sugar_version&c=$js_custom_version" />
<link rel="stylesheet" type="text/css" href="themes/$theme/css/style.css?s=$sugar_version&c=$js_custom_version" />
<script type="text/javascript" src="include/javascript/sugar_grp1_yui.js?s=$sugar_version&c=$js_custom_version"></script>
<script type="text/javascript" src="include/javascript/sugar_grp1.js?s=$sugar_version&c=$js_custom_version"></script>
</head>
<body style="margin: 10px">
EOT;

	$create_popup_52 = "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/navigation.css?s={$sugar_version}&c={$js_custom_version}\" />" ;
	$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/style.css?s=$sugar_version&c={$js_custom_version}\" />";
	//$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/colors.{$starting_color_name}.css?s={$sugar_version}&c=$js_custom_version\" id=\"current_color_style\" />";
	//$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/fonts.{$starting_font_name}.css?s={$sugar_version}&c={$js_custom_version}\" id=\"current_font_style\"/>";

if(floatval(substr($sugar_version,0,3)) < 6.2) {

	if(substr($sugar_version,0,1) == '6') {
		echo $create_popup_60;
		}
	else {
		echo $create_popup_52;
		}
	
	$this->includeClassicFile('modules/oqc_CreatePopup/oqc_DocumentRevisionsEditView.php');

} else {
	require ('modules/oqc_CreatePopup/DocumentRevisionsPopup63.php');
}
}


?>