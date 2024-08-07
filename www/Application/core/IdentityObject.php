<?php

/*
 * 
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IdentityDomainObject
 *
 * @author Lisun
 */
require_once 'core/Field.php';

class IdentityObject {

    protected $currentfield = null;
    protected $fields = array();//созданные поля с операторами сравнения для sql запроса
    private $and = null;
    private $enforce = array();// Массив корректных имен полей 
    private $alias = null;
    
    function __construct($field = null, array $enforce = null,array $alias = null) {
        if (!is_null($enforce)) {
            $this->enforce = $enforce;
        }
        if (!is_null($alias)) {
            $this->alias = $alias;
        }
        if (!is_null($field)) {
            $this->field($field);
        }
    }

    function getObjectFields() {     
        return $this->enforce;
    }
    function getAlias() {     
        return $this->alias;
    }
    function field($fieldname) {
        if (!$this->isVoid() && $this->currentfield->isIncomplete()) {
            throw new Exception("Неполное поле:".$this->currentfield->getName());
        }
        $this->enforceField($fieldname);
        if (isset($this->fields[$fieldname])) {
            $this->currentfield = $this->fields[$fieldname];
        } else {
            $this->currentfield = new Field($fieldname);        
            $this->fields[$fieldname] = $this->currentfield;     
        }
        return $this;
    }
    //Проверка на наличие полей
    function isVoid() {
        return empty($this->fields);
    }
    //Проверка имени поля на корректность
    function enforceField($fieldname) {
        if (!in_array($fieldname, $this->enforce) && !empty($this->enforce)) {
            $forcelist = implode(',', $this->enforce);
            throw new Exception("{$fieldname} не является корректным полем {$forcelist}");
        }
    }
    function eq($value) {
        return $this->operator("=", $value);
    }
    function lt($value) {
        return $this->operator("<", $value);
    }
    function gt($value) {
        return $this->operator(">", $value);
    }
    private function operator($simbol, $value) {
        if ($this->isVoid()) {
            throw new Exception("Поле не определено");
        }
        $this->currentfield->addTest($simbol, $value);
        return $this;
    }
    function getComps() {
        $ret = array();
        foreach ($this->fields as $key => $field) {
            $ret = array_merge($ret, $field->getComps());
        }
    return $ret;
    }
}

class UserIdentityObject extends IdentityObject {
    function __construct($field = null) {
        print "Создается UserIdentityObject<br>";
        parent::__construct($field, array('id', 'login', 'password', 'hash', 'role_id', 'location_id'));
    }
}

class LocationIdentityObject extends IdentityObject {
    function __construct($field = null) {
        print "Создается LocationIdentityObject<br>";
        parent::__construct($field, array('id', 'type_id', 'name', 'comment'));
    }
}

class LocationStructureIdentitiObject extends IdentityObject{
    function __construct($field = null) {
        print "Создается LocationIdentityObject<br>";
        parent::__construct($field, array('id', 'parent_id', 'child_id'));
    }
}
