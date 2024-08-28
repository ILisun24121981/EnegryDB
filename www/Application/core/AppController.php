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


class AppController {
    private static $base_cmd;
    private $_map;
    private $_invoked = array();
    
    
    function __construct(AppMap $map) {
        $this->_map =$map;      
        self::$base_cmd = new ReflectionClass("Command");                
    }
    
    function getView (Request $req){        
        $view = $this->getResource("View",$req);        
        return $view;      
    }   
    function getForward (Request $req){       
        $forward = $this->getResource("Forward",$req);
        if($forward){
            $req->set('cmd', $forward);
        }
        return $forward;
    }
       
    private function getResource($res, Request $req){
        //определим предыдущую команду и ее код состояния
        $cmd_Name = $req->get('cmd');
        if(!isset($cmd_Name)){
            $cmd_Name = SessionRegistry::getDefaultCommandName();
        }
        $cmd_real_Name = $this->_map->getClassroot($cmd_Name); 
        $previous = $req->getLastCommand();
        $status = $previous->getStatus();       
        $acquire = "get$res";       
        //определим ресурс для предидущей команды и ее кода состояния
        $resource = $this->_map->$acquire($cmd_real_Name,$status);            
        return $resource;       
    }
    
    function  getCommand(Request $req){
        $sep = DIRECTORY_SEPARATOR;              
        $previous = $req->getLastCommand();
        if(!$previous){
            //print "<br>Это первая команда текущего запроса<br>";
            $cmd_Name = $req->get('cmd'); 
            if(!$cmd_Name){
                $cmd_Name = SessionRegistry::getDefaultCommandName();
                if(!$cmd_Name){
                    $cmd_Name = 'Default';
                    $req->setCmdName($cmd_Name);                                 
                }             
            }else{
                $cmd_Name = str_replace(array('.',$sep),"",$cmd_Name);
                if (preg_match('/\W/', $cmd_Name)) {
                    throw new Exception("Недопустимые символы в комманде");
                }    
            }                               
        }else{
            $cmd_Name = $this->getForward($req);
            if(!$cmd_Name){return null;};
        }
        $cmd_real_Name = $this->_map->getClassroot($cmd_Name); 
        $cmd_obj = $this->resolveCommand($cmd_real_Name);        
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
                    return $cmd_class->newInstance();
                }
                throw new Exception("function:resolveCommand - Класс '$cmd_class' не является командой");
            }
            throw new Exception("function:resolveCommand - Класс '$cmd_class' не обнаружен");
        }
        throw new Exception("function:resolveCommand - Файл '$filepath' не обнаружен");      
    }          
}
