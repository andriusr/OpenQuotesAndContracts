<?php
/*********************************************************************************
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
 ********************************************************************************/
$dictionary['oqc_TextBlock'] = array(
	'table'=>'oqc_textblock',
	'audited'=>true,
	'fields'=>array (
  'is_default' =>
  array (
    'required' => false,
    'name' => 'is_default',
    'vname' => 'LBL_IS_DEFAULT',
    'type' => 'bool',
    'massupdate' => 0,
    'comments' => 'Soll dieser Textbaustein für neue Verträge automatisch selektiert werden?',
    'help' => 'Beim erstellen neuer Verträge können Textbausteine automatisch vorselektiert werden. Geben Sie hier bitte an ob dieser Textbaustein vorselektiert werden soll?',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
  ),
  'description' => array(
    'required' => false,
    'name' => 'description',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'text',
    'massupdate' => 0,
    'comments' => 'comment',
    'help' => 'help',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 1,
    'reportable' => 0,
    'studio' => 'false',
  ),
  'oqc_textblockedit' => array (
    'required' => false,
    'name' => 'oqc_textblockedit',
    'vname' => 'LBL_DESCRIPTION',
    'type' => 'varchar',
    'source' => 'non-db',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'function' => 
    array (
      'name' => 'getSingleTextblockHtml',
      'returns' => 'html',
      'include' => 'include/oqc/Textblocks/Textblocks.php',
    ),
  ),
  
  
),
	'relationships'=>array (
),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('oqc_TextBlock','oqc_TextBlock', array('basic','issue'));

// additional issue fields beside *_number are not neccessary
unset($dictionary['oqc_TextBlock']['fields']['type']);
unset($dictionary['oqc_TextBlock']['fields']['status']);
unset($dictionary['oqc_TextBlock']['fields']['priority']);
unset($dictionary['oqc_TextBlock']['fields']['resolution']);
unset($dictionary['oqc_TextBlock']['fields']['work_log']);

// repair the name field
$dictionary['oqc_TextBlock']['fields']['name']['required'] = true;
$dictionary['oqc_TextBlock']['fields']['name']['comment'] = 'Short description';
