<?php

$create_popup_63 = <<<EOT
</html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<title>Upload New Document Revision</title>
<link rel="stylesheet" type="text/css" href="cache/themes/$theme/css/yui.css?s=$sugar_version&c=$js_custom_version" />
<link rel="stylesheet" type="text/css" href="cache/themes/$theme/css/deprecated.css?s=$sugar_version&c=$js_custom_version" />
<link rel="stylesheet" type="text/css" href="cache/themes/$theme/css/style.css?s=$sugar_version&c=$js_custom_version" />
<script type="text/javascript" src="include/javascript/sugar_grp1_yui.js?s=$sugar_version&c=$js_custom_version"></script>
<script type="text/javascript" src="include/javascript/sugar_grp1.js?s=$sugar_version&c=$js_custom_version"></script>
</head>
<body style="margin: 10px">
EOT;

$ttt = "\"";

require_once('include/MVC/View/views/view.edit.php');
require_once('include/EditView/EditView2.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');
//require_once('modules/Documents/views/view.edit.php'); 

// $_REQUEST['parent_id'] = $parameters[0];
//	$_REQUEST['parent_name'] = $parameters[2];
//	$_REQUEST['parent_type'] = 'Documents';
// $_REQUEST['action'] = 'EditView';


	
echo $create_popup_63;



//$GLOBALS['log']->error('Popup: '. get_class($this));

//$base = 'modules/Documents/metadata/';
$source = 'custom/modules/DocumentRevisions/metadata/editviewdefs.php';
if (!file_exists( $source)){
	$source =  'modules/DocumentRevisions/metadata/editviewdefs.php';
	if (!file_exists($source)) {
		die('Editviewdefs file not found!');
	}
}

//if(file_exists('modules/Documents/views/view.edit.php')) {
            
            
            $c = 'ViewEdit';
            //$GLOBALS['log']->error('Document Popup view class is ' . $c);
            if(class_exists($c)) {
            $view = new $c;
            $view->ev = new EditView();
            $view->ss = new Sugar_Smarty();
            $view->ev->ss = & $view->ss;
			   $view->bean = new DocumentRevision();
			   $view->ev->setup($module, $view->bean, $source, 'include/EditView/EditView.tpl');
				$view->ev->defs['templateMeta']['form']['headerTpl'] = 'include/oqc/CreatePopup/header.tpl';
				$view->ev->defs['templateMeta']['form']['footerTpl'] = 'include/oqc/CreatePopup/footer_63.tpl';
				//		2.1 RC2 we have to use custom formName otherwise it overrides Documents Editview template
				$view->ev->formName = 'oqc_UploadRevision';
				if (!$view->ev->th->checkTemplate($module, $view->ev->view, true, $view->ev->formName))
       			{
            	$view->ev->render();
        			}
				// end 2.1 RC2    
			   $view->showTitle = false; // Do not show title since this is for subpanel
            $view->display();
            
            }
//} 
//else {die('Could not load class definition file');}

?>