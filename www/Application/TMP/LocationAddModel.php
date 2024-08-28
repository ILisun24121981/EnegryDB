<?php

class LocationCreateModel extends Model {
    function process() {
        $array = array();
        $array['name'] = $this->req->get('name');        
        $array['type_id'] =$this->req->get('type_id');
        $array['parent_id'] =$this->req->get('parent_id');     
               
        $factory = locationPersistenceFactory::create();
        $obj = $factory->getDomainObjectFactory()->createObject($array);      
        $doa = $factory->finder();
        $doa->insert($obj);
        $this->req->addFeedback("Локация успешно добавлена");
        print "locationAddModel res:TRUE<br>";
        return true;
    }
}
