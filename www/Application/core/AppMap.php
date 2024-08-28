<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerMap
 *
 * @author Lisun
 */
class AppMap {
    private $_mapDir = "Application\Data";
    private $_mapFile = "AppMap.xml";   
    private $_viewMap        = array();
    private $_forwardMap     = array();
    private $_classrootMap   = array();
    
    function init(){
        $sep = DIRECTORY_SEPARATOR;
        $path = $this->_mapDir.$sep.$this->_mapFile;      
        if( !file_exists($path)){
            throw new Exception("Файл карты не найден");
        }
        libxml_use_internal_errors(true);
        $map = @simplexml_load_file($path);       
        if ($map === false) {
            echo "Ошибка загрузки XML\n";
            foreach(libxml_get_errors() as $error) {
                echo "\t", $error->message;
            }
        }       
        if( !($map instanceof SimpleXMLElement)){
            throw new Exception("Файл карты запорчен");
        }
        foreach ($map->view as $default_view){           
            $stat_str = trim($default_view['status']);
            $status = Command::status($stat_str);
            $this->addview( trim((string)$default_view),'default',$status);                                 
        }                     
        foreach ($map->command as $command){
            $cmd_name= trim($command['name']);
            if(isset($command->classroot)){
                $this->addClassroot($cmd_name,trim((string)$command->classroot[0]));
            }
            if(isset($command->forward)){               
                $this->addForward($cmd_name,trim((string)$status->forward[0]));
            }
            if (isset($command->view)) {
                foreach ($command->view as $view){
                    if(isset($view['status'])) {
                        $stat_str = trim($view['status']);
                        $stat = Command::status($stat_str);
                        $this->addView(trim((string)$view),$cmd_name,$stat);
                    }else{
                        $this->addView(trim((string)$view),$cmd_name);
                    }
                }
            }
            if(isset($command->status)){
                foreach ($command->status as $status){                                
                    $stat_str = trim($status['value']);
                    $stat = Command::status($stat_str);
                    if(isset($status->view)){                       
                        $this->addView(trim((string)$status->view[0]),$cmd_name,$stat);
                    }
                    if(isset($status->forward)){ 
                        $this->addForward($cmd_name,trim((string)$status->forward[0]),$stat);
                    }
                }                            
            }     
        }       
    }
    
    function addClassroot($command,$classroot){
        $this->_classrootMap[$command] = $classroot;
    }
    
    function getClassroot($command){
        if(isset($this->_classrootMap[$command])){
            return $this->_classrootMap[$command];
        }
        return $command;
    }
    
    function addView($view,$command='default',$status = 0){
        $this->_viewMap[$command][$status] = $view;
    }
    
    function getView($command, $status){
        if(isset($this->_viewMap[$command][$status])){
            return $this->_viewMap[$command][$status];
        }
        return null;
    }
    
    function addForward($command,$newCommand,$status = 0){
        $this->_forwardMap[$command][$status] = $newCommand;
    }
    
    function getForward($command,$status){
         if(isset($this->_forwardMap[$command][$status])){
            return $this->_forwardMap[$command][$status];
        }
        return null;
    }
}
