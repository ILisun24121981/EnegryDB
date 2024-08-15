<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainObject
 *
 * @author Lisun
 * 
 */

 require_once 'core/DomainObjectFactory.php';
 require_once 'core/PersistenceFactory.php';
 require_once 'core/ObjectWatcher.php';
 
abstract class DomainObject {
    private $id =-1;

    function __construct($id = null) {
        if(is_null($id)){
            $this->markNew();//Создается не из базы данных
        } else{
            $this->id = $id;
            $this->markClean();//Создается из базы данных
        }
    }
    function getId() {
        return $this->id;
    }
    function setId($id) {
        $this->id = $id;
    }
    static function getCollection($type) {
        return PersistenceFactory::getCollection($type);
    }
    function collection() {
        return self::getCollection(get_class($this));
    }
    static function getFinder($typestr){
        return PersistenceFactory::getFinder($typestr);
    }
    function finder(){
        return self::getFinder(get_class($this));
    }    
    function markNew(){//когда создается новый объект без извлечения из БД
        ObjectWatcher::addNew($this);
    }
    function markDeleted(){
        ObjectWatcher::addDelete($this);
    }
    function markDirty(){//когда делаются изменения в объекте
        ObjectWatcher::addDirty($this);
    }
    function markClean(){//после записи измененного объекта в БД б либо при создании из базы данных
        ObjectWatcher::addClean($this);
    }
}

class User extends DomainObject {
    private static $ROLE_STRINGS = array(
        'SUPERUSER'=>1,
        'ADMIN'=>2,
        'MANAGER'=>3,
        'TECHNICIAN'=>4
    );

    private $_login;
    private $_password;
    private $_hash;
    private $_role_id;
    private $_location_id;
    
    protected $_locationCollection;
    

    function __construct(array $array) { 
        //print "Создается UserDomainObject<br>";
        //print ("массив для создания объекта: ");
        //var_dump($array);       
        //print ("<br>");        
        $this->_login  = $array['login'];
        $this->_password = $array['password'];
        $this->_hash = $array['hash'];
        $this->_role_id = $array['role_id'];
        $this->_location_id = $array['location_id'];
        if(isset ($array['id'])){
           parent::__construct($array['id']);
        }else{          
           parent::__construct(); 
        }
    }
    static function role($str = 'TECHNICIAN'){
        if(empty($str)){
           $str = 'TECHNICIAN'; 
        }
        return self::$ROLE_STRINGS[$str];
    }

    function setLogin($login) {       
        $this->_login = $login;        
        $this->markDirty();
    }
    function getLogin() {
        return $this->_login;
    }   
    function setPassword($pass) {
        $this->_password = $pass;
        $this->markDirty();
    }
    function getPassword(){
        return $this->_password;
    }
    function setRoleId($role) {
        $this->_role_id = $role;
        $this->markDirty();
    }
    function getRoleId(){
        return $this->_role_id;
    }
    function setHash($hash) {
        $this->_hash = $hash;
        $this->markDirty();
    }
    function getHash(){
        return $this->_hash;
    }
    function setLocationId($login) {       
        $this->_location_id = $login;        
        $this->markDirty();
    }
    function getLocationId() {
        return $this->_location_id;
    }
    function setLocationsCollection(LocationCollection $locations) {
        $this->_locationCollection = $locations;
    }

    function getLocationsCollection() {      
        return $this->_locationCollection;
    }
}

class Location extends DomainObject {
    private $_type;
    private $_name;
    private $_comment;
    
    function __construct(array $array) {
        //print "Создается LocationDomainObject<br>";
        $this->_type  = $array['type_name'];
        $this->_name = $array['name'];
        $this->_comment = $array['comment'];
        if(isset ($array['id'])){
           parent::__construct($array['id']);
        }else{          
           parent::__construct(); 
        }
    }
    
    function setName($name) {       
        $this->_name = $name;        
        $this->markDirty();
    }
    function getName() {
        return $this->_name;
    } 
    function setType($typeName) {       
        $this->_type = $typeName;        
        $this->markDirty();
    }
    function getType() {
        return $this->_type;
    }  
    function setComment($comment) {       
        $this->_comment = $login;        
        $this->markDirty();
    }
    function getComment() {
        return $this->_comment;
    }   
}



