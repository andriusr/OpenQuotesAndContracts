<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.list.php');
require_once('modules/oqc_ExternalContract/oqc_ExternalContractListViewSmarty.php');

// only works for sugarcrm 5.2 (code for 5.0.0g in repository.)
class oqc_ExternalContractViewList extends ViewList {
 	function preDisplay(){
 	    $this->lv = new oqc_ExternalContractListViewSmarty();
 	}
 	
 	function listViewProcess(){
		$this->processSearchForm();
		$this->lv->searchColumns = $this->searchForm->searchColumns;
		
		if( $this->where != "") {
			$this->where .= ' and oqc_externalcontract.is_latest !=0';
		}
		else {
			$this->where .= 'oqc_externalcontract.is_latest !=0';
		}		
		
		if(!$this->headers)
			return;
		global $sugar_version ;
		if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false){
			if (0 < strpos($this->where, 'oqc_externalcontract.name like') && FALSE === strpos($this->where, 'oqc_externalcontract.description like')) {
				// if someone searched for a title and entered no description to search for, we will expand the sql statement to make sure name and description of contract are searched automatically.
				$this->where = preg_replace('/oqc_externalcontract.name like \'(.*?)\'/', 'oqc_externalcontract.name like \'\\1\' or oqc_externalcontract.description like \'\\1\'', $this->where);			
			}

			// search for contracts ending not later than enddate 
			if (isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'basic_search') {
				$this->where = preg_replace('/oqc_externalcontract.enddate >=/', 'oqc_externalcontract.enddate <=', $this->where);
			}
			if(floatval(substr($sugar_version,0,3)) > 6.4) {
			$this->lv->setup($this->seed, 'modules/oqc_ExternalContract/views/ListView65.tpl', $this->where, $this->params);
			}
			elseif(floatval(substr($sugar_version,0,3)) > 6.3) {
			$this->lv->setup($this->seed, 'modules/oqc_ExternalContract/views/ListView64.tpl', $this->where, $this->params);
			}
			elseif ((floatval(substr($sugar_version,0,3)) >= 6.0) && (floatval(substr($sugar_version,0,3)) <= 6.3)) {
				
				$this->lv->setup($this->seed, 'modules/oqc_ExternalContract/views/ListView.tpl', $this->where, $this->params);
				}
			else { $this->lv->setup($this->seed, 'modules/oqc_ExternalContract/views/ListView52.tpl', $this->where, $this->params);
			}
			$savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
			echo get_form_header($GLOBALS['mod_strings']['LBL_LIST_FORM_TITLE'] . $savedSearchName, '', false);
			echo $this->lv->display();
		}
 	}
}
?>
