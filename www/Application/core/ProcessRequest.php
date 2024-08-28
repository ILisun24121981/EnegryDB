<?php

require_once 'core/Registry.php';
require_once 'core/Request.php';
require_once 'core/AppController.php';
require_once 'core/View.php';

abstract class ProcessRequest {
    abstract function process(Request $req);
}

abstract class DecorateProcess extends ProcessRequest{
    protected $_processrequest;
    function __construct(ProcessRequest $pr) {
        $this->_processrequest = $pr;
    }
}

class MainProcess extends ProcessRequest {
    private $_appController;
    function __construct(AppController $appC){
       $this->_appController = $appC; 
    }
    function process(Request $req) {      
        while ($cmd = $this->_appController->getCommand($req)) {
            $cmd->execute($req);
        }
        $this->invokeView($this->_appController->getView($req));       
    }
    function invokeView($target) {
        print "<br>Вид:$target";
        $view = new View();
        include("Views/$target.php");
        exit();
    }
}

class LogRequest extends DecorateProcess {
    function process(Request $req) {
        //print __CLASS__.":регистрация запроса <br>";
        $this->_processrequest->process($req);
    }
}

class SessionRequest extends DecorateProcess {
    function process(Request $req) {
        //print __CLASS__.":Создание Сессии <br>";
        SessionRegistry::instance();
        if (!$req->get('cmd')){
            $req->setAll(SessionRegistry::getDefaultCommandParams());
        }
        $this->_processrequest->process($req);
    }
}
