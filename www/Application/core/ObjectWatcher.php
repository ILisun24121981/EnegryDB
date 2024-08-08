<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjectWatcher
 *
 * @author Lisun
 */
class ObjectWatcher {
    private $all = array();
    private $dirty = array();
    private $new = array();
    private $delete = array();
  
    private static $instance;
    
    private function __construct() {       
    }
    
    static function instance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    function globalKey(DomainObject $obj){
        $key = get_class($obj).".".$obj->getId();
        return $key;
    }
    
    static function  add(DomainObject $obj){
        $inst = self::instance();
        $inst->all[$inst->globalKey($obj)]=$obj;       
    }
    
    static function exists($classname, $id){
        $inst = self::instance();
        $key = "$classname.$id";
        if(isset($inst->all[$key])){
            return $inst->all[$key];
        }
        return null;
    }
    
    static function addDelete(DomainObject $obj){
        $inst = self::instance();
        $inst->delete[$inst->globalKey($obj)]=$obj;
    }
    
    static function addDirty(DomainObject $obj){
        $inst = self::instance();
        if(!in_array($obj, $inst->new, true)){
            $inst->delete[$inst->globalKey($obj)]=$obj;
        }
    }
    
    static function addNew(DomainObject $obj){
        $inst = self::instance();
        //У нас еще нет идентификатора ID
        $inst->new[]=$obj;
    }
    
    static function addClean(DomainObject $obj){
        $inst = self::instance();
        //unset($inst->delete[$inst->globalKey[$obj]]);
        unset($inst->dirty[$inst->globalKey($obj)]);
        $inst->new = array_filter($inst->new, function($a) use ($obj){return !($a === $obj);});
    }
    
    function performOperations(){
        foreach ($this->dirty as $key=>$obj){
            $obj->finder()->update($obj);
        }
        foreach ($this->new as $key=>$obj){
            $obj->finder()->insert($obj);
        }
        $this->dirty = array();
        $this->new = array();
    }
}
