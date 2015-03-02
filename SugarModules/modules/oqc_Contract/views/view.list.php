<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.list.php');
require_once('include/QuickSearchDefaults.php');


class CustomViewList extends ViewList
{
	function listViewProcess(){
		
		$this->processSearchForm();
		$this->lv->searchColumns = $this->searchForm->searchColumns;
	
		if( $this->where != "") {
			$this->where .= ' and oqc_contract.is_latest !=0';
		}
		else {
			$this->where .= 'oqc_contract.is_latest !=0';
		}
		
		if(!$this->headers)
            return;
        if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false){
            $this->lv->ss->assign("SEARCH",true);
            $this->lv->setup($this->seed, 'include/ListView/ListViewGeneric.tpl', $this->where, $this->params);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            //Quick Search support
            
				$sqsJavascript = '<script type="text/javascript" src="include/oqc/QuickSearch/oqcQS.js"></script>';
				echo $sqsJavascript;
            
            echo $this->lv->display();		

			}
	}
}

?>