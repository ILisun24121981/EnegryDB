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
    function createObject(array $array){ //используется только для извлеченных из БД массивов, так как помечает объек как чистый        
        ObjectWatcher::instance();
        $old = ObjectWatcher::exists($this->targetClass(),$array['id']);
        if($old){
            return $old;
        }
        $obj = $this->doCreateObject($array);
        print("Созданный объект класса".get_class($obj).": ");
        print_r($obj);
        print ("<br>");
        ObjectWatcher::add($obj);
        //$obj->markClean();
        print("состояние объекта ObjectWatcher: ");
        print_r(ObjectWatcher::instance());
        print ("<br>");
        return $obj;
    }
    abstract function doCreateObject(array $array);
    abstract function targetClass();
}

class UserDomainObjectFactory extends DomainObjectFactory{    
    function doCreateObject(array $array) {
//        switch ($array['role_id']) {
//            case User::SUPERUSER:
//                $obj = new Admin($array);    
//                break;
//            case User::ADMIN:
//                $obj = new Admin($array);    
//                break;
//            case User::MANAGER:
//                $obj = new Manager($array);
//                break;
//            case User::TECHNICIAN:
//                $obj = new Manager($array);
//                break;
//            default :             
//        }
        return $obj = new User($array);
    }
    function targetClass() {
        return "User";
    }
}

