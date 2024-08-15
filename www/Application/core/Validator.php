<?php

class Validator {
    private static $Massage = array();
    
    static $MoreSimbols;
    static $validSimbols;
    static $onlyLettersAndDigits;
    
    static function init() {
        self::$MoreSimbols = function($num) {
            return function($v) use ($num) {
                return strlen($v) >= $num ? true : (strlen($v)!= 0 ? "не может содержать меньше {$num} символов": "не может быть пустым");
            };
        };

        self::$validSimbols = function($v){                      
            //$cmd = str_replace(array('.',$sep),"",$v);
            if (preg_match('/\W/', $v)) {              
               return("Недопустимые символы");
            }           
            return true;
        };
        
        self::$onlyLettersAndDigits = function($v){  
            if(!preg_match("/^[a-zA-Z0-9]+$/",$v)){
                return "может содержать только буквы английского алфавита и цифры";
            }
            return true;
        };
    }
    
    static function AddMassage($field,$massage){
        self::$Massage[$field] = $massage;
    }
    static function GetMassage($field){
        if(isset(self::$Massage[$field])){
            return self::$Massage[$field];
        }else{
            return null;
        }
    }
}
