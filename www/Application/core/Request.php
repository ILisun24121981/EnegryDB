<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author Lisun
 */
require_once 'core/Registry.php';//

class Request {
    private $properties;
    private $feedback = array();   
    private $cmd_obj;
    
    function __construct(){
        $this->cmd_obj = null; 
        $this->init();        
        RequestRegistry::setRequest($this);
    }
    
    function init(){
        if(isset($_SERVER["REQUEST_METHOD"])){          
            $this->properties = $_REQUEST;             
            return;
        }
//        var_dump($_SERVER);
//        print "BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB";
//        var_dump($_REQUEST);
//       print ("REQUEST_METOD:".$_SERVER['REQUEST_METOD']."<br>");
//        print ($_SERVER['argv']."<br>");
        
        foreach ($_SERVER['argv'] as $arg){           
            //print ("arg:".$arg."<br>");
            $par_val = explode("&",$arg);
            
            //var_dump($par_val);
            foreach ($par_val as $p_v){
                if(strpos($p_v,'=')){                                            
                    list($key,$val)=explode("=",$p_v);
                    $this->setProperty($key,$val);                  
                }
            }
            //var_dump($this->properties);
//            if(strpos($arg,'=')){                                            
//                list($key,$val)=explode("=",$arg);
//                $this->setProperty($key,$val);
//            }
        }
        $this->setProperty('REQUEST_URI' ,$_SERVER['REQUEST_URI']);
        $this->setProperty('REQUEST_TIME',$_SERVER['REQUEST_TIME']);
        $this->setProperty('REMOTE_ADDR',$_SERVER['REMOTE_ADDR']);
    } 
       
    function setProperty($key,$val){
        $this->properties[$key]=$val;
    }
    
    function getProperty($key){        
        if(isset($this->properties[$key])){
            return $this->properties[$key];
        }
    }    
    function addFeedback($msg){
        array_push($this->feedback,$msg);       
    }
    
    function getFeedback(){
        return $this->feedback;
    }
    
    function getFeedbackString($separator ="\n"){
        return implode($separatpr,$this->feedback);
    } 
    
    function getLastCommand(){
        return $this->cmd_obj;
    }
    
    function setLastCommand(Command $cmd_obj){
        $this->cmd_obj = $cmd_obj;
    }
}
