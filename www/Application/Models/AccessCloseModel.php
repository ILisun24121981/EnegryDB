<?php

require_once 'core/PersistenceFactory.php';

class AccessCloseModel{
    function process(){
        $userParams = SessionRegistry::getUserParams();
        if(is_null($userParams['login'])){
            //$this->req->addFeedback("Доступ уже закрыт");
            print "AccessCloseModel res:TRUE<br>";
            return true;
        } else {
            $finder = PersistenceFactory::getFinder('User');
            $idobj = $finder->factory->getIdentityObject();
            $idobj->field('login')->eq($userParams['login']);
            $obj = $finder->findOne($idobj);
            $obj->setHash(null);
            $finder->insert($obj);           
            print "AccessCloseModel res:TRUE<br>";
            return true;
        }        
    }
}
