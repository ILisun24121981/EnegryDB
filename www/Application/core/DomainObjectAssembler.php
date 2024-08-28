<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainObjectAssambler
 *
 * @author Lisun
 */
require_once 'core/PersistenceFactory.php';
require_once 'core/IdentityObject.php';
require_once 'core/DomainObject.php';

class DomainObjectAssembler {
    private $_factory;
    protected static $PDO;

    function __construct(PersistenceFactory $factory) {
        print ("Создание DomainObjectAssembler (" . get_class($factory) . ")<br>");
        $this->_factory = $factory;
        if (!isset(self::$PDO)) {
            $dsn = ApplicationRegistry::getDSN();
            $user = ApplicationRegistry::getUserDB();
            $password = ApplicationRegistry::getPasswordDB();
            if (is_null($dsn)) {
                throw new AppExeption("DSN не определен");
            }
            self::$PDO = new PDO($dsn, $user, $password);
            self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        };
    }
    private function getStatement($str) {      
        print("Подготовленное выражение: " . $str . "<br>");
        return  self::$PDO->prepare($str);    
    }   
    function find(IdentityObject $idobj) {
        $selfact = $this->_factory->getSelectionFactory();
        list($selection, $values) = $selfact->newSelection($idobj);
        $stmt = $this->getStatement($selection);
        print ("Массив значений для поиска: ");
        var_dump($values);
        print("<br>");
        $stmt->execute($values);
        $raw = $stmt->fetchAll();
        print ("Массив извлеченных данных: ");
        var_dump($raw);
        print("<br>");
        return $raw;
    }
    function insert(DomainObject $obj) {
        $upfact = $this->_factory->getUpdateFactory();
        list($update, $values) = $upfact->newUpdate($obj);       
        $stmt = $this->getStatement($update);
        print ("Массив значений для обновления:");
        var_dump($values);
        $stmt->execute($values);
        if ($obj->getId() < 0) {
            $obj->setId(self::$PDO->lastInsertId());
        }
        $obj->markClean();
    }
}
