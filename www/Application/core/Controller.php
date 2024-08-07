<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppController
 *
 * @author Lisun
 */
require_once 'core/Registry.php';//
require_once 'core/ProcessRequest.php';//описание классов обработчиков запроса
require_once 'core/Request.php';// 
require_once 'core/Validator.php';//
 
class Controller {    
    private function __construct() {                        
    }
    
    static function run(){              
        $instance = new Controller();
        $instance ->init();            
        $instance->handleRequest();
    }
    
    function init(){
        ApplicationRegistry::instance()->init();     
    }
        
    function handleRequest(){
        RequestRegistry::instance();
        $req = new Request();       
        $process = new SessionRequest(new LogRequest(new MainProcess()));
        $process->process($req);       
    }        
}
