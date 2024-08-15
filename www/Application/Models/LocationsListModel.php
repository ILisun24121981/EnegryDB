<?php
require_once 'core/Registry.php';

class LocationsListModel {
    function process(Request $req) {        
        $finder = PersistenceFactory::getFinder('Location');
        $idobj = $finder->factory->getIdentityObject();
        $idobj->selectFields(array('id','type_name','name','comment'));
        $parentId = $req->get('parent_id');
        if(!$parentId){
            $userParams = SessionRegistry::getUserParams();
            $parentId = $userParams['location_id'];
        }       
        $idobj->compField('parent_id')->eq($parentId);
        $locations = $finder->find($idobj);    
        $locations->setParentLocationName($req->get('location_name')); 
        $user = ApplicationRegistry::getUser();
        $user->setLocationsCollection($locations);
    }
}

