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
?>
<?php
// created: 2008-06-03 14:52:01
$layout_defs["oqc_Addition"]["subpanel_setup"]["accounts"] = array (
  'order' => 100,
  'module' => 'Accounts',
  'subpanel_name' => 'default',
  'get_subpanel_data' => 'accounts',
  'add_subpanel_data' => 'Accounts_idb',
  'title_key' => 'lbl_accounts',
);
?>
<?php
// created: 2008-06-03 14:52:01
$layout_defs["oqc_Addition"]["subpanel_setup"]["contacts"] = array (
  'order' => 100,
  'module' => 'Contacts',
  'subpanel_name' => 'ForContacts',
  'get_subpanel_data' => 'contacts',
  'add_subpanel_data' => 'Contacts_idb',
  'title_key' => 'lbl_contacts',
);
?>
<?php
// created: 2008-06-03 14:52:01
$layout_defs["oqc_Addition"]["subpanel_setup"]["documents"] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'get_subpanel_data' => 'documents',
  'add_subpanel_data' => 'Documents_idb',
  'title_key' => 'lbl_documents',
);
?>
<?php
// created: 2011-03-18 //1.7.6 relationship
$layout_defs["oqc_Addition"]["subpanel_setup"]["oqc_contract"] = array (
  'order' => 80,
  'module' => 'oqc_Contract',
  'subpanel_name' => 'ContractSub_select',
  'get_subpanel_data' => 'oqc_contract',
  'add_subpanel_data' => 'oqc_Contract_ida',
  'title_key' => 'lbl_oqc_contract',
);
?>
