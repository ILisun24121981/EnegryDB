<?php

abstract class SelectionFactory {    
    function newSelection(IdentityObject $obj) {
        $fields = $obj->getObjectFields();
        $alias = $obj->getAlias();
         if(!is_null($alias)){
            foreach ($alias as $key => $value){                
                $i = array_search($key, $fields);
                if($i){
                    $fields[$i] = $key.' AS '.$value;
                }
            }
        }
        $fields = implode(',', $fields);  
        $core = $this->buildCore($fields);
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
//                $comp['name']= preg_replace('/_id/','.id',$comp['name']);
//                print "FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF";
//                var_dump($comp['name']);
//               //return("Недопустимые символы");
//            //}
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
class LocationStructureSelectionFactory extends SelectionFactory{    
    function __construct() {
         print "Создается LocationStructureSelectionFactory<br>";
    }   
    function buildCore($fields) {
        return "SELECT $fields FROM location_structure";
    }
}
