<?php
require_once('include/Dashlets/DashletGeneric.php'); 
require_once('modules/oqc_Contract/oqc_Contract.php');

class EndingContractsDashlet extends DashletGeneric {
	function EndingContractsDashlet($id, $def = null) {
		require_once("modules/oqc_Contract/Dashlets/EndingContractsDashlet/EndingContractsDashlet.data.php");
		
		parent::DashletGeneric($id, $def);
		
		$this->searchFields = $dashletData['EndingContractsDashlet']['searchFields'];
		$this->columns = $dashletData['EndingContractsDashlet']['columns'];
		
		// not only showing my contracts (that are contracts where assigned_user_id == my_user_id)
		$this->myItemsOnly = false;
		// make sure that DashletGeneric::buildWhere is called
		// for more filters see include/generic/SugarWidgets/SugarWidgetFielddate.php
		$this->filters['enddate'] = array('type' => 'TP_next_30_days');
		
		$this->title = translate('LBL_ENDINGCONTRACTS', 'oqc_Contract');
		$this->description = translate('LBL_ENDINGCONTRACTS_DESCRIPTION', 'oqc_Contract');
 		
		$this->seedBean = new oqc_Contract();
	}
}
?>
