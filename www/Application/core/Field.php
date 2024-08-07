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
    protected $name = null;
    protected $operator = null;
    protected $comps = array();
    protected $incomplite = false;
    
    function __construct($name) {
        print ("Создание класса Field с параметром name = ".$name."<br>");
        $this->name = $name;
    }
    function addtest($operator, $value){
        $this->comps[] = array('name'=>$this->name,'operator'=>$operator,'value'=>$value);
        print("добавленный в класс Field с name = ".$this->name." comp: ");
        var_dump($this->comps);
        print("<br>");
    }
    function getComps(){
        return $this->comps;
    }
    function isIncomplite(){
        return empty($this->comps);
    }
    function getName(){
        return $this->name;
    }
}

