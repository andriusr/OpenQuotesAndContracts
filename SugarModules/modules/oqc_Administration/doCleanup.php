<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/oqc_Product/oqc_Product.php');
require_once('modules/oqc_Offering/oqc_Offering.php');
require_once('modules/oqc_Contract/oqc_Contract.php');
require_once('modules/oqc_ExternalContract/oqc_ExternalContract.php');
require_once('modules/oqc_Addition/oqc_Addition.php');
require_once('modules/oqc_Service/oqc_Service.php');
//require_once('modules/Users/User.php');

//$GLOBALS['log']->error('Post: '. var_export($_POST, true));
global $timedate;
global $curent_user;

if (!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

if (isset($_POST['oqc_module_name']) && !empty($_POST['oqc_module_name'])) {
	$modules = $_POST['oqc_module_name'];
	foreach ($modules as $module) {
		$bean = new $module();
		$where = 'is_latest =0';
		if (!$_POST['leave_latest']) {
			$date_until = $_POST['date_remove'];
			if ( ! preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',$date_until) ) {
            $date_until = $timedate->to_db_date($date_until, false). ' 00:00:00';
         } 
			$where .= ' AND '. strtolower($module).'.date_modified < "'. $date_until . '"';
			}
		$beanArray = $bean->get_full_list('',$where);
		if (!empty($beanArray)) {
			foreach ($beanArray as $remove) {
				$remove->mark_deleted($remove->id);
				//$GLOBALS['log']->error('oqc Cleanup: removing deleted records for module '. $module. ': '. $remove->id. ' version: ' .$remove->version);
			
			}
		}
	}
	if (isset($_POST['remove_database']) && $_POST['remove_database']) {
		
	//		$GLOBALS['log']->error('oqc Cleanup: removing deleted records for module '. $module);
			$backupDir	= sugar_cached('backups');
			$backupFile	= 'oqc-backup-GMT0_'.gmdate('Y_m_d-H_i_s', strtotime('now')).'.php';

			$db = DBManagerFactory::getInstance();
			$tables = $db->getTablesArray();
			//$GLOBALS['log']->error('oqc Cleanup: modules to clean up1: ' . var_export($modules, true));
			$offering_key = array_search('oqc_Offering', $modules);
			if ($offering_key !== false) {
				$modules[$offering_key] = 'oqc_offerin';
				
				}
			$contract_key = array_search('oqc_Contract', $modules);
			if ($contract_key !== false) {
				$modules[$contract_key] = 'oqc_contrac';
				$modules[] = 'oqc_additio';
				}
			
			if ($contract_key !== false || $offering_key !== false) {
				$modules[] = 'oqc_service';
				}
			$excontract_key = array_search('oqc_ExternalContract', $modules);
			if ($excontract_key !== false) {
				$modules[$excontract_key] = 'oqc_extern';
				
				}
			//$GLOBALS['log']->error('oqc Cleanup: modules to clean up: ' . var_export($modules, true));
			$oqc_module_tables = array();
			foreach ($tables as $table) {
				if (strpos($table, 'oqc_productcatalog') === 0) continue;
				foreach ($modules as $module) {
					if (strpos($table,strtolower($module)) === 0) {
						$oqc_module_tables[] = $table;
				
					}
				}
			}
			//$GLOBALS['log']->error('oqc Cleanup: tables to clean up: ' . var_export($oqc_module_tables, true));
			$queryString = array();
			if(!empty($oqc_module_tables)) {
				foreach($oqc_module_tables as $oqc_table) {
					// find tables with deleted=1
					$columns = $db->get_columns($oqc_table);
				// no deleted - won't delete
					if(empty($columns['deleted'])) continue;

					$custom_columns = array();
					if(array_search($oqc_table.'_cstm', $oqc_module_tables)) {
			    		$custom_columns = $db->get_columns($oqc_table.'_cstm');
			    		if(empty($custom_columns['id_c'])) {
			       	 $custom_columns = array();
			    		}
					}

					$qDel = "SELECT * FROM $oqc_table WHERE deleted = 1";
					$rDel = $db->query($qDel);
			
				// make a backup INSERT query if we are deleting.
					while($aDel = $db->fetchByAssoc($rDel, false)) {
				// build column names

						$queryString[] = $db->insertParams($oqc_table, $columns, $aDel, null, false);

						if(!empty($custom_columns) && !empty($aDel['id'])) {
                    $qDelCstm = 'SELECT * FROM '.$oqc_table.'_cstm WHERE id_c = '.$db->quoted($aDel['id']);
                    $rDelCstm = $db->query($qDelCstm);

                    // make a backup INSERT query if we are deleting.
                    while($aDelCstm = $db->fetchByAssoc($rDelCstm)) {
                        $queryString[] = $db->insertParams($oqc_table, $custom_columns, $aDelCstm, null, false);
                    } // end aDel while()

                    $db->query('DELETE FROM '.$oqc_table.'_cstm WHERE id_c = '.$db->quoted($aDel['id']));
                   // $GLOBALS['log']->error('oqc Cleanup: permanently deleting records for cstm table '. $oqc_table. ': '. $db->quoted($aDel['id']));
                	}
					} // end aDel while()
					// now do the actual delete
					$db->query('DELETE FROM '.$oqc_table.' WHERE deleted = 1');
					//$GLOBALS['log']->error('oqc Cleanup: permanently deleting records for table: ' .$oqc_table);
					
				} // foreach() tables

				if(!file_exists($backupDir) || !file_exists($backupDir.'/'.$backupFile)) {
					// create directory if not existent
					mkdir_recursive($backupDir, false);
				}
				// write cache file

				write_array_to_file('oqc_Cleanup', $queryString, $backupDir.'/'.$backupFile);
			}
		}

	
}
		

header("Location: index.php?action={$_POST['return_action']}&module={$_POST['return_module']}");


?>