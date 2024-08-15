<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessModel
 *
 * @author Lisun
 */
require_once 'core/PersistenceFactory.php';
require_once 'core/DomainObject.php';
require_once 'core/Request.php';
require_once 'core/Registry.php';

class AccessOpenModel {    
    function process(Request $req){         
        $login = $req->get('login');        
        $password =$req->get('password');              
        $finder = PersistenceFactory::getFinder('User');
        $idobj = $finder->factory->getIdentityObject();
        $idobj->compField('login')->eq($login);   
        $user = $finder->findOne($idobj);
        if(is_null($user)){
            $req->addFeedback("Проверьте Логин");
            //print "AccessModel res:FALSE<br>";  
            return false;            
        }
        if($user->getPassword() != $password){
            $req->addFeedback("Проверьте Пароль");
            //print "AccessModel res:FALSE<br>";
            return false;
        }
        //установим hash       
        $hash = md5($this->generateCode(10));
        $user->setHash($hash);        
        //обновим в БД
        $finder->insert($user);       
        SessionRegistry::setUserParams($user);
        print "AccessModel res:TRUE<br>";
        return true;
    }    
    function generateCode($length = 6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }
}
