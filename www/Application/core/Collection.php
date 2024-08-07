<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Collection
 *
 * @author Lisun
 */
require_once 'core/Interfaces.php';

abstract class Collection implements MyIterator {    
    protected $dofactory;
    protected $total;
    protected $raw = array();//необработанные данные 
    
    private $pointer = 0;
    private $objects = array();
    
    abstract function targetClass();
    function __construct(array $raw = null , DomainObjectFactory $dofactory = null) {
        if(!is_null($raw)&&!is_null($dofactory)){                    
            $this->raw = $raw;
            $this->total = count($raw);
        }       
        $this->dofactory = $dofactory;       
    }
    public function count(){
        return $this->total;
    }        
    function add(DomainObject $object){
        $class = $this->targetClass();
        if(!($object instanceof $class)){
            throw new Exception ("Это коллекция{$class}: невозможно добавить ");
        }
        $this->objects[$this->total]=$object;
        $this->total++;
    }
    private function getRow($num){      
        if($num >= $this->total){         
            return null;
        }
        if(isset($this->objects[$num])){
            return $this->objects[$num];
        }
        if(isset($this->raw[$num])){             
            $this->objects[$num] = $this->dofactory->createObject($this->raw[$num]);
            return $this->objects[$num];
        }
    }
    public function rewind(){ //помещает указатель в начало списка
       $this->pointer=0;     
    }
    public function current(){//возвращает элемент находящийся в текущей позиции указателя
        return $this->getRow($this->pointer);     
    }
    public function key(){//возвращает текущий ключ
        return $this->pointer;        
    }
    public function next(){//возвращает элемент в текущей позиции указателя, и перемещаетуказатель на следующую позицию              
        $row= $this->getRow($this->pointer);
        if($row){
            $this->pointer++;
            return $row;
        }    
    }
    public function valid(){//подтверждает что существует элемент в текущей позиции указателя
        return (!is_null($this->current()));       
    }
}

class UserCollection extends Collection{
    function __construct(array $raw = null, UserDomainObjectFactory $dofactory = null) {        
        print "Создается UserCollection<br>";
        parent::__construct($raw,$dofactory);
    }
    function targetClass() {
        return "User";
    }   
}

class LocationCollection extends Collection{
    function __construct(array $raw = null) {
        $dofactory = new CompanyDomainObjectFactory();
        print "Создается LocationCollection<br>";
        parent::__construct($raw,$dofactory);
    }
    function targetClass() {
        return "Location";
    }   
}

