<?php
class PackageHighlighter {
    const YELLOW = '#FDFDDB';
    const NO_COLOR = '';
    const GREEN = '#DFFFC4';
    const RED = '#FDEAEA';

    public function getHighlightningColor($productArray) {
        $trimmed = trim($productArray['PACKAGED_PRODUCT_IDS']);
        $isPackage = !empty($trimmed);
       // $GLOBALS['log']->fatal("Product variables is " . var_export($productArray, true));
		if ($productArray['ACTIVE'] == 0) {
        			return self::RED;}
        if ($isPackage) {
            return self::YELLOW;
        } elseif ($productArray['IS_OPTION'] == 1) {
        		return self::GREEN; }
        		
        	else {
            return self::NO_COLOR;
        }
    }
}
?>
