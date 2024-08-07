<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersistenceFactory
 *
 * @author Lisun
 */
require_once 'core/Collection.php';
require_once 'core/DomainObjectFactory.php';
require_once 'core/DomainObjectAssembler.php';
require_once 'core/SelectionFactory.php';
require_once 'core/UpdateFactory.php';
require_once 'core/IdentityObject.php';


abstract class PersistenceFactory {
    private $type;
    private $instance;
    
    function __construct() {
        $this->type = static::getType();
        print("Создается".$this->type."PersistanceFactory<br>");       
    }
    function getCollection(array $raw){
        $typestr = $this->type;
        $coll = $typestr."Collection";
        return new $coll($raw,$this->instance->getDomainObjectFactory());
    }
    function getDomainObjectFactory(){
        $typestr = $this->type;
        $dof = $typestr."DomainObjectFactory";
        return new $dof();
    }
    function getSelectionFactory(){
        $typestr = static::getType();
        $sfact = $typestr."SelectionFactory";
        return new $sfact();
    }
    function getUpdateFactory(){
        $typestr = static::getType();
        $upfact = $typestr."UpdateFactory";
        return new $upfact();
    }
    function getIdentityObject(){
        $typestr = static::getType();
        $idobj = $typestr."IdentityObject";
        return new $idobj();
    }
//    static function getFactory($typestr){
//        $pfact=$typestr."PersistenceFactory"; 
//        return new $pfact();
//    }
    static function create(){
        $pfact = new static();      
        return $pfact->setInstance($pfact);       
    }
    private function setInstance(PersistenceFactory $pfact){
        $this->instance = $pfact;
        return $this->instance;
    }
    function finder(){
        return new DomainObjectAssembler($this->instance);        
    }    
    static function getFinder($typestr){
        $pfact=$typestr."PersistenceFactory"; 
        return new DomainObjectAssembler($pfact::create());
    }
}

class UserPersistenceFactory extends PersistenceFactory{   
    static function getType(){
        return "User";
    }  
}
class LocationPersistenceFactory extends PersistenceFactory{   
    static function getType(){
        return "Location";
    }  
}


