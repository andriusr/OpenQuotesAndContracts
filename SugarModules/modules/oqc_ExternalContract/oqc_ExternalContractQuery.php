<?php
require_once('modules/oqc_ExternalContract/oqc_ExternalContract.php');

class oqc_ExternalContractQuery {
	/*
	 * returns the external contract with the biggest amount of final costs
	 */
	public static function getBiggestExternalContract() {
		$externalContract = new oqc_ExternalContract();
		$list = $externalContract->get_full_list("finalcosts desc", "deleted=0");
		return $list[0];
	}
	
}
?>