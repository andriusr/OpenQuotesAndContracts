<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('../../../');
require_once('include/entryPoint.php');
require_once('include/oqc/common/common.php');
require_once('include/oqc/common/Configuration.php');

/* load php files neccessary for translation of popup depending on the language of the user
 * this is neccessary because the variable app_list_strings is not properly set in this context..
 */
global $sugar_config;
$lang = $sugar_config['default_language'];
require_once("custom/application/Ext/Language/{$lang}.lang.ext.php");	

$languageDocuments = getLanguageStringsPHP('Documents');
$languageCommon = getLanguageStringsPHP('common');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>
<?php echo $languageDocuments['popupTitle']; ?>
</title>
<!--  some sugarcrm css files -->
<link rel="stylesheet" type="text/css" href="../../../themes/Sugar/navigation.css" />
<link rel="stylesheet" type="text/css" href="../../../themes/Sugar/style.css" />
<link rel="stylesheet" type="text/css" href="../../../themes/Sugar/colors.sugar.css" id="current_color_style" />
<link rel="stylesheet" type="text/css" href="../../../themes/Sugar/fonts.normal.css" id="current_font_style"/>

<script type="text/javascript" src="../../../include/oqc/common/OQC.js"></script>

<link rel="stylesheet" type="text/css" href="../../../include/oqc/dhtmlx/dhtmlxtree.css" />
<script type="text/javascript" src="../../../include/oqc/dhtmlx/dhtmlxcommon.js"></script>
<script type="text/javascript" src="../../../include/oqc/dhtmlx/dhtmlxtree.js"></script>
<script type="text/javascript" src="../../../include/oqc/dhtmlx/ext/dhtmlxtree_attrs.js"></script>
<script type="text/javascript" src="../../../include/oqc/dhtmlx/ext/dhtmlxtree_sb.js"></script>
<script type="text/javascript" src="../../../include/oqc/dhtmlx/ext/dhtmlxtree_kn.js"></script>
<script type="text/javascript" src="../../../include/oqc/dhtmlx/ext/dhtmlxtree_start.js"></script>
<script type="text/javascript" src="../../../include/oqc/dhtmlx/ext/dhtmlxtree_srnd.js"></script>
</head>
<body style="margin: 20px;">

<?php echo $languageDocuments['title'] ?>
<div id="directoryTreeContainer" style="margin-bottom: 10px;"></div>
<img src='../../../themes/default/images/sqsWait.gif' id='loadingGif' /><br />
<script type="text/javascript" src="../../../include/oqc/ExternalContracts/Documents.js"></script>
<input id="okButton" type="button" class="button" value="Ok" onclick="OqcExternalContractsDocuments.closePopup();" disabled />
<input type="button" class="button" value="<?php echo $languageCommon['cancel']; ?>" /><br /><br />
<?php
$conf = Configuration::getInstance();
echo sprintf($languageDocuments['fileSelectionHint'], $conf->get('storageDirectory'));
?>

<script type="text/javascript">
	// TODO protect against XSS
	var CALLBACK_PARAMETER = '<?php echo $_REQUEST['p']; ?>';
	OqcExternalContractsDocuments.init();
</script>

</body>
</html>
