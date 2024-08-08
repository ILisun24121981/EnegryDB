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
            $this->markNew();
        } else{
            $this->id = $id;           
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
    function markClean(){//после записи измененного объекта в БД
        ObjectWatcher::addClean($this);
    }
}

class User extends DomainObject {
//    const SUPERUSER = 0;
//    const ADMIN = 1;
//    const MANAGER = 2;
//    const TECHNICIAN = 4;
    private static $ROLE_STRINGS = array(
        'SUPERUSER'=>1,
        'ADMIN'=>2,
        'MANAGER'=>3,
        'TECHNICIAN'=>4
    );

    protected $_login;
    protected $_password;
    protected $_hash;
    protected $_role_id;
    protected $_location_id;

    function __construct(array $array) { 
        print "Создается UserDomainObject<br>";
        print ("массив для создания объекта: ");
        var_dump($array);       
        print ("<br>");        
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
}
//class SuperUser extends User {
//    function __construct(array $array) {
//        print "Создается SuperUserDomainObject<br>";
//        parent::__construct($array);
//    }   
//}
//
//class Admin extends User {         
//    function __construct(array $array) {
//        print "Создается AdminDomainObject<br>";
//        parent::__construct($array);
//    }  
//}
//
//class Manager extends User {        
//    function __construct(array $array) {
//        print "Создается ManagerDomainObject<br>" ;    
//        parent::__construct($array);
//    }
//}
//
//class Technician extends User {        
//    function __construct(array $array) {
//        print "Создается TechnicianDomainObject<br>";       
//        parent::__construct($array);
//    }
//}

class Location extends DomainObject {
    private $_type_id;
    private $_name;
    private $_comment;
    
    function __construct(array $array) {
        print "Создается LocationDomainObject<br>";
        parent::__construct($array);
    }
    
    function setName($login) {       
        $this->_name = $login;        
        $this->markDirty();
    }
    function getName() {
        return $this->_name;
    } 
    function setType($login) {       
        $this->_type_id = $login;        
        $this->markDirty();
    }
    function getType() {
        return $this->_type_id;
    }  
    function setComment($login) {       
        $this->_comment = $login;        
        $this->markDirty();
    }
    function getComment() {
        return $this->_comment;
    }   
}



