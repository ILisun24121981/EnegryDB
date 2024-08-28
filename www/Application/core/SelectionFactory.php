<?php

abstract class SelectionFactory {    
    function newSelection(IdentityObject $obj) {
        $obj->assignAliases();
        $selFields = $obj->getSelectFieldsNames();       
        $selFields = implode(',', $selFields);  
        $core = $this->buildCore($selFields);
        list($where,$values) = $this ->buildWhere($obj);        
        return array($core." ".$where, $values);
    }  
    function buildWhere(IdentityObject $obj){
        if($obj->isVoid()){
            return array("",array());
        }
        $compstrings = array();
        $values = array();
        foreach ($obj->getComps() as $comp){
            $compstrings[] = "{$comp['name']}{$comp['operator']} ?";
            $values[]= $comp['value'];    
        }            
        $where = "WHERE ".implode(" AND ",$compstrings);        
        return array($where,$values);
    }
    abstract function buildCore($fields);   
}

class UserSelectionFactory extends SelectionFactory{    
    function __construct() {
         print "Создается UserSelectionFactory<br>";
    }   
    function buildCore($fields) {
        return "SELECT $fields FROM users";
    }
}
class LocationSelectionFactory extends SelectionFactory{    
    function __construct() {
         print "Создается LocationSelectionFactory<br>";
    }   
    function buildCore($fields) {
        return "SELECT $fields FROM 
        (
            (locations INNER JOIN location_types ON locations.type_id = location_types.id)
            INNER JOIN location_structure ON locations.id = location_structure.child_id
	)";
    }
}

class LocationStructureSelectionFactory extends SelectionFactory{    
    function __construct() {
         print "Создается LocationCollectionSelectionFactory<br>";
    }   
    function buildCore($fields) {
        return "SELECT $fields FROM 
            (
                (location_structure INNER JOIN locations ON location_structure.child_id = locations.id)
                INNER JOIN location_types ON locations.type_id = location_types.id
            )";
    }
}
