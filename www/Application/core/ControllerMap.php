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
class ControllerMap {
    private $viewMap        = array();
    private $forwardMap     = array();
    private $classrootMap   = array();
    
    function _constructor(&$options){
        init($options);
    }
    
    function init($options){
        foreach ($options->view as $default_view){           
            $stat_str = trim($default_view['status']);
            $status = Command::statuses($stat_str);
            $map->addview( trim((string)$default_view),'default',$status);                                 
        }                     
        foreach ($options->command as $command){
            $cmd_name= trim($command['name']);
            if(isset($command->classroot)){
                $map->addClassroot($cmd_name,trim((string)$command->classroot[0]));
            }
            if(isset($command->forward)){               
                $map->addForward($cmd_name,trim((string)$status->forward[0]));
            }
            if (isset($command->view)) {
                foreach ($command->view as $view){
                    if(isset($view['status'])) {
                        $stat_str = trim($view['status']);
                        $stat = Command::statuses($stat_str);
                        $map->addView(trim((string)$view),$cmd_name,$stat);
                    }else{
                        $map->addView(trim((string)$view),$cmd_name);
                    }
                }
            }
            if(isset($command->status)){
                foreach ($command->status as $status){                                
                    $stat_str = trim($status['value']);
                    $stat = Command::statuses($stat_str);
                    if(isset($status->view)){                       
                        $map->addView(trim((string)$status->view[0]),$cmd_name,$stat);
                    }
                    if(isset($status->forward)){ 
                        $map->addForward($cmd_name,trim((string)$status->forward[0]),$stat);
                    }
                }                            
            }     
        }       
    }
    
    function addClassroot($command,$classroot){
        $this->classrootMap[$command] = $classroot;
    }
    
    function getClassroot($command){
        if(isset($this->classrootMap[$command])){
            return $this->classrootMap[$command];
        }
        return $command;
    }
    
    function addView($view,$command='default',$status = 0){
        $this->viewMap[$command][$status] = $view;
    }
    
    function getView($command, $status){
        if(isset($this->viewMap[$command][$status])){
            return $this->viewMap[$command][$status];
        }
        return null;
    }
    
    function addForward($command,$newCommand,$status = 0){
        $this->forwardMap[$command][$status] = $newCommand;
    }
    
    function getForward($command,$status){
         if(isset($this->forwardMap[$command][$status])){
            return $this->forwardMap[$command][$status];
        }
        return null;
    }
}
