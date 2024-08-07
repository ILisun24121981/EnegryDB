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
require_once 'core/Command.php';
require_once 'core/Validator.php';
require_once 'core/Registry.php';


class ApplicationController {
    private static $base_cmd;
    private static $default_cmd;
    private $controllerMap;
    private $invoked = array();
    
    
    function __construct(ControllerMap $map) {
        $this->controllerMap =$map;
        if(! self::$base_cmd){
            self::$base_cmd = new ReflectionClass("Command");
            $defaultCmdName = SessionRegistry::getDefaultCommandName();
            if($defaultCmdName != null){
                
            }else{
                 self::$default_cmd = new LoginViewCommand();
            }           
        }   
    }
    
    function getView (Request $req){        
        $view = $this->getResource($req,"View");        
        return $view;      
    }   
    function getForward(Request $req){       
        $forward = $this->getResource($req,"Forward");
        if($forward){
            $req->setProperty('cmd', $forward);
        }
        return $forward;
    }
       
    private function getResource(Request $req, $res){
        //определим предыдущую команду и ее код состояния
        $cmd_str = $req->getProperty('cmd');
        $previous = $req->getLastCommand();
        $status = $previous->getStatus();       
        $acquire = "get$res";       
        //определим ресурс для предидущей команды и ее кода состояния
        $resource = $this->controllerMap->$acquire($cmd_str,$status);        
        //определим альтернативный ресурс для команды и кода состояния 0
        if(!$resource){
            $resource = $this->controllerMap->$acquire($cmd_str, 0);
        }        
//        //Либо для команды 'default' и текущего кода состояния
//        if(!$resource){
//            $resource = $this->controllerMap->$acquire('Default', $status);
//        }
//        //Если ничего не найдено , определим ресурс для команды 'default' и кода состояния 0
//        if(!$resource){
//            $resource = $this->controllerMap->$acquire('Default', 0);
//        }     
        return $resource;       
    }
    
    function  getCommand(Request $req){
        $sep = DIRECTORY_SEPARATOR;              
        $previous = $req->getLastCommand();
        if(!$previous){
            //print "<br>Это первая команда текущего запроса<br>";
            $cmd = $req->getProperty('cmd');                    
            $cmd = str_replace(array('.',$sep),"",$cmd);
            if (preg_match('/\W/', $cmd)) {
                throw new AppException("Недопустимые символы в комманде");
            }            
            if(!$cmd){
                $req->setProperty('cmd', 'Default');              
                return self::$default_cmd;
            }
        }else{
            $cmd = $this->getForward($req);
            if(!$cmd){return null;};
        }       
        $cmd_obj = $this->resolveCommand($cmd);        
        $cmd_class = get_class($cmd_obj);
        if(isset($this->invoked[$cmd_class])){
            throw new AppException("Циклический вызов");
        }
        $this->invoked[$cmd_class]=1;       
        return $cmd_obj;
    }
    
    function resolveCommand($cmd){
        $sep = DIRECTORY_SEPARATOR;      
        $classroot = $this->_map->getClassroot($cmd)."Command";              
        $filepath = "Application".$sep."Commands".$sep.$classroot.".php";                      
        $classname = "$classroot";
        if(file_exists($filepath)){           
            require_once ("$filepath");
            if(class_exists($classname)){              
                $cmd_class = new ReflectionClass($classname);                
                if($cmd_class->isSubclassOf(self::$base_cmd)){
                    $req = &$this->_request;
                    return $cmd_class->newInstance($req);
                }
                throw new AppException("function:resolveCommand - Класс '$cmd_class' не является командой");
            }
            throw new AppException("function:resolveCommand - Класс '$cmd_class' не обнаружен");
        }
        throw new AppException("function:resolveCommand - Файл '$filepath' не обнаружен");      
    }          
}
