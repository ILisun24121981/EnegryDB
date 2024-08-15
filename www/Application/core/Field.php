<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Field
 *
 * @author Lisun
 */
class Field {
    protected $_name = null;
    protected $_operator = null;
    protected $_comps = array();
    protected $_incomplite = false;
    
    function __construct($name) {
        print ("Создание класса Field с параметром name = ".$name."<br>");
        $this->_name = $name;
    }
    function addtest($operator, $value){
        $this->_comps[] = array('name'=>$this->_name,'operator'=>$operator,'value'=>$value);
        print("добавленный в класс Field с name = ".$this->_name." comp: ");
        var_dump($this->_comps);
        print("<br>");
    }
    function getComps(){
        return $this->_comps;
    }
    function isIncomplite(){
        return empty($this->_comps);
    }
    function getName(){
        return $this->_name;
    }
    function setName($name){
        $this->_name = $name;
    }
}

