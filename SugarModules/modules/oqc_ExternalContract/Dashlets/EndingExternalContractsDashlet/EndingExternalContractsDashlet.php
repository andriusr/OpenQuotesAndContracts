<?php
require_once('include/Dashlets/DashletGeneric.php'); 
require_once('modules/oqc_ExternalContract/oqc_ExternalContract.php');

class EndingExternalContractsDashlet extends DashletGeneric {
	function EndingExternalContractsDashlet($id, $def = null) {
		require_once("modules/oqc_ExternalContract/Dashlets/EndingExternalContractsDashlet/EndingExternalContractsDashlet.data.php");
		
		parent::DashletGeneric($id, $def);
		
		$this->searchFields = $dashletData['EndingExternalContractsDashlet']['searchFields'];
		$this->columns = $dashletData['EndingExternalContractsDashlet']['columns'];
		
		// not only showing my contracts (that are contracts where assigned_user_id == my_user_id)
		$this->myItemsOnly = false;
		
		// make sure that DashletGeneric::buildWhere is called
		// for more filters see include/generic/SugarWidgets/SugarWidgetFielddate.php
		$this->filters['enddate'] = array(); // the filters array must not be null to make sure that buildWhere is called
		
		$this->title = translate('LBL_ENDING_EXTERNAL_CONTRACTS', 'oqc_ExternalContract');
		$this->description = translate('LBL_ENDING_EXTERNAL_CONTRACTS_DESCRIPTION', 'oqc_ExternalContract');
 		
		$this->seedBean = new oqc_ExternalContract();
	}
	
	/*
	 * override DashletGeneric::buildWhere to implement the filtering that we want to have.
	 * we only want to see contracts ending before (enddate - warn_in_months* months)
	 * 
	 * TODO it should be possible to override warn_in_months with a dashlets search 
	 */
	function buildWhere() {
		$warn_in_months = (empty($this->filters['warn_in_months'])) ?
			"warn_in_months" : $this->filters['warn_in_months'];
		
		return array(
			"NOW() >= DATE_SUB(enddate, INTERVAL $warn_in_months MONTH) and is_archived = 0"
		);		
	}
}
?>
