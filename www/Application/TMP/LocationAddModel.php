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
class LocationAddModel extends Model {

    function process() {
        $array = array();
        $array['Name'] = $this->req->getProperty('Name');        
        $array['Type_id'] =$this->req->getProperty('Type_id');
        $array['Parent_id'] =$this->req->getProperty('Parent_id');     
               
        $factory = locationPersistenceFactory::create();
        $obj = $factory->getDomainObjectFactory()->createObject($array);      
        $finder = $factory->finder();
        $finder->insert($obj);
        $this->req->addFeedback("Локация успешно добавлена");
        print "locationAddModel res:TRUE<br>";
        return true;
    }
}
