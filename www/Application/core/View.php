<?php

class View{	
    private $content = array();
    private $js = array();
    private $css = array();

    function generate($template_view) {

        $userParams = SessionRegistry::getUserParams();
        $user = ObjectWatcher::exists('User', $userParams['id']);
      
        $content = $this->content;
        $js = $this->js;
        $css = $this->css;       
        include 'Application/Views/Templates/'.$template_view.".php";
    }
    function add_content($content,$destination) {        
        $this->content[$destination][] = $content.".php";       
    }
    function add_js($js) {        
        $this->js[] = $js.".js";       
    }
    function add_css($css){
        $this->css[] = $css.".css"; 
    }
}
