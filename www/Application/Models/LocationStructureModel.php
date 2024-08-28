<?php
require_once 'core/Registry.php';

class LocationStructureModel {
    function process(Request $req) {
        $pfact = PersistenceFactory::getInstance("LocationStructure");
        $doa = PersistenceFactory::getDomainObjectAssambler($pfact);       
        $idobj = $pfact->getIdentityObject();
        $idobj->selectFields(array('id','type_name','name','comment'));      
        $id = $req->get('id');       
        if(!$id){           
            $userParams = SessionRegistry::getUserParams();
            $id = $userParams['location_id'];            
        }
        $name = $req->get('name');        
        $idobj->compField('parent_id')->eq($id);
        $raw = $doa->find($idobj);
        $locations = $pfact->getCollection($raw);
        $locations->setParentId($id);
        if($name){           
            $locations->setParentName($name);
        } 
        return $locations;
    }
}

