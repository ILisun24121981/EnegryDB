<?php

class MainViewCommand extends Command {
    function __construct() {
        $ss = new AccesStrategy(array(User::role('SUPERUSER')));
        parent::__construct($ss);
    }
    function mainExecute(Request $req) {       
        return self::statuses('CMD_OK');
    }
}
