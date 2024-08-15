<?php

require_once 'core/PersistenceFactory.php';

class AccessCloseModel{
    function process(){
        $userParams = SessionRegistry::getUserParams();
        if(!is_null($userParams['login'])){      
            $finder = PersistenceFactory::getFinder('User');
            $idobj = $finder->factory->getIdentityObject();
            $idobj->compField('login')->eq($userParams['login']);
            $obj = $finder->findOne($idobj);
            $obj->setHash(null);
            $finder->insert($obj);           
        }        
    }
}
