<?php
require_once 'core/PersistenceFactory.php';

class AccessCheckModel{
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
            if(is_null($user)){
                //ищем в базе данных
                $finder = PersistenceFactory::getFinder('User');
                $idobj = $finder->factory->getIdentityObject();
                $idobj->compField('login')->eq($userParams['login']);
                $user = $finder->findOne($idobj); 
                if (is_null($user)){
                    $this->req->addFeedback("Пользователь не определен");
                    print "AccessCheckModel res:FALSE1<br>";
                    return false;
                } 
            }                            
            ApplicationRegistry::setUser($user);
            if(!empty($this->_roles)){
                $role = $user->getRoleId();
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
