<?php
require_once('include/Dashlets/DashletGeneric.php'); 
require_once('modules/oqc_Contract/oqc_Contract.php');

class AllContractsDashlet extends DashletGeneric {
	function AllContractsDashlet($id, $def = null) {
		require_once("modules/oqc_Contract/Dashlets/AllContractsDashlet/AllContractsDashlet.data.php");
		
		parent::DashletGeneric($id, $def);
		
		$this->searchFields = $dashletData['AllContractsDashlet']['searchFields'];
		$this->columns = $dashletData['AllContractsDashlet']['columns'];
		
		// not only showing my contracts (that are contracts where assigned_user_id == my_user_id)
		$this->myItemsOnly = false;
		// make sure that DashletGeneric::buildWhere is called
		// for more filters see include/generic/SugarWidgets/SugarWidgetFielddate.php
		$this->seedBean = new oqc_Contract();
	}
}
?>
