<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
chdir('..');
require_once('include/entryPoint.php');
require_once('modules/oqc_ProductCatalog/oqc_ProductCatalog.php');

echo oqc_ProductCatalog::activeCatalogId();
?>