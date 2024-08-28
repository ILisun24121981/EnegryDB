<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddCompanyModel
 *
 * @author Lisun
 */
class UserAddModel extends Model {
    function process() {
        $array = array();
        $array['Login'] =$this->req->get('Login');        
        $array['Password'] =$this->req->get('Password');
        $array['Role_id'] =$this->req->get('Role_id');
        $array['Location_id'] =$this->req->get('Location_id');
                     
        $factory = UserPersistenceFactory::create();
        $obj = $factory->getDomainObjectFactory()->createObject($array);      
        $doa = $factory->finder();
        $doa->insert($obj);
        $this->req->addFeedback("Пользователь успешно добавлен");
        return true;
    }
}
