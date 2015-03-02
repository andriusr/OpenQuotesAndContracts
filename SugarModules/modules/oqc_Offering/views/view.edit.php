<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class oqc_OfferingViewEdit extends ViewEdit {

    function oqc_OfferingViewEdit(){
        parent::ViewEdit();
    }
    
	function display() {
        $this->ev->process();
		if ( !empty($_REQUEST['account_name']) && !empty($_REQUEST['account_id'])
            && $this->ev->fieldDefs['company']['value'] == ''
            && $this->ev->fieldDefs['company_id']['value'] == '') {
            $this->ev->fieldDefs['company']['value'] = $_REQUEST['account_name'];
            $this->ev->fieldDefs['company_id']['value'] = $_REQUEST['account_id'];
        }
        echo $this->ev->display(); 
        
        //parent::display();
      /*  echo "
            <script language='javascript'>
                function contact_accountChanged(field) {
                    filter = '&account_name=' + document.getElementById('company').value; 
                    open_popup('Contacts', 600, 400, filter, true, false, {'call_back_function':'set_return','form_name':'EditView','field_to_name_array':{'id':field+'_id','name':field}}, 'single', true);
                }
            		if (document.getElementById('btn_clientcontact')) {
                	document.getElementById('btn_clientcontact').onclick=function(){return contact_accountChanged('clientcontact')}
         			};
         			if (document.getElementById('btn_clienttechnicalcontact')) {
                document.getElementById('btn_clienttechnicalcontact').onclick=function(){return contact_accountChanged('clienttechnicalcontact')}
         			};
            </script>";  
        return; */
        
	}
}
?>