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
        $array['Login'] =$this->req->getProperty('Login');        
        $array['Password'] =$this->req->getProperty('Password');
        $array['Role_id'] =$this->req->getProperty('Role_id');
        $array['Location_id'] =$this->req->getProperty('Location_id');
                     
        $factory = LocationPersistenceFactory::create();
        $obj = $factory->getDomainObjectFactory()->createObject($array);      
        $finder = $factory->finder();
        $finder->insert($obj);
        $this->req->addFeedback("Пользователь успешно добавлен");
        return true;
    }
}
