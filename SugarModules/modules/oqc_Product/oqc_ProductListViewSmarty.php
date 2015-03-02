<?php
include_once('include/ListView/ListViewDisplay.php');
include_once('modules/oqc_Product/oqc_ProductListViewData.php');

class oqc_ProductListViewSmarty extends ListViewSmarty {
	function oqc_ProductListViewSmarty() {
		parent::ListViewSmarty();
		$this->lvd = new oqc_ProductListViewData();
	}
}
?>
