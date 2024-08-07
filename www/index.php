<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//phpinfo();
ini_set('display_errors', 1);
ini_set('session.save_path', __DIR__."/Application/Session/tmp");
set_include_path(get_include_path().";".__DIR__."/Application");
set_include_path(get_include_path().";".__DIR__."/Application/Views/ViewContent");
require_once 'core/Controller.php';
error_reporting( E_ALL & ~E_NOTICE );
Controller::run();

?>