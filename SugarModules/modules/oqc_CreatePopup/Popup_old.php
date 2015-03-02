<?php
  /* Action muss "Popup" heißen, weil dafür in "include/MVC/View/views/view.config.php" definiert wird, dass kein header etc. angezeigt werden soll */
 
  global $sugar_config, $theme, $current_user, $sugar_version, $sugar_flavor, $mod_strings, $app_strings, $app_list_strings, $module, $action, $timezones, $theme_colors, $js_custom_version, $view;
  $starting_color_name = 'sugar'; //$theme_colors[0];			
  $starting_font_name = 'normal'; //$theme_fonts[0];
  
if (isset($_REQUEST['moduletocreate'])) {
 if ($_REQUEST['moduletocreate'] == 'Documents') {
 
$module = 'Documents'; 
 
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

$create_popup_52 = "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/navigation.css?s={$sugar_version}&c={$js_custom_version}\" />" ;
//$GLOBALS['log']->fatal('Popup '.$create_popup_52);
$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/style.css?s=$sugar_version&c={$js_custom_version}\" />";
$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/colors.{$starting_color_name}.css?s={$sugar_version}&c=$js_custom_version\" id=\"current_color_style\" />";
$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/fonts.{$starting_font_name}.css?s={$sugar_version}&c={$js_custom_version}\" id=\"current_font_style\"/>";



	if(substr($sugar_version,0,1) == '6') {
		echo $create_popup_60;
		}
	else {
		echo $create_popup_52;
		}

require_once('include/EditView/EditView2.php');


$GLOBALS['log']->error('Popup: '. get_class($this));
// locate the best viewdefs to use: 1. custom/module/quickcreatedefs.php 2. module/quickcreatedefs.php 3. custom/module/editviewdefs.php 4. module/editviewdefs.php
$base = 'modules/' . $module . '/metadata/';
$source = 'custom/' . $base . strtolower($view) . 'defs.php';
if (!file_exists( $source))
{
	$source = $base . strtolower($view) . 'defs.php';
	if (!file_exists($source))
	{
		//if our view does not exist default to EditView
		$view = 'EditView';
		$source = 'custom/' . $base . 'editviewdefs.php';
		if (!file_exists($source))
		{
			$source = $base . 'editviewdefs.php';
		}
	}
}
//$GLOBALS['log']->error('Popup: '. var_export($_REQUEST));
$GLOBALS['log']->error('Popup: '. $source);
$this->ev = new EditView();
$this->ev->view = $view;
$this->ev->ss = new Sugar_Smarty();
/*$_REQUEST['return_action'] = 'ReturnBean';
$_REQUEST['return_module'] = 'CreatePopup';*/ 
/* $_REQUEST['return_action'] = 'DetailView';
$_REQUEST['return_module'] = $module; */
$_REQUEST['return_action'] = '';
$_REQUEST['return_module'] = ''; 

$this->ev->setup($module, null, $source);
$this->ev->defs['templateMeta']['form']['headerTpl'] = 'include/oqc/CreatePopup/header.tpl';
$this->ev->defs['templateMeta']['form']['footerTpl'] = 'include/oqc/CreatePopup/footer.tpl'; 
//$this->ev->defs['templateMeta']['form']['headerTpl'] = 'include/oqc/empty.tpl';
        //$this->ev->defs['templateMeta']['form']['footerTpl'] = 'include/oqc/empty.tpl'; 
// $this->ev->defs['templateMeta']['form']['buttons'] = array(/*'SUBPANELSAVE', 'SUBPANELCANCEL', 'SUBPANELFULLFORM'*/);

$defaultProcess = true;
if(file_exists('modules/'.$module.'/views/view.edit.php')) {
            include('modules/'.$module.'/views/view.edit.php'); 
            $c = $module . 'ViewEdit';
            
            if(class_exists($c)) {
            $view = new $c;
            $defaultProcess = false;
            $view->ev = & $this->ev;
            $view->ss = & $this->ev->ss;
			   $class = $GLOBALS['beanList'][$module];
			      if(!empty($GLOBALS['beanFiles'][$class])){
				   require_once($GLOBALS['beanFiles'][$class]);
				   $bean = new $class();
				   $view->bean = $bean;
			      }
			   $view->showTitle = false; // Do not show title since this is for subpanel
            $view->display();
            
            }
} //if
$GLOBALS['log']->error('Popup: '. $defaultProcess);
if($defaultProcess) {
   $this->process($module);
}
}

if ($_REQUEST['moduletocreate'] == 'DocumentRevisions' && ($_REQUEST['metadata'] != '' && $_REQUEST['metadata'] != 'undefined')) {
	$module = 'DocumentRevisions';
	$parameters = explode('_', trim($_REQUEST['metadata']));
	// 0-doc_id, 1-doc_rev_id, 2- doc_name
	
	$_REQUEST['document_id'] = $parameters[0];
	$_REQUEST['record'] = $parameters[1];
	$_REQUEST['document_revision_id'] = $parameters[1];
	$_REQUEST['document_name'] = $parameters[2];
	//$_REQUEST['parent_id'] = $parameters[0];
	//$_REQUEST['parent_name'] = $parameters[2];
	//$_REQUEST['parent_type'] = 'Documents';
	$_REQUEST['metadata'] = 'undefined';
	
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

$create_popup_52 = "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/navigation.css?s={$sugar_version}&c={$js_custom_version}\" />" ;
//$GLOBALS['log']->fatal('Popup '.$create_popup_52);
$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/style.css?s=$sugar_version&c={$js_custom_version}\" />";
$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/colors.{$starting_color_name}.css?s={$sugar_version}&c=$js_custom_version\" id=\"current_color_style\" />";
$create_popup_52 .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"themes/{$theme}/fonts.{$starting_font_name}.css?s={$sugar_version}&c={$js_custom_version}\" id=\"current_font_style\"/>";



	if(substr($sugar_version,0,1) == '6') {
		echo $create_popup_60;
		}
	else {
		echo $create_popup_52;
		}
require_once('include/EditView/EditView2.php');	
$view = 'EditView';	
$GLOBALS['log']->error('Popup: '. get_class($this));

$base = 'modules/' . $module . '/metadata/';
$source = 'custom/' . $base . strtolower($view) . 'defs.php';
if (!file_exists( $source))
{
	$source = $base . strtolower($view) . 'defs.php';
	if (!file_exists($source))
	{
		//if our view does not exist default to EditView
		$view = 'EditView';
		$source = 'custom/' . $base . 'editviewdefs.php';
		if (!file_exists($source))
		{
			$source = $base . 'editviewdefs.php';
		}
	}
}
/*
$GLOBALS['log']->error('Popup: '. $source);
$this->ev = new EditView();
$this->ev->view = $view;
$this->ev->ss = new Sugar_Smarty();
/*$_REQUEST['return_action'] = 'ReturnBean';
$_REQUEST['return_module'] = 'CreatePopup';*/ 
/* $_REQUEST['return_action'] = 'DetailView';
$_REQUEST['return_module'] = $module; */
$_REQUEST['return_action'] = '';
$_REQUEST['return_module'] = ''; 
/*
$this->ev->setup($module, null, $source);
$this->ev->defs['templateMeta']['form']['headerTpl'] = 'include/oqc/CreatePopup/header.tpl';
$this->ev->defs['templateMeta']['form']['footerTpl'] = 'include/oqc/CreatePopup/footer.tpl'; 	
*/	
	
	$this->includeClassicFile('modules/'. $module . '/EditView.php');
	}

}
	
?>

