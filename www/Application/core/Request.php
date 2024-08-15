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
require_once 'core/CommonBase.php';//

class Request extends SetGetValues{
    private $_feedback = array();   
    private $_executed_cmd_object = null;
    
    function __construct(){
        $this->init();        
        RequestRegistry::setRequest($this);
    }
    
    function init(){
        if(isset($_SERVER["REQUEST_METHOD"])){          
            $this->setAll($_REQUEST);             
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
                    $this->set($key,$val);                  
                }
            }
            //var_dump($this->properties);
//            if(strpos($arg,'=')){                                            
//                list($key,$val)=explode("=",$arg);
//                $this->set($key,$val);
//            }
        }
        $this->set('REQUEST_URI' ,$_SERVER['REQUEST_URI']);
        $this->set('REQUEST_TIME',$_SERVER['REQUEST_TIME']);
        $this->set('REMOTE_ADDR',$_SERVER['REMOTE_ADDR']);
    } 
       
    function addFeedback($msg){
        array_push($this->_feedback,$msg);       
    }
    
    function getFeedback(){
        return $this->_feedback;
    }
    
    function getFeedbackString($separator ="\n"){
        if(!Empty($this->_feedback)){
            return implode($separator,$this->_feedback);
        }
        return null;
    } 
    function setCmdName($name){
       $this->set('cmd',$name);
    }
    
    function getLastCommand(){
        return $this->_executed_cmd_object;
    }
    
    function setLastCommand(Command $cmd_obj){
        $this->_executed_cmd_object = $cmd_obj;
    }
}
