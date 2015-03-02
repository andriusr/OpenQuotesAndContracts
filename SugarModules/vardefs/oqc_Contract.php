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
$dictionary["oqc_Contract"]["fields"]["oqc_externalcontract"] = array (
  'name' => 'oqc_externalcontract',
  'type' => 'link',
  'relationship' => 'oqc_externalcontract_oqc_contract',
  'source' => 'non-db',
);
$dictionary["oqc_Contract"]["fields"]["oqc_service"] = array (
  'name' => 'oqc_service',
  'type' => 'link',
  'relationship' => 'oqc_contract_oqc_service',
  'source' => 'non-db',
);
?>
<?php
// created: 2008-05-14 14:55:15
$dictionary["oqc_Contract"]["fields"]["accounts"] = array (
  'name' => 'accounts',
  'type' => 'link',
  'relationship' => 'oqc_contract_accounts',
  'source' => 'non-db',
);
?>
<?php
// created: 2008-05-14 14:55:15
$dictionary["oqc_Contract"]["fields"]["documents"] = array (
  'name' => 'documents',
  'type' => 'link',
  'relationship' => 'oqc_contract_documents',
  'source' => 'non-db',
);
?>
<?php
// created: 2008-06-03 14:52:01
$dictionary["oqc_Contract"]["fields"]["contacts"] = array (
  'name' => 'contacts',
  'type' => 'link',
  'relationship' => 'oqc_contract_contacts',
  'source' => 'non-db',
);
?>
<?php
// created: 2008-06-03 14:52:01
$dictionary["oqc_Contract"]["fields"]["oqc_product"] = array (
  'name' => 'oqc_product',
  'type' => 'link',
  'relationship' => 'oqc_contract_oqc_product',
  'source' => 'non-db',
);
?>
<?php
// created: 2008-08-13 14:58:26
$dictionary["oqc_Contract"]["fields"]["project"] = array (
  'name' => 'project',
  'type' => 'link',
  'relationship' => 'oqc_contract_project',
  'source' => 'non-db',
);
//1.7.6 add vardefs for extra relationships
$dictionary["oqc_Contract"]["fields"]["oqc_offering"] = array (
  'name' => 'oqc_offering',
  'type' => 'link',
  'relationship' => 'oqc_offering_oqc_contract',
  'source' => 'non-db',
);
$dictionary["oqc_Contract"]["fields"]["oqc_addition"] = array (
  'name' => 'oqc_addition',
  'type' => 'link',
  'relationship' => 'oqc_contract_oqc_addition',
  'source' => 'non-db',
);

?>

