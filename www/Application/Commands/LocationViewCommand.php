<?php

class LocationViewCommand extends Command {
    function __construct() {
        $ss = new AccesStrategy();
        parent::__construct($ss);
    }
    function mainExecute(Request $req) {
        SessionRegistry::getDefaultCommand($this);
        return self::statuses('CMD_OK');
    }
}
