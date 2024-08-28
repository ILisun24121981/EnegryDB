<?php

require_once 'core/CommonBase.php';
require_once 'core/Request.php';
require_once 'core/Command.php';


 class RequestRegistry extends SetGetValues{
     private static $instance;
     
     private function __construct(){
     }
     
     static function instance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    static function  getRequest(){
        return self::instance()->get('request');
    }
    static function setRequest(Request $request){
        return self::instance()->set('request',$request);
    }
 } 
 
 class SessionRegistry {
    private static $instance;
    
    private function __construct() {
        session_start();    
    }
    static function instance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    protected function get($key){
        if(isset($_SESSION[__CLASS__][$key])){
            var_dump($_SESSION[__CLASS__][$key]);
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }
    protected function set($key,$val){
        $_SESSION[__CLASS__][$key]=$val;
    }
    static function setUserParams($user){
        $ins = self::instance();
        $ins->set('User_id',$user->getId());
        $ins->set('User_login',$user->getLogin());
        $ins->set('User_hash',$user->getHash());
        $ins->set('User_role_Id',$user->getRoleId());
        $ins->set('User_location_id',$user->getLocationId());
    }
    static function getUserParams(){
        $userParams = array();
        $ins = self::instance();
        $userParams['id'] = $ins->get('User_id');
        $userParams['login'] = $ins->get('User_login');
        $userParams['hash'] = $ins->get('User_hash');
        $userParams['role_id'] = $ins->get('User_role_Id');
        $userParams['location_id'] = $ins->get('User_location_id');
        return $userParams;
    }
    static function setDefaultCommand(Command $cmd_obj,Request $req){
        $ins = self::instance();
        $cmdName = trim(get_class($cmd_obj),'Command');
        $ins->set('DefaultCmdName',$cmdName);
        $ins->set('DefaultCmdParams',$req->getAll());
    }
    static function getDefaultCommandName(){    
        return self::instance()->get('DefaultCmdName');
    }
    static function getDefaultCommandParams(){
        return self::instance()->get('DefaultCmdParams');
    }
    static function clearAll(){
        session_unset();
    }
}

class ApplicationRegistry extends SetGetValues{
    private static $instance;
    private $_configDir = "Application\Data";
    private $_configFile = "Configs.xml";   
     
    static function instance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
     
    function init(){       
        $sep = DIRECTORY_SEPARATOR;
        $path = $this->_configDir.$sep.$this->_configFile;      
        $this->ensure(file_exists($path), "Файл конфигурации не найден");       
        libxml_use_internal_errors(true);
        $options = @simplexml_load_file($path);       
        if ($options === false) {
            echo "Ошибка загрузки XML\n";
            foreach(libxml_get_errors() as $error) {
                echo "\t", $error->message;
            }
        }       
        $this->ensure($options instanceof SimpleXMLElement,"Файл конфигурации запорчен");     
        $dsn = (string)$options->dsn;      
        $this->ensure($dsn,"DSN не найден");
        self::setDSN($dsn);
        $userDB = (string)$options->userDB; 
        $this->ensure($userDB,"UserDB не найден");
        self::setUserDB($userDB);
        $passwordDB = (string)$options->passwordDB;      
        $this->ensure($passwordDB,"PassworsDB не найден");
        self::setPasswordDB($passwordDB);     
    } 
    
    private function ensure($expr,$message){
        if(! $expr){
            throw new Exception($message);
        }
    }  

    static function  getDSN(){
        return self::instance()->get('dsn');
    }   
    static function setDSN($dsn){
        return self::$instance->set('dsn',$dsn);
    }
    static function  getUserDB(){
        return self::instance()->get('userDB');
    }   
    static function setUserDB($userDB){
        return self::$instance->set('userDB',$userDB);
    }   
    static function  getPasswordDB(){
        return self::instance()->get('passwordDB');
    }   
    static function setPasswordDB($passwordDB){
        return self::$instance->set('passwordDB',$passwordDB);
    } 
    static function  getUser(){
        return self::instance()->get('user');
    }   
    static function setUser($user){
        return self::$instance->set('user',$user);
    } 
}
