<?php
$dictionary['oqc_default'] = array (
    'table' => 'oqc_default', 
    'fields' => array (
       array('name' =>'id', 'type' =>'char', 'len'=>'36', 'required'=>true, 'default'=>''),
       array('name' =>'user_id', 'type' =>'char', 'len'=>'36'),
       array('name' =>'module', 'type' =>'varchar', 'len'=>'50'),
       array('name' =>'param', 'type' =>'varchar', 'len'=>'50'),
       array('name' =>'value', 'type' =>'varchar', 'len'=>'50'),
       array('name' =>'date_modified','type' => 'datetime'),
       array('name' =>'deleted', 'type' =>'bool', 'len'=>'1', 'required'=>true, 'default'=>'0')
    ),
    'indices' => array (
       array('name' =>'oqc_defaultpk', 'type' =>'primary', 'fields'=>array('id'))
    ),
    'relationships' => array (
    
  	)
);

?>