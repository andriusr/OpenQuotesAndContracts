<?php
include_once('include/ListView/ListViewDisplay.php');

require_once('include/oqc/Highlighting/RedYellowDateHighlighter.php');
// neccessary if you want to use the HsvHighlighter
// require_once('modules/oqc_ExternalContract/oqc_ExternalContractQuery.php'); 

class oqc_ExternalContractListViewData extends ListViewData {
	

	public function getListViewData($seed, $where, $offset=-1, $limit = -1, $filter_fields=array(),$params=array(),$id_field = 'id') {
		// add is_archived and warn_in_months field manually to list of fields that should be retrieved ($filter_fields). so we can be sure that we can access them in the $result array. this is needed for proper highlightning per contract
		$addedFilterFields = array_merge($filter_fields, array('is_archived'=>true, 'warn_in_months' => true));
		
		$isIndexView = !array_key_exists('searchFormTab', $_REQUEST); // user has opened the index view of the module but not used the search yet.
		$isBasicSearch = array_key_exists('searchFormTab', $_REQUEST) && 'basic_search' === $_REQUEST['searchFormTab']; // executing a basic search query
		$isQueryCleared = array_key_exists('clear_query', $_REQUEST) && $_REQUEST['clear_query']; // advanced/basic search. clicked on "Clear"
		
		if ($isIndexView || $isBasicSearch || $isQueryCleared) {
			$where = empty($where) ? ('is_archived = 0') : ($where . ' and is_archived = 0');
		}
		
		$result = parent::getListViewData($seed, $where, $offset, $limit, $addedFilterFields, $params, $id_field);

		/* calculate the maximum finalcosts value if you want to use the HsvHighlighter
		 * $contract = oqc_ExternalContractQuery::getBiggestExternalContract();
		 * $maxFinalcosts = $contract->finalcosts;
		 */
		
		// create Highlighter instance used for color calculation
		$highlighter = new RedYellowDateHighlighter();

		foreach ($result['data'] as &$externalContract) {
			// only highlight if
			// not archived and
			// some end date is set and
			// end date not in past (?) TODO how can we determine that..
			$isHighlighted = !$externalContract['IS_ARCHIVED'] && !empty($externalContract['ENDDATE']);
			
			if ($isHighlighted) {
				$externalContract['customRowColor'] = $highlighter->getHighlightningColor($externalContract['ENDDATE'], $externalContract['WARN_IN_MONTHS']);
			}
		}

		return $result;
	}
}
?>
