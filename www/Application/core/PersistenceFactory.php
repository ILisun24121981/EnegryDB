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


class PersistenceFactory {
    private $_type;
    
    private function __construct() {
        $this->_type = static::getType();
        print("Создается".$this->_type."PersistanceFactory<br>");       
    } 
    static function getInstance($typestr){
        $pfact=$typestr."PersistenceFactory"; 
        return new $pfact();
    }
    // Создает объект хранящий поля и условия выборки
    function getIdentityObject(){
        $typestr = $this->_type;
        $idobj = $typestr."IdentityObject";
        return new $idobj();
    }
    // Создает объект конструирующий выражение выборки из базы данных на основе identity object(объект хранящий поля и условия выборки)
    function getSelectionFactory(){
        $typestr = $this->_type;
        $sfact = $typestr."SelectionFactory";
        return new $sfact();
    }
    function getUpdateFactory(){
        $typestr = $this->_type;
        $upfact = $typestr."UpdateFactory";
        return new $upfact();
    }
    // Создает объект коллекции из массива полученного из базы данных
    function getCollection(array $raw){
        $typestr = $this->_objectType;
        $coll = $typestr."Collection";
        return new $coll($raw,$this->getDomainObjectFactory());
    }
    // Создает объект фабрику по созданию объектов 
    private function getDomainObjectFactory(){
        $typestr = $this->_objectType;
        $dof = $typestr."DomainObjectFactory";
        return new $dof();
    }
    
    static function getDomainObjectAssambler(PersistenceFactory $pfact){       
        return new DomainObjectAssembler($pfact);
    } 
    function finder(){
        return new DomainObjectAssembler($this);        
    } 
}

class UserPersistenceFactory extends PersistenceFactory{
    protected $_objectType = "User";
    static function getType(){
        return "User";
    }  
}
class LocationPersistenceFactory extends PersistenceFactory{
    protected $_objectType = "location";
    static function getType(){
        return "Location";
    }  
}
class LocationStructurePersistenceFactory extends PersistenceFactory{
    protected $_objectType = "location";
    static function getType(){
        return "LocationStructure";
    }   
}


