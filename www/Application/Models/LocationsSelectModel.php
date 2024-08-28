<?php
require_once 'core/Registry.php';

class LocationsSelectModel {
    function process(Request $req) {
        $pfact = PersistenceFactory::create("Location");
        $doa = PersistenceFactory::getDomainObjectAssambler($pfact);
        $idobj = $pfact->getIdentityObject();
        $idobj->selectFields(array('id','type_name','name','comment'));      
        $id = $req->get('id');              
        $idobj->compField('id')->eq($id);
        $locations = $doa->find($idobj);     
        $locations->setParentId($id);
        return $locations;
    }
}

