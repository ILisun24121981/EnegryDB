<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SetGetValues {
    private $values = array();
    
    public function get($key){
        if(isset ($this->values[$key])){
            return $this->values[$key];
        }
        return null;
    }   
    function set($key, $val) {
        $this-> values[$key]=$val;
    }
    
    protected function setAll($vals){
        $this-> values = $vals;
    }
    
}
