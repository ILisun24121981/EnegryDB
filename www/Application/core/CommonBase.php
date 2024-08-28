<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SetGetValues {
    private $_values = array();
    
    public function get($key){
        if(isset ($this->_values[$key])){
            return $this->_values[$key];
        }
        return null;
    }   
    public function set($key, $val) {
        $this-> _values[$key]=$val;
    }
    
    public function setAll($vals){
        $this->_values = $vals;
    }
    public function getAll(){
        if(empty($this->_values))
            return null;
        return $this->_values;
    }   
}

function getXML(){
    
}