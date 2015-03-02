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

	$manifest = array (
		 'acceptable_sugar_versions' => 
		  array ('regex_matches' => array('6\.[0-5]\.*')
        ),
       'acceptable_sugar_flavors' =>
		  array(
		  	'CE'
		  ),
		  'readme'=>'',
		  'key'=>'oqc',
		  'author' => 'HPI',
		  'description' => 'Quotes, Contracts and Products modules plus a lot of extra functionality',
		  'icon' => '',
		  'is_uninstallable' => true,
		  'name' => 'OpenQuotesAndContracts',
		  'published_date' => '2013/09/10',
		  'type' => 'module',
		  'version' => '2.2RC3',
		  'remove_tables' => 'prompt',
		  );
$installdefs = array (
  'id' => 'OpenQuotesAndContracts',
  
  'administration' => array(
		array(
			'from' => '<basepath>/SugarModules/modules/oqc_Administration/oqc_Administration_menu.php',
			'to' => 'modules/Administration/oqc_Administration_menu.php',
		),
	),
	
	'scheduledefs' => array (
		array(
			'from' => '<basepath>/SugarModules/modules/oqc_Schedulers/oqc_AddJobsHere.php',
			'to_module' => 'Schedulers',
			),
	),
  'copy' => 
  array (
    1 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Category',
      'to' => 'modules/oqc_Category',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Product',
      'to' => 'modules/oqc_Product',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Contract',
      'to' => 'modules/oqc_Contract',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Service',
      'to' => 'modules/oqc_Service',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_EditedTextBlock',
      'to' => 'modules/oqc_EditedTextBlock',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_TextBlock',
      'to' => 'modules/oqc_TextBlock',
    ),
    7 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Offering',
      'to' => 'modules/oqc_Offering',
    ),
    8 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Addition',
      'to' => 'modules/oqc_Addition',
    ),
    9 =>
    array (
      'from' => '<basepath>/SugarModules/include/oqc',
      'to' => 'include/oqc',
    ),
 
    10 =>
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_CreatePopup',
      'to' => 'modules/oqc_CreatePopup',
    ),
    11 =>
    array (
      'from' => '<basepath>/SugarModules/oqc',
      'to' => 'oqc',
    ),
    12 =>
    array (
      'from' => '<basepath>/SugarModules/include/SugarObjects/templates/oqc_contract_base',
      'to' => 'include/SugarObjects/templates/oqc_contract_base',
    ),
    13 =>
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_ProductCatalog',
      'to' => 'modules/oqc_ProductCatalog',
    ),
    14 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_ExternalContract',
      'to' => 'modules/oqc_ExternalContract',
    ),
 
    15 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_ExternalContractCosts',
      'to' => 'modules/oqc_ExternalContractCosts',
    ),
    16 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_ExternalContractDetailedCosts',
      'to' => 'modules/oqc_ExternalContractDetailedCosts',
    ),
    17 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_ExternalContractPositions',
      'to' => 'modules/oqc_ExternalContractPositions',
    ),
    //2.1 oqc_Task module
     18 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Task',
      'to' => 'modules/oqc_Task',
    ),
    19 => 
    array (
      'from' => '<basepath>/icons/default/images/oqc_Administration.gif',
      'to'   => 'themes/default/images/oqc_Administration.gif',
    ),
    20 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Administration',
      'to'   => 'modules/oqc_Administration',
    ),
    21 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Schedulers/oqc_AddJobsHere.php',
      'to'   => 'custom/modules/Schedulers/oqc_AddJobsHere.php',
    ),
    22 => 
    array (
      'from' => '<basepath>/SugarModules/modules/oqc_Audit',
      'to' => 'modules/oqc_Audit',
    ),
  ),
  
  'language' => 
  array (
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    array (
      'from' => '<basepath>/SugarModules/language/application/ge_ge.lang.php',
      'to_module' => 'application',
      'language' => 'ge_ge',
    ),
    array (
      'from' => '<basepath>/SugarModules/language/application/de_de.lang.php',
      'to_module' => 'application',
      'language' => 'de_de',
    ),
    array (
      'from' => '<basepath>/SugarModules/language/application/it_it.lang.php',
      'to_module' => 'application',
      'language' => 'it_it',
    ),
    //2.2RC2 New translations
     array (
      'from' => '<basepath>/SugarModules/language/application/es_ES.lang.php',
      'to_module' => 'application',
      'language' => 'es_ES',
    ),
     array (
      'from' => '<basepath>/SugarModules/language/application/fr_FR.lang.php',
      'to_module' => 'application',
      'language' => 'fr_FR',
    ),
     array (
      'from' => '<basepath>/SugarModules/language/application/pt_BR.lang.php',
      'to_module' => 'application',
      'language' => 'pt_BR',
    ),
     array (
      'from' => '<basepath>/SugarModules/language/application/ru_ru.lang.php',
      'to_module' => 'application',
      'language' => 'ru_ru',
    ),
    // en_us module strings
    array (
      'from'=> '<basepath>/SugarModules/language/modules/Accounts/mod_strings_en_us.php',
				  'to_module'=> 'Accounts',
				  'language'=>'en_us'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Contacts/mod_strings_en_us.php',
				  'to_module'=> 'Contacts',
				  'language'=>'en_us'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Documents/mod_strings_en_us.php',
				  'to_module'=> 'Documents',
				  'language'=>'en_us'
	 ),
	
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Opportunities/mod_strings_en_us.php',
				  'to_module'=> 'Opportunities',
				  'language'=>'en_us'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Project/mod_strings_en_us.php',
				  'to_module'=> 'Project',
				  'language'=>'en_us'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Administration/mod_strings_en_us.php',
				  'to_module'=> 'Administration',
				  'language'=>'en_us'
	 ),
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Schedulers/mod_strings_en_us.php',
				  'to_module'=> 'Schedulers',
				  'language'=>'en_us'
	 ),
	 
	  
	 //end 2.1
	  /* 1.7.8 ge_ge module strings */
	    array (
      'from'=> '<basepath>/SugarModules/language/modules/Accounts/mod_strings_ge_ge.php',
				  'to_module'=> 'Accounts',
				  'language'=>'ge_ge'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Contacts/mod_strings_ge_ge.php',
				  'to_module'=> 'Contacts',
				  'language'=>'ge_ge'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Documents/mod_strings_ge_ge.php',
				  'to_module'=> 'Documents',
				  'language'=>'ge_ge'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Opportunities/mod_strings_ge_ge.php',
				  'to_module'=> 'Opportunities',
				  'language'=>'ge_ge'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Project/mod_strings_ge_ge.php',
				  'to_module'=> 'Project',
				  'language'=>'ge_ge'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Administration/mod_strings_ge_ge.php',
				  'to_module'=> 'Administration',
				  'language'=>'ge_ge'
	 ),
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Schedulers/mod_strings_ge_ge.php',
				  'to_module'=> 'Schedulers',
				  'language'=>'ge_ge'
	 ),
	  
	  /* 2.2 de_de module strings for SugarCE > 6.1.1*/
	    array (
      'from'=> '<basepath>/SugarModules/language/modules/Accounts/mod_strings_de_de.php',
				  'to_module'=> 'Accounts',
				  'language'=>'de_de'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Contacts/mod_strings_de_de.php',
				  'to_module'=> 'Contacts',
				  'language'=>'de_de'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Documents/mod_strings_de_de.php',
				  'to_module'=> 'Documents',
				  'language'=>'de_de'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Opportunities/mod_strings_de_de.php',
				  'to_module'=> 'Opportunities',
				  'language'=>'de_de'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Project/mod_strings_de_de.php',
				  'to_module'=> 'Project',
				  'language'=>'de_de'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Administration/mod_strings_de_de.php',
				  'to_module'=> 'Administration',
				  'language'=>'de_de'
	 ),
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Schedulers/mod_strings_de_de.php',
				  'to_module'=> 'Schedulers',
				  'language'=>'de_de'
	 ),
	  
	 //it_it module strings
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Accounts/mod_strings_it_it.php',
				  'to_module'=> 'Accounts',
				  'language'=>'it_it'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Contacts/mod_strings_it_it.php',
				  'to_module'=> 'Contacts',
				  'language'=>'it_it'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Documents/mod_strings_it_it.php',
				  'to_module'=> 'Documents',
				  'language'=>'it_it'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Opportunities/mod_strings_it_it.php',
				  'to_module'=> 'Opportunities',
				  'language'=>'it_it'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Project/mod_strings_it_it.php',
				  'to_module'=> 'Project',
				  'language'=>'it_it'
	 ),

    array (
      'from'=> '<basepath>/SugarModules/language/modules/Administration/mod_strings_it_it.php',
				  'to_module'=> 'Administration',
				  'language'=>'it_it'
	 ),
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Schedulers/mod_strings_it_it.php',
				  'to_module'=> 'Schedulers',
				  'language'=>'it_it'
	 ),
	  
	//es_ES module strings
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Accounts/mod_strings_es_ES.php',
				  'to_module'=> 'Accounts',
				  'language'=>'es_ES'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Contacts/mod_strings_es_ES.php',
				  'to_module'=> 'Contacts',
				  'language'=>'es_ES'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Documents/mod_strings_es_ES.php',
				  'to_module'=> 'Documents',
				  'language'=>'es_ES'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Opportunities/mod_strings_es_ES.php',
				  'to_module'=> 'Opportunities',
				  'language'=>'es_ES'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Project/mod_strings_es_ES.php',
				  'to_module'=> 'Project',
				  'language'=>'es_ES'
	 ),

    array (
      'from'=> '<basepath>/SugarModules/language/modules/Administration/mod_strings_es_ES.php',
				  'to_module'=> 'Administration',
				  'language'=>'es_ES'
	 ),
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Schedulers/mod_strings_es_ES.php',
				  'to_module'=> 'Schedulers',
				  'language'=>'es_ES'
	 ),
	   
   //fr_FR module strings
   array (
      'from'=> '<basepath>/SugarModules/language/modules/Accounts/mod_strings_fr_FR.php',
				  'to_module'=> 'Accounts',
				  'language'=>'fr_FR'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Contacts/mod_strings_fr_FR.php',
				  'to_module'=> 'Contacts',
				  'language'=>'fr_FR'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Documents/mod_strings_fr_FR.php',
				  'to_module'=> 'Documents',
				  'language'=>'fr_FR'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Opportunities/mod_strings_fr_FR.php',
				  'to_module'=> 'Opportunities',
				  'language'=>'fr_FR'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Project/mod_strings_fr_FR.php',
				  'to_module'=> 'Project',
				  'language'=>'fr_FR'
	 ),

    array (
      'from'=> '<basepath>/SugarModules/language/modules/Administration/mod_strings_fr_FR.php',
				  'to_module'=> 'Administration',
				  'language'=>'fr_FR'
	 ),
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Schedulers/mod_strings_fr_FR.php',
				  'to_module'=> 'Schedulers',
				  'language'=>'fr_FR'
	 ),
	
	//pt_BR module strings
	array (
      'from'=> '<basepath>/SugarModules/language/modules/Accounts/mod_strings_pt_BR.php',
				  'to_module'=> 'Accounts',
				  'language'=>'pt_BR'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Contacts/mod_strings_pt_BR.php',
				  'to_module'=> 'Contacts',
				  'language'=>'pt_BR'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Documents/mod_strings_pt_BR.php',
				  'to_module'=> 'Documents',
				  'language'=>'pt_BR'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Opportunities/mod_strings_pt_BR.php',
				  'to_module'=> 'Opportunities',
				  'language'=>'pt_BR'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Project/mod_strings_pt_BR.php',
				  'to_module'=> 'Project',
				  'language'=>'pt_BR'
	 ),

    array (
      'from'=> '<basepath>/SugarModules/language/modules/Administration/mod_strings_pt_BR.php',
				  'to_module'=> 'Administration',
				  'language'=>'pt_BR'
	 ),
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Schedulers/mod_strings_pt_BR.php',
				  'to_module'=> 'Schedulers',
				  'language'=>'pt_BR'
	 ),
	 // ru_ru module strings
    array (
      'from'=> '<basepath>/SugarModules/language/modules/Accounts/mod_strings_ru_ru.php',
				  'to_module'=> 'Accounts',
				  'language'=>'ru_ru'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Contacts/mod_strings_ru_ru.php',
				  'to_module'=> 'Contacts',
				  'language'=>'ru_ru'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Documents/mod_strings_ru_ru.php',
				  'to_module'=> 'Documents',
				  'language'=>'ru_ru'
	 ),
	
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Opportunities/mod_strings_ru_ru.php',
				  'to_module'=> 'Opportunities',
				  'language'=>'ru_ru'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Project/mod_strings_ru_ru.php',
				  'to_module'=> 'Project',
				  'language'=>'ru_ru'
	 ),
	  array (
      'from'=> '<basepath>/SugarModules/language/modules/Administration/mod_strings_ru_ru.php',
				  'to_module'=> 'Administration',
				  'language'=>'ru_ru'
	 ),
	 array (
      'from'=> '<basepath>/SugarModules/language/modules/Schedulers/mod_strings_ru_ru.php',
				  'to_module'=> 'Schedulers',
				  'language'=>'ru_ru'
	 ),
	),   
  
  'beans' => 
  array (
    1 => 
    array (
      'module' => 'oqc_Category',
      'class' => 'oqc_Category',
      'path' => 'modules/oqc_Category/oqc_Category.php',
      'tab' => false,
    ),
    2 => 
    array (
      'module' => 'oqc_Product',
      'class' => 'oqc_Product',
      'path' => 'modules/oqc_Product/oqc_Product.php',
      'tab' => true,
    ),
    3 => 
    array (
      'module' => 'oqc_Contract',
      'class' => 'oqc_Contract',
      'path' => 'modules/oqc_Contract/oqc_Contract.php',
      'tab' => true,
    ),
    4 => 
    array (
      'module' => 'oqc_Service',
      'class' => 'oqc_Service',
      'path' => 'modules/oqc_Service/oqc_Service.php',
      'tab' => false,
    ),
    5 => 
    array (
      'module' => 'oqc_EditedTextBlock',
      'class' => 'oqc_EditedTextBlock',
      'path' => 'modules/oqc_EditedTextBlock/oqc_EditedTextBlock.php',
      'tab' => false,
    ),
    6 => 
    array (
      'module' => 'oqc_TextBlock',
      'class' => 'oqc_TextBlock',
      'path' => 'modules/oqc_TextBlock/oqc_TextBlock.php',
      'tab' => true,
    ),
    7 => 
    array (
      'module' => 'oqc_Offering',
      'class' => 'oqc_Offering',
      'path' => 'modules/oqc_Offering/oqc_Offering.php',
      'tab' => true,
    ),
    8 => 
    array (
      'module' => 'oqc_Addition',
      'class' => 'oqc_Addition',
      'path' => 'modules/oqc_Addition/oqc_Addition.php',
      'tab' => false,
    ),
    9 =>
    array (
      'module' => 'oqc_ProductCatalog',
      'class' => 'oqc_ProductCatalog',
      'path' => 'modules/oqc_ProductCatalog/oqc_ProductCatalog.php',
      'tab' => true,
    ),
    10 => 
    array (
      'module' => 'oqc_ExternalContract',
      'class' => 'oqc_ExternalContract',
      'path' => 'modules/oqc_ExternalContract/oqc_ExternalContract.php',
      'tab' => true,
    ),
    11 => 
    array (
      'module' => 'oqc_ExternalContractPositions',
      'class' => 'oqc_ExternalContractPositions',
      'path' => 'modules/oqc_ExternalContractPositions/oqc_ExternalContractPositions.php',
      'tab' => false,
    ),
    12 => 
    array (
      'module' => 'oqc_ExternalContractCosts',
      'class' => 'oqc_ExternalContractCosts',
      'path' => 'modules/oqc_ExternalContractCosts/oqc_ExternalContractCosts.php',
      'tab' => false,
    ),
    13 => 
    array (
      'module' => 'oqc_ExternalContractDetailedCosts',
      'class' => 'oqc_ExternalContractDetailedCosts',
      'path' => 'modules/oqc_ExternalContractDetailedCosts/oqc_ExternalContractDetailedCosts.php',
      'tab' => false,
    ),
    //2.1 oqc_Task module
    14 => 
    array (
      'module' => 'oqc_Task',
      'class' => 'oqc_Task',
      'path' => 'modules/oqc_Task/oqc_Task.php',
      'tab' => true, // TODO hide or leave???
    ),
  ),
  
   'layoutdefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/oqc_Offering.php',
      'to_module' => 'oqc_Offering',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/oqc_Addition.php',
      'to_module' => 'oqc_Addition',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/oqc_ExternalContract.php',
      'to_module' => 'oqc_ExternalContract',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/oqc_ProductCatalog.php',
      'to_module' => 'oqc_ProductCatalog',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/layoutdefs/oqc_Task.php',
      'to_module' => 'oqc_Task',
    ),
 ), 
  'relationships' => 
  array (
    array (
      'module' => 'Documents',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Documents.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_product_documentsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Documents.php'
    ),
    array (
      'module' => 'Documents',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Documents.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_productcatalog_documentsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Documents.php'
    ),
    array (
      'module' => 'Documents',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Documents.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_offering_documentsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Documents.php'
    ),
     array (
      'module' => 'Documents',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Documents.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_addition_documentsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Documents.php'
    ),
    array (
      'module' => 'Documents',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Documents.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_contract_documentsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Documents.php'
    ),
    array (
      'module' => 'Documents',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Documents.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_externalcontract_documentsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Documents.php'
    ),
        array (
      'module' => 'Accounts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Accounts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_contract_accountsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Accounts.php'
    ),
     array (
      'module' => 'Accounts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Accounts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_offering_accountsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Accounts.php'
    ),
     array (
      'module' => 'Accounts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Accounts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_addition_accountsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Accounts.php'
    ),
     array (
      'module' => 'Accounts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Accounts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_externalcontract_accountsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Accounts.php'
    ),
     array (
      'module' => 'Contacts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Contacts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_contract_contactsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Contacts.php'
    ),
    array (
      'module' => 'Contacts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Contacts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_addition_contactsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Contacts.php'
    ),
    array (
      'module' => 'Contacts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Contacts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_offering_contactsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Contacts.php'
    ),
     array (
      'module' => 'Contacts',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Contacts.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_externalcontract_contactsMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Contacts.php'
    ),
    
    array (
      'module' => 'oqc_Product',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Product.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_contract_oqc_productMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Product.php'
    ),
    
    array (
      'module' => 'oqc_Product',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Product.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_offering_oqc_productMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Product.php'
    ),
     
    array (
      'module' => 'oqc_Product',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Product.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_addition_oqc_productMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Product.php'
    ),
        
    array (
      'module' => 'Project',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Project.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_contract_projectMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Project.php'
    ),
    array (
      'module' => 'Project',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Project.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_offering_projectMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Project.php'
    ),
    array (
      'module' => 'Project',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Project.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_externalcontract_projectMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Project.php'
    ),
    array (
      'module' => 'oqc_Contract',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Contract.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_externalcontract_oqc_contractMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Contract.php'
    ),
     // 1.7.6 extra relatioship for Additions and Quotes
     array (
      'module' => 'oqc_Contract',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Contract.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_contract_oqc_additionMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Contract.php'
    ),
     array (
      'module' => 'oqc_Offering',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Offering.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_offering_oqc_contractMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Offering.php'
    ),
    //2.1 relationships
     
    	array (
		'module'=> 'oqc_Task',
		'meta_data'=>'<basepath>/SugarModules/relationships/oqc_defaultMetaData.php',
	 ),
    
    array (
      'module' => 'Users',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Users.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_task_usersMetaData.php',
    ),
    //End 2.1
    
    //End 1.7.6  
    array (
      'module' => 'oqc_Service',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Service.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_contract_oqc_serviceMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Service.php'
    ),
     array (
      'module' => 'oqc_Service',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Service.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_offering_oqc_serviceMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Service.php'
    ),
     array (
      'module' => 'oqc_Service',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Service.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_addition_oqc_serviceMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Service.php'
    ),
      
    //1.7.5 relationship
    array (
      'module' => 'Opportunities',
      'module_vardefs' => '<basepath>/SugarModules/vardefs/oqc_Opportunities.php',
      'meta_data' => '<basepath>/SugarModules/relationships/oqc_offering_opportunitiesMetaData.php',
      'module_layoutdefs'=>'<basepath>/SugarModules/layoutdefs/oqc_Opportunities.php'
    ),
   
  ),
  'image_dir' => '<basepath>/icons',
  
  // 2.0RC4 all custom fields MUST have name ending with _c otherwise it causes installer fatal error.
  'custom_fields' => 
  array (
    array(
      'name' => 'officenumber_c',
      'label' => 'LBL_OQC_OFFICE_NUMBER',
      'type' => 'varchar',
      'max_size' => '25',
      'audited' => false,
      'module' => 'Accounts',
      'massupdate' => false,
    ),
    array(
      'name' => 'isexternal_c',
      'label' => 'LBL_OQC_EXTERNAL',
      'type' => 'bool',
      'audited' => false,
      'module' => 'Accounts',
      'massupdate' => false,
    ),
    array(
      'name' => 'isexternal_c',
      'label' => 'LBL_OQC_EXTERNAL',
      'type' => 'bool',
      'audited' => false,
      'module' => 'Contacts',
      'massupdate' => false,
    ),
  // 1.7.5 
  // Added for indicating whether document should be included in Product Catalog
    array(
      'name' => 'document_purpose_c',
      'label' => 'LBL_DOCUMENT_PURPOSE',
      'type' => 'enum',
      'default_value' => ' ',
      'ext1' => 'document_purpose_list',
      'audited' => false,
      'module' => 'Documents',
      'massupdate' => false,
      'studio' => 'visible',
    ),
  ), 
  
 'vardefs' => 
  array ( 
    0 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/oqc_Offering.php',
      'to_module' => 'oqc_Offering',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/oqc_Addition.php',
      'to_module' => 'oqc_Addition',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/oqc_ExternalContract.php',
      'to_module' => 'oqc_ExternalContract',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/oqc_ProductCatalog.php',
      'to_module' => 'oqc_ProductCatalog',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/vardefs/oqc_Opportunities.php',
      'to_module' => 'Opportunities',
    ),
     array (
      'from' => '<basepath>/SugarModules/vardefs/oqc_Accounts.php',
      'to_module' => 'Accounts',
    ),
  
  ), 
  'post_uninstall'=>array(
		0 => '<basepath>/scripts/post_uninstall.php',
	), 
);
?>
