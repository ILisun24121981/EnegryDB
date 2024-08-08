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
require_once 'Commands/LoginCommand.php';


class ApplicationController {
    private static $base_cmd;
    private $_request;
    private $_map;
    private $_invoked = array();
    
    
    function __construct(ControllerMap $map,Request $req) {
        $this->_request = $req;
        $this->_map =$map;      
        self::$base_cmd = new ReflectionClass("Command");                
    }
    
    function getView (){        
        $view = $this->getResource("View");        
        return $view;      
    }   
    function getForward (){       
        $forward = $this->getResource("Forward");
        if($forward){
            $this->_request->setProperty('cmd', $forward);
        }
        return $forward;
    }
       
    private function getResource($res){
        //определим предыдущую команду и ее код состояния
        $cmd_Name = $this->_request->getProperty('cmd');
        $cmd_real_Name = $this->_map->getClassroot($cmd_Name); 
        $previous = $this->_request->getLastCommand();
        $status = $previous->getStatus();       
        $acquire = "get$res";       
        //определим ресурс для предидущей команды и ее кода состояния
        $resource = $this->_map->$acquire($cmd_real_Name,$status);            
        return $resource;       
    }
    
    function  getCommand(){
        $sep = DIRECTORY_SEPARATOR;              
        $previous = $this->_request->getLastCommand();
        if(!$previous){
            //print "<br>Это первая команда текущего запроса<br>";
            $cmd_Name = $this->_request->getProperty('cmd'); 
            if(!$cmd_Name){
                $cmd_Name = SessionRegistry::getDefaultCommandName();
                if(!$cmd_Name){
                    $cmd_Name = 'Default';
                    $this->_request->setProperty('cmd', 'Default');                                 
                }             
            }else{
                $cmd_Name = str_replace(array('.',$sep),"",$cmd_Name);
                if (preg_match('/\W/', $cmd_Name)) {
                    throw new AppException("Недопустимые символы в комманде");
                }    
            }                               
        }else{
            $cmd_Name = $this->getForward($this->_request);
            if(!$cmd_Name){return null;};
        }       
        $cmd_obj = $this->resolveCommand($cmd_Name);        
        $cmd_class = get_class($cmd_obj);
        if(isset($this->_invoked[$cmd_class])){
            throw new AppException("Циклический вызов");
        }
        $this->_invoked[$cmd_class]=1;       
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
                    return $cmd_class->newInstance($this->_request);
                }
                throw new AppException("function:resolveCommand - Класс '$cmd_class' не является командой");
            }
            throw new AppException("function:resolveCommand - Класс '$cmd_class' не обнаружен");
        }
        throw new AppException("function:resolveCommand - Файл '$filepath' не обнаружен");      
    }          
}
