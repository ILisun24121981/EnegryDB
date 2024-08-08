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
    public $factory;
    protected static $PDO;

    function __construct(PersistenceFactory $factory) {
        print ("Создание Finder = DomainObjectAssembler (" . get_class($factory) . ")<br>");
        $this->factory = $factory;
        if (!isset(self::$PDO)) {
            $dsn = ApplicationRegistry::getDSN();
            $user = ApplicationRegistry::getUserDB();
            print $user;
            $password = ApplicationRegistry::getPasswordDB();
            print $password;
            if (is_null($dsn)) {
                throw new AppExeption("DSN не определен");
            }
            print("dsn1:" . $dsn ."1". "<br>");
            self::$PDO = new PDO($dsn, $user, $password);
            self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        };
    }

    function getStatement($str) {      
        print("Подготовленное выражение: " . $str . "<br>");
        return  self::$PDO->prepare($str);    
    }

    function findOne(IdentityObject $idobj) {
        $collection = $this->find($idobj);
        return $collection->next();
    }

    function find(IdentityObject $idobj) {
        $selfact = $this->factory->getSelectionFactory();
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
        return $this->factory->getCollection($raw);
    }

    function insert(DomainObject $obj) {
        $upfact = $this->factory->getUpdateFactory();
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
