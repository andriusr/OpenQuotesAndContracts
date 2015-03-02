<?php
require_once('include/MVC/Controller/SugarController.php');

class oqc_TextblockController extends SugarController
{
	function action_save() {
		$old_id = $this->bean->id;

		// create new version
		unset($this->bean->id);
		parent::action_save();

		// redirect to new version
		$this->return_id = $this->bean->id;
		
		// hide old version
		$this->bean->mark_deleted($old_id);
	}
	
	function modifySearch($searchField)
	{	
		if (($_REQUEST[$searchField] != '') && (substr($_REQUEST[$searchField], 0, 1) != '%'))
			$_REQUEST[$searchField] = '%' . $_REQUEST[$searchField];
	}
	
	function process() 
	{
		if (isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'basic_search') 
		{
			$this->modifySearch('subject_basic');
			$this->modifySearch('description_basic');
		} else
		if (isset($_REQUEST['searchFormTab']) && $_REQUEST['searchFormTab'] == 'advanced_search') 
		{
			$this->modifySearch('name_advanced');
			$this->modifySearch('description_advanced');
		}
		
		parent::process();
	}
}

?>
