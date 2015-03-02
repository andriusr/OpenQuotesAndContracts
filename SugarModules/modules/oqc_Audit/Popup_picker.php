<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Popup Picker
 *
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2007 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 */



require_once('XTemplate/xtpl.php');

require_once("include/upload_file.php");
require_once('include/modules.php');
require_once('include/utils/db_utils.php');
require_once('modules/Audit/Audit.php');

global $beanList, $beanFiles, $currentModule, $focus, $action, $app_strings, $app_list_strings, $current_language, $timedate, $mod_strings;
//we don't want the parent module's string file, but rather the string file specifc to this subpanel



$bean = $beanList[$_REQUEST['module_name']];
require_once($beanFiles[$bean]);
$focus = new $bean;

class Popup_Picker
{


	/*
	 *
	 */
	function Popup_Picker()
	{

	}

	/**
	 *
	 */
	function process_page()
	{
		global $theme;
		global $focus;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		global $currentModule;
		global $odd_bg;
 		global $even_bg;
 		global $image_path;
        global $audit;
        global $current_language;
        global $sugar_version;
		
 		$theme_path="themes/".$theme."/";
 		$image_path = 'themes/'.$theme.'/images/';
 		if(floatval(substr($sugar_version,0,3)) < 6.0) {
 		require_once($theme_path.'layout_utils.php');}
 			else { require_once('include/utils/layout_utils.php');}
		$audit_list =  Audit::get_audit_list();
        $xtpl=new XTemplate ('modules/Audit/Popup_picker.html');
		$xtpl->assign('THEME', $theme);
		$xtpl->assign('MOD', return_module_language($current_language, 'Audit'));
		$xtpl->assign('APP', $app_strings);
		insert_popup_header($theme);

		//output header
		echo "<table width='100%' cellpadding='0' cellspacing='0'><tr><td>";
		$focus_mod_strings = return_module_language($current_language, $focus->module_dir);
		echo get_module_title($focus->module_dir, translate('LBL_MODULE_NAME', $focus->module_dir).": ".$focus->name, false);
		echo "</td><td align='right' class='moduleTitle'>";
		echo "<A href='javascript:print();' class='utilsLink'><img src='".$image_path."print.gif' width='13' height='13' alt='".$app_strings['LNK_PRINT']."' border='0' align='absmiddle'></a>&nbsp;<A href='javascript:print();' class='utilsLink'>".$app_strings['LNK_PRINT']."</A>\n";
		echo "</td></tr></table>";

		$oddRow = true;
		$audited_fields = $focus->getAuditEnabledFieldDefinitions();
		asort($audited_fields);
		$fields = '';
		$field_count = count($audited_fields);
		$start_tag = "<table><tr><td class=\"listViewPaginationLinkS1\">";
		$end_tag = "</td></tr></table>";
		
		if($field_count > 0)
		{
			$index = 0;
    		foreach($audited_fields as $key=>$value)
			{
				$index++;
				$vname = '';
				if(isset($value['vname']))
					$vname = $value['vname'];
				else if(isset($value['label']))
					$vname = $value['label'];
				$fields .= str_replace(':', '', translate($vname, $focus->module_dir));

    			if($index < $field_count)
    			{
    				$fields .= ", ";
    			}
    		}
    		
    		echo $start_tag.translate('LBL_AUDITED_FIELDS', 'Audit').$fields.$end_tag;
    	}
    	else
    	{
    		echo $start_tag.translate('LBL_AUDITED_FIELDS', 'Audit').$end_tag;
    	}

		foreach($audit_list as $audit)
		{
			if(isset($audit['before_value_string']) || isset($audit['after_value_string']))
			{
				$before_value = $audit['before_value_string'];
				$after_value = $audit['after_value_string'];
			}
			else
			{
				// show textblocks correctly formatted.
				// TODO: be careful of security implications
				$before_value = from_html($audit['before_value_text']);
				$after_value = from_html($audit['after_value_text']);
			}
            $activity_fields = array(
                'ID' => $audit['id'],
			    'NAME' => $audit['field_name'],
                'BEFORE_VALUE' => $before_value,
                'AFTER_VALUE' => $after_value,
                'CREATED_BY' => $audit['created_by'],
                'DATE_CREATED' => $audit['date_created'],
			);

			$xtpl->assign("ACTIVITY", $activity_fields);

			if($oddRow)
   			{
        		//todo move to themes
				$xtpl->assign("ROW_COLOR", 'oddListRow');
				$xtpl->assign("BG_COLOR", $odd_bg);
    		}
    		else
    		{
        		//todo move to themes
				$xtpl->assign("ROW_COLOR", 'evenListRow');
				$xtpl->assign("BG_COLOR", $even_bg);
    		}
   			$oddRow = !$oddRow;

			$xtpl->parse("audit.row");
		// Put the rows in.
        }//end foreach

		$xtpl->parse("audit");
		$xtpl->out("audit");
		insert_popup_footer();
    }
} // end of class Popup_Picker
?>
