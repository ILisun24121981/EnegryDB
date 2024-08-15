<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UpdateFactory
 *
 * @author alex
 */
require_once 'core/DomainObject.php';

abstract class UpdateFactory {
    abstract function newUpdate(DomainObject $obj);
    protected function buildStatement($table, array $fields, array $condition = null) {
        $terms = array();
        if (!is_null($condition)) {
            $query = "UPDATE {$table} SET ";
            $query.= implode("=?,", array_keys($fields)) . "=?";
            $terms = array_values($fields);
            $cond = array();
            $query.= "WHERE ";
            foreach ($condition as $key => $val) {
                $cond[] = "$key=?";
                $terms[] = $val;
            }
            $query.= implode("AND", $cond);
        } else {
            $query = "INSERT INTO {$table}(";
            $query.= implode(",", array_keys($fields));
            $query.= ") VALUES (";
            foreach ($fields as $name => $value) {
                $terms[] = $value;
                $qs[] = '?';
            }
            $query.= implode(",", $qs);
            $query.= ")";
        }
        return array($query, $terms);
    }
}

class UserUpdateFactory extends UpdateFactory {
    function newUpdate(DomainObject $obj) {
        $id = $obj->getId();
        $cond = null;
        $values['login'] = $obj->getLogin();
        $values['hash'] = $obj->getHash();
        $values['password'] = $obj->getPassword();
        $values['role_id'] = $obj->getRoleId();
        if ($id > -1) {
            $cond['id'] = $id;
        }
        return $this->buildStatement("users", $values, $cond);
    }
}

