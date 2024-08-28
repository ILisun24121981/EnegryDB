<?php
require_once 'core/Registry.php';

class LocationStructureBackModel {
    function process(Request $req) {
        $id = $req->get('id');
        $pfact = PersistenceFactory::getInstance("Location");
        $doa = PersistenceFactory::getDomainObjectAssambler($pfact);
        $idobj = $pfact->getIdentityObject();
        $idobj->selectFields(array('parent_id','parent_name'));                           
        $idobj->compField('id')->eq($id);
        $raw = $doa->find($idobj);
        $id = $raw[0]['parent_id'];
        $pfact = PersistenceFactory::getInstance("LocationStructure");
        $doa = PersistenceFactory::getDomainObjectAssambler($pfact);       
        $idobj = $pfact->getIdentityObject();
        $idobj->selectFields(array('id','type_name','name','comment'));           
        $idobj->compField('parent_id')->eq($id);
        $raw = $doa->find($idobj);
        $locations = $pfact->getCollection($raw);
        $locations->setParentId($id);               
        $locations->setParentName($raw[0]['parent_name']); 
        return $locations;
    }
}

