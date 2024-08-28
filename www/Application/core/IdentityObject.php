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
    
    protected $_curCompField = null;
    protected $_compFields;//Массив созданных полей сравнения(с условиями сравнения) для оператора Where
    private $_selectFildsNames;//Массив имен полей для выборки
    private $_fieldNames;// Массив допустимых полей сравнения
    private $_aliases; // Массив алиасов полей сравнения
    
    function __construct(array $_fieldNames,array $aliases =null) {
        if (!is_null($_fieldNames)) {
            $this->_fieldNames = $_fieldNames;
        }
        if (!is_null($aliases)) {
            foreach($aliases as $aliase=>$value){
                $this->checkField($aliase);
            }
            $this->_aliases = $aliases;
        }      
    }
   
    function getSelectFieldsNames() {
        if(empty($this->_selectFildsNames)){
            return $this->_fieldNames;//все поля
        }
        return $this->_selectFildsNames;
    }
    
    function assignAliases(){
        if(!is_null($this->_aliases)){
            foreach ($this->_aliases as $alias => $value){                
                $i = array_search($alias, $this->_selectFildsNames);
                if(is_integer($i)){
                    $this->_selectFildsNames[$i] = $value.' AS '.$alias;
                }
            }
        }
    }
    function SelectFields(array $fieldNames){
        foreach($fieldNames as $key =>$fieldName){
            $this->checkField($fieldName);
        }
        $this->_selectFildsNames = $fieldNames;
    }
    function compField($fieldName) {
        if (!$this->isVoid() && $this->_curCompField->isIncomplete()) {
            throw new Exception("Неполное поле сравнения:".$this->_curCompField->getName());
        }
        $this->checkField($fieldName);
        if($this->_aliases){
            foreach ($this->_aliases as $alias => $value){                
                if($fieldName == $alias){
                    $fieldName = $value;
                }   
            }
        }
        if (isset($this->_compFields[$fieldName])) {
            $this->_curCompField = $this->_compFields[$fieldName];
        } else {
            $this->_curCompField = new Field($fieldName);        
            $this->_compFields[$fieldName] = $this->_curCompField;     
        }
        return $this;
    }
    //Проверка на наличие полей
    function isVoid() {
        return empty($this->_compFields);
    }
    //Проверка имени поля на корректность(возможность выбора в качестве поля сравнения)
    private function checkField($fieldName) {
        if (!in_array($fieldName, $this->_fieldNames) && !empty($this->_fieldNames)) {
            $copmFieldNames = implode(',', $this->_fieldNames);
            throw new Exception("{$fieldName} не является корректным полем {$copmFieldNames}");
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
        $this->_curCompField->addTest($simbol, $value);
        return $this;
    }
    function getComps() {
        $ret = array();
        foreach ($this->_compFields as $key => $field) {
            $ret = array_merge($ret, $field->getComps());
        }
    return $ret;
    }
}

class UserIdentityObject extends IdentityObject {
    function __construct($field = null) {
        print "Создается UserIdentityObject<br>";
        parent::__construct(array('id', 'login', 'password', 'hash', 'role_id', 'location_id'));
    }
}
class LocationIdentityObject extends IdentityObject {
    function __construct($field = null) {
        print "Создается LocationIdentityObject<br>";
        parent::__construct(array('id','name','comment','type_id','type_name','parent_id','parent_name'),
                array ('id'=>'locations.id',
                       'name'=>'locations.name',
                       'comment'=>'locations.comment',
                       'type_id'=>'location_types.id',
                       'type_name'=>'location_types.name',
                       'parent_id'=>'location_structure.parent_id',
                       'parent_name'=>'locations.name'));       
    }
}
class LocationStructureIdentityObject extends IdentityObject {
    function __construct($field = null) {
        print "Создается LocationIdentityObject<br>";
        parent::__construct(array('id','name','comment','type_name','parent_id'),
                array ('id'=>'location_structure.child_id',
                       'name'=>'locations.name',
                       'comment'=>'locations.comment',
                       'type_name'=>'location_types.name',
                       'parent_id'=>'location_structure.parent_id'));       
    }
}

