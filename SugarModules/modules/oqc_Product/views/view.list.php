<?php
require_once('include/MVC/View/views/view.list.php');
require_once('modules/oqc_Product/oqc_ProductListViewSmarty.php');
require_once('include/QuickSearchDefaults.php');

class oqc_ProductViewList extends ViewList {
	function oqc_ProductViewList() {
		parent::ViewList();
	}

        function preDisplay() {
            $this->lv = new oqc_ProductListViewSmarty();
        }

        function listViewProcess(){
		$this->processSearchForm();
		$this->lv->searchColumns = $this->searchForm->searchColumns;
		
		if( $this->where != "") {
			$this->where .= ' and oqc_product.is_latest !=0';
//			$this->where .= ' and oqc_product.is_option !=1';
		}
		else {
			$this->where .= 'oqc_product.is_latest !=0';
//			$this->where .= ' and oqc_product.is_option !=1';
		}		


		if(!$this->headers)
			return;
		global $sugar_version ;
			
		if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false) {
			if(floatval(substr($sugar_version,0,3)) > 6.4) {
			$this->lv->setup($this->seed, 'modules/oqc_Product/views/ListView65.tpl', $this->where, $this->params);
			}
			
			elseif(floatval(substr($sugar_version,0,3)) > 6.3) {
			$this->lv->setup($this->seed, 'modules/oqc_Product/views/ListView64.tpl', $this->where, $this->params);
			}
			elseif ((floatval(substr($sugar_version,0,3)) >= 6.0) && (floatval(substr($sugar_version,0,3)) <= 6.3)) {
				
				$this->lv->setup($this->seed, 'modules/oqc_Product/views/ListView62.tpl', $this->where, $this->params);
				}
			else { $this->lv->setup($this->seed, 'modules/oqc_Product/views/ListView52.tpl', $this->where, $this->params);
			}
			$savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
		//	echo get_form_header($GLOBALS['mod_strings']['LBL_LIST_FORM_TITLE'] . $savedSearchName, '', false);
			//Quick Search support
            $qsd = new QuickSearchDefaults();
				$sqsJavascript = $qsd->getQSScripts();
				$sqsJavascript .= '<script type="text/javascript" src="include/oqc/QuickSearch/oqcQS.js"></script>';
				echo $sqsJavascript;
		
			echo $this->lv->display();
		}
 	}
}
?>