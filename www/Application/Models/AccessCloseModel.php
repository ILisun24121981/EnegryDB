<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessDeniedModel
 *
 * @author Lisun
 */
require_once 'core/PersistenceFactory.php';
require_once 'core/Model.php';

class AccessCloseModel extends Model{
    function process(){
        $userParams = SessionRegistry::getUserParams();
        if(is_null($userParams['login'])){
            //$this->req->addFeedback("Доступ уже закрыт");
            print "AccessDeniedModel res:TRUE<br>";
            return true;
        } else {
            $finder = PersistenceFactory::getFinder('User');
            $idobj = $finder->factory->getIdentityObject();
            $idobj->field('login')->eq($userParams['login']);
            $obj = $finder->findOne($idobj);
            $obj->setHash(null);
            $finder->insert($obj);           
            print "AccessDeniedModel res:TRUE<br>";
            return true;
        }        
    }
}
