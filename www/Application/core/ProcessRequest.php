<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 * классы алгоритма обработки HTTP запроса (шаблон Decorator)
 * @author Lisun
 */
require_once 'core/Registry.php';
require_once 'core/Request.php';
require_once 'core/Controller.php';
require_once 'core/View.php';

abstract class ProcessRequest {

    abstract function process(Request $req);
}

abstract class DecorateProcess extends ProcessRequest {

    protected $processrequest;

    function __construct(ProcessRequest $pr) {
        $this->processrequest = $pr;
    }
}

class MainProcess extends ProcessRequest {

    function process(Request $req) {       
        //print __CLASS__ . ":выполнение запроса <br>";
        $app_c = ApplicationRegistry::getApplicationController();
        while ($cmd = $app_c->getCommand($req)) {
            $cmd->execute();
        }
        $this->invokeView($app_c->getView($req));       
    }

    function invokeView($target) {
        print "<br>Вид команды:$target";
        $view = new View();
        include("Views/$target.php");
        exit();
    }
}

class LogRequest extends DecorateProcess {

    function process(Request $req) {
        //print __CLASS__.":регистрация запроса <br>";
        $this->processrequest->process($req);
    }

}

class SessionRequest extends DecorateProcess {

    function process(Request $req) {
        SessionRegistry::instance();
        //print __CLASS__.":Создание Сессии <br>";
        $this->processrequest->process($req);
    }

}
