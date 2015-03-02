<?php
include_once('include/ListView/ListViewDisplay.php');
include_once('modules/oqc_ExternalContract/oqc_ExternalContractListViewData.php');

class oqc_ExternalContractListViewSmarty extends ListViewSmarty {
	function oqc_ExternalContractListViewSmarty() {
		parent::ListViewSmarty();
		$this->lvd = new oqc_ExternalContractListViewData();
	}
}
?>