<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.detail.php');

class oqc_ContractViewDetail extends ViewDetail {

 	function oqc_ContractViewDetail(){
 		parent::ViewDetail();
 	}
 	
 	function display() {
	    
	    $currency = new Currency();
	    if(isset($this->bean->currency_id) && !empty($this->bean->currency_id))
	    {
	    	$currency->retrieve($this->bean->currency_id);
	    	if( $currency->deleted != 1){
	    		$this->ss->assign('CURRENCY', $currency->iso4217);
	    	}else {
	    	    $this->ss->assign('CURRENCY', $currency->getDefaultISO4217());	
	    	}
	    }else{
	    	$this->ss->assign('CURRENCY', $currency->getDefaultISO4217());
	    }
	   	    
 		parent::display();
 	}
}
?>