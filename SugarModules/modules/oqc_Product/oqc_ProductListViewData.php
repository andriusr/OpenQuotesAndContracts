<?php
include_once('include/ListView/ListViewDisplay.php');
require_once('include/oqc/Highlighting/PackageHighlighter.php');

class oqc_ProductListViewData extends ListViewData {
	
	function oqc_ProductListViewData() {
		parent::ListViewData();
	}
	
	
    public function getListViewData($seed, $where, $offset=-1, $limit = -1, $filter_fields=array(),$params=array(),$id_field = 'id') {
        // add packaged_product_ids field manually to list of fields that should be retrieved ($filter_fields). so we can be sure that we can access the PACKAGED_PRODUCT_IDS fields in the $result array. this is needed for proper highlightning per product bean depending whether it contains other products or not.
        $addedFilterFields = array_merge($filter_fields, array('packaged_product_ids' => true, 'is_option' => true));

        $result = parent::getListViewData($seed, $where, $offset, $limit, $addedFilterFields, $params, $id_field);
        $highlighter = new PackageHighlighter();

        foreach ($result['data'] as &$productArray) {
            $productArray['customRowColor'] = $highlighter->getHighlightningColor($productArray);
        }
		//   $GLOBALS['log']->error('Product ListViewData '. var_export($result, true));
        return $result;
    }
}
?>
