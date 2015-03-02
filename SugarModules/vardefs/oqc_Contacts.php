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
$dictionary["Contact"]["fields"]["oqc_offering"] = array (
  'name' => 'oqc_offering',
  'type' => 'link',
  'relationship' => 'oqc_offering_contacts',
  'source' => 'non-db',
);
?>
<?php
// created: 2008-10-05 12:05:37
$dictionary["Contact"]["fields"]["oqc_externalcontract"] = array (
  'name' => 'oqc_externalcontract',
  'type' => 'link',
  'relationship' => 'oqc_externalcontract_contacts',
  'source' => 'non-db',
);
?>
<?php
// created: 2008-05-19 16:05:01
$dictionary["Contact"]["fields"]["oqc_addition"] = array (
  'name' => 'oqc_addition',
  'type' => 'link',
  'relationship' => 'oqc_addition_contacts',
  'source' => 'non-db',
);
?>
<?php
// created: 2008-10-05 12:05:37
$dictionary["Contact"]["fields"]["oqc_contract"] = array (
  'name' => 'oqc_contract',
  'type' => 'link',
  'relationship' => 'oqc_contract_contacts',
  'source' => 'non-db',
);
//2.1 relationship - Disabled for now 
/* $dictionary["Contact"]["relationships"]["contact_oqc_task"] = array(
				'lhs_module' => 'Contacts',
            'lhs_table' => 'contacts',
            'lhs_key' => 'id',
            'rhs_module' => 'oqc_Task',
            'rhs_table' => 'oqc_task',
            'rhs_key' => 'contact_id',
            'relationship_type' => 'one-to-many',
);
$dictionary["Contact"]["fields"]["oqc_task"] = array (
  		'name' => 'oqc_task',
		'type' => 'link',
		'module' => 'oqc_Task',
		'bean_name'  => 'oqc_Task',
		'relationship' => 'contact_oqc_task',
		'source' => 'non-db',
		'vname' => 'LBL_OQC_TASK',
); */

?>
