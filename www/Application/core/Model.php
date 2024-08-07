<?php

class Model {
    protected $req;

    function __construct(Request $req) {
        $this->req = $req;
        //$this->observers = array();                    
    }
}
