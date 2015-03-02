<?php

  global $sugar_config, $theme, $current_user, $sugar_version, $sugar_flavor, $mod_strings, $app_strings, $app_list_strings, $module, $action, $timezones, $theme_colors, $js_custom_version, $view, $timedate ;
  $starting_color_name = 'sugar'; //$theme_colors[0];			
  $starting_font_name = 'normal'; //$theme_fonts[0];

//$GLOBALS['log']->error('Popup: '. get_class($this));

$module = 'Documents'; 
$view = 'EditView';

$_REQUEST['return_action'] = '';
$_REQUEST['return_module'] = ''; 
  // this was working with 6.1.2, but causes some problems with 6.2.x

$create_popup_60 = <<<EOT
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<title>Create New Attachment</title>
<link rel="stylesheet" type="text/css" href="themes/$theme/css/yui.css?s=$sugar_version&c=$js_custom_version" />
<link rel="stylesheet" type="text/css" href="themes/$theme/css/deprecated.css?s=$sugar_version&c=$js_custom_version" />
<link rel="stylesheet" type="text/css" href="themes/$theme/css/style.css?s=$sugar_version&c=$js_custom_version" />
<script type="text/javascript" src="include/javascript/sugar_grp1_yui.js?s=$sugar_version&c=$js_custom_version"></script>
<script type="text/javascript" src="include/javascript/sugar_grp1.js?s=$sugar_version&c=$js_custom_version"></script>
</head>
<body style="margin: 10px">
EOT;

/* 2.0RC2- have to use cached css files
$create_popup_62 = <<<EOT
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<title>Create New Attachment</title>
<link rel="stylesheet" type="text/css" href="themes/$theme/css/yui.css?c=1" />
<link rel="stylesheet" type="text/css" href="themes/$theme/css/deprecated.css?c=1" />
<link rel="stylesheet" type="text/css" href="themes/$theme/css/style.css?c=1" />
</head>
<body style="margin: 10px">
EOT; */

$create_popup_62 = <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<title>Create New Attachment</title>
<link rel="stylesheet" type="text/css" href="cache/themes/$theme/css/yui.css?c=$js_custom_version" />
<link rel="stylesheet" type="text/css" href="cache/themes/$theme/css/deprecated.css?c=$js_custom_version" />
<link rel="stylesheet" type="text/css" href="cache/themes/$theme/css/style.css?c=$js_custom_version" />
</head>
<body style="margin: 10px">
EOT;

$create_popup_52 = "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/navigation.css?s={$sugar_version}&c={$js_custom_version}\" />" ;
//$GLOBALS['log']->fatal('Popup '.$create_popup_52);
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
} else { echo $create_popup_62;}

require_once('include/MVC/View/views/view.edit.php');
require_once('include/EditView/EditView2.php');
require_once('modules/Documents/Document.php');
require_once('modules/Documents/views/view.edit.php'); 

//$GLOBALS['log']->error('Popup: '. get_class($this));

//$base = 'modules/Documents/metadata/';
$source = 'custom/modules/Documents/metadata/editviewdefs.php';
if (!file_exists( $source)){
	$source =  'modules/Documents/metadata/editviewdefs.php';
	if (!file_exists($source)) {
		die('Editviewdefs file not found!');
	}
}

if(file_exists('modules/Documents/views/view.edit.php')) {
            
            
            $c = 'DocumentsViewEdit';
            //$GLOBALS['log']->error('Document Popup view class is ' . $c);
            if(class_exists($c)) {
            $view = new $c;
            $view->ev = new EditView(); // We need to extend this class in order to process custom template 
            $view->ss = new Sugar_Smarty();
            $view->ev->ss = & $view->ss;
			   $view->bean = new Document();
			   $view->ev->setup($module, $view->bean, $source, 'include/EditView/EditView.tpl');
				$view->ev->defs['templateMeta']['form']['headerTpl'] = 'include/oqc/CreatePopup/header.tpl';
				$view->ev->defs['templateMeta']['form']['footerTpl'] = 'include/oqc/CreatePopup/footer.tpl';  
				//		2.1 RC2 we have to use custom formName otherwise it overrides Documents Editview template
				$view->ev->formName = 'oqc_CreateAttachment';
				if (!$view->ev->th->checkTemplate($module, $view->ev->view, true, $view->ev->formName))
       			{
            	$view->ev->render();
        			}
		//		$view->ev->render();
				// end 2.1 RC2
			   $view->showTitle = false; // Do not show title since this is for subpanel
            $view->display();
            
            }
} 
else {die('Could not load class definition file');}

?>