<?php

require_once 'core/PersistenceFactory.php';

class AccessCloseModel{
    function process(){
        $userParams = SessionRegistry::getUserParams();
        if(!is_null($userParams['login'])){
            $pfact = PersistenceFactory::getInstance("User");
            $doa = PersistenceFactory::getDomainObjectAssambler($pfact);           
            $idobj = $pfact->getIdentityObject();
            $idobj->compField('login')->eq($userParams['login']);
            $raw = $doa->find($idobj);
            $user = $pfact->getCollection($raw)->next();
            $user->setHash(null);
            $doa->insert($user);           
        }        
    }
}
