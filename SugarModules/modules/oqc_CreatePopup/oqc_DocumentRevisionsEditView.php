<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2011 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
//1.7.7 this is copy of modules/DocumentRevisions/Editview.php file with link to customised template

require_once('XTemplate/xtpl.php');
require_once('include/upload_file.php');
require_once('modules/DocumentRevisions/Forms.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;
global $sugar_version;

$focus = new DocumentRevision();

if(isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
}
$old_id = '';

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') 
{
	if (! empty($focus->filename) )
	{	
	 $old_id = $focus->id;
	}
	$focus->id = "";
}

echo get_module_title('DocumentRevisions', $mod_strings['LBL_MODULE_NAME'].": ".$focus->document_name, true); 


$GLOBALS['log']->info("Document revision edit view");

if(substr($sugar_version,0,1) == '6') {
		$xtpl=new XTemplate ('modules/oqc_CreatePopup/oqc_DocumentRevisionsEditView.html');
		}
	else {
		$xtpl=new XTemplate ('modules/oqc_CreatePopup/oqc_DocumentRevisionsEditView52.html');
		}


//$xtpl=new XTemplate ('modules/oqc_CreatePopup/oqc_DocumentRevisionsEditView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

if (isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
$xtpl->assign("PRINT_URL", "index.php?".$GLOBALS['request_string']);
$xtpl->assign("JAVASCRIPT", get_set_focus_js().get_validate_record_document_revision_js());

$focus->fill_document_name_revision($_REQUEST['return_id']);

$xtpl->assign("ID", $focus->id);
$xtpl->assign("DOCUMENT_NAME",$_REQUEST['document_name']);
$xtpl->assign("CURRENT_REVISION",$_REQUEST['document_revision']);

if($_REQUEST['document_revision'] == null) {
	$xtpl->assign("CURRENT_REVISION",$focus->latest_revision);
}

$xtpl->assign("FILE_URL", UploadFile::get_url($_REQUEST['document_filename'],$_REQUEST['document_revision_id']));


$xtpl->parse("main");
$xtpl->out("main");

//implements required fields check based on the required fields list defined in the bean.
require_once('include/javascript/javascript.php');
$javascript = new javascript();
$javascript->setFormName('DocumentRevisionEditView');
$javascript->setSugarBean($focus);
$javascript->addAllFields('');
echo $javascript->getScript();

?>