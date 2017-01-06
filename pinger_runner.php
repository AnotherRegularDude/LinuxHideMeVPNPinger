<?php
/*
    Here programm start its life.
    I will add console support later.
*/
require_once __DIR__."/vendor/autoload.php";

$mainPinger = new App\Libs\OpenvpnPinger(__DIR__."/configs/hide_me.ovpn");
$mainPinger->getBestServer();
