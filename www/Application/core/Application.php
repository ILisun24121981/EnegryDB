<?php

require_once 'core/Registry.php';
require_once 'core/AppMap.php';
require_once 'core/AppController.php';
require_once 'core/Request.php';
require_once 'core/ProcessRequest.php';
 
class Application {
    private function __construct() {                        
    }
    
    static function run(){              
        $instance = new Application();            
        $instance->handleRequest();
    }
        
    function handleRequest(){
        ApplicationRegistry::instance()->init();
        $appMap = new AppMap();
        $appMap->init();
        $appController = new AppController($appMap);       
        $req = new Request();          
        $process = new SessionRequest(new LogRequest(new MainProcess($appController)));
        $process->process($req);       
    }        
}
