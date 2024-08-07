<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessCheckerModel
 *
 * @author Lisun
 */
require_once 'core/Model.php';
require_once 'core/PersistenceFactory.php';

class AccessCheckModel extends Model{
    private $_roles = array();
    
    function _construct(array $roles = null){
        if (!is_null($roles)) {
            $this->_roles = $roles;
        }
    }   
    function process(){ 
        $userParams = SessionRegistry::getUserParams();
        if(is_null($userParams['login'])){
            $this->req->addFeedback("необходима авторизация<br>");
            return false;
        } else {
            //ищем в созданных объектах
            $user = ObjectWatcher::exists('User', $userParams['id']);
            if(is_null($obj)){
                //ищем в базе данных
                $finder = PersistenceFactory::getFinder('User');
                $idobj = $finder->factory->getIdentityObject();
                $idobj->field('login')->eq($userParams['Login']);
                $user = $finder->findOne($idobj); 
                if (is_null($user)){
                    $this->req->addFeedback("Пользователь не определен");
                    print "AccessCheckModel res:FALSE1<br>";
                    return false;
                } 
            }                            
            ApplicationRegistry::setUser($user);
            if(!empty($this->_roles)){
                $role = $obj->getRoleId();
                foreach($this->_roles as $key =>$role_id){
                    if ($role = $role_id) {
                        break;
                    }else{
                        $this->req->addFeedback("Нет доступа");
                        print "AccessCheckModel res:FALSE2<br>";
                        return false;
                    }
                }
            }
            if ($user->getHash() != $userParams['hash']) {
                $this->req->addFeedback("Ошибка Хеш");
                print "AccessCheckModel res:FALSE3<br>";
                return false;
            }
            if ($user->getHash() == null) {
                $this->req->addFeedback("Не установлен Хеш");
                print "AccessCheckModel res:FALSE4<br>";
                return false;
            }
            print "AccessCheckerModel res:TRUE<br>";
            return true;            
        }
    }   
}
