<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainObjectFactory
 *
 * @author Lisun
 */
require_once 'core/ObjectWatcher.php';
require_once 'core/DomainObject.php';

abstract class DomainObjectFactory {
    function createObject(array $array){        
        ObjectWatcher::instance();
        $old = ObjectWatcher::exists($this->targetClass(),$array['id']);
        if($old){
            return $old;
        }
        $obj = $this->doCreateObject($array);
        //print("Созданный объект класса".get_class($obj).": ");
        //print_r($obj);
        //print ("<br>");
        ObjectWatcher::add($obj);
        //print("состояние объекта ObjectWatcher: ");
        //print_r(ObjectWatcher::instance());
        //print ("<br>");
        return $obj;
    }
    abstract function doCreateObject(array $array);
    abstract function targetClass();
}

class UserDomainObjectFactory extends DomainObjectFactory{    
    function doCreateObject(array $array) {
        return $obj = new User($array);
    }
    function targetClass() {
        return "User";
    }
}
class LocationDomainObjectFactory extends DomainObjectFactory{    
    function doCreateObject(array $array) {
        return $obj = new location($array);
    }
    function targetClass() {
        return "Location";
    }
}
