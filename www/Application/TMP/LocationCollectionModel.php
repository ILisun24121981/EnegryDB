<?php

require_once 'core/PersistenceFactory.php';

class LocationCollectionModel extends Model {
    function process(){        
        $user = ApplicationRegistry::getUser();
        $finder = PersistenceFactory::getFinder('Location');
        $idobj = $finder->factory->getIdentityObject();
        $idobj->field('parent_id')->eq($user->getLocationId());
        $collection = $finder->find($idobj);
        if($collection->count() != 0){
            $user->setCompanies($collection);
        }else{
            $this->req->addFeedback("Необходимо добавить компании");
        }        
        return true;
    }   
}
