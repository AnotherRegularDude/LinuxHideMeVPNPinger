<?php
/**
 * Main file, run CLI from here.
 *
 * @todo More CLI feautures.
 */
require_once __DIR__.'/vendor/autoload.php';

$cliHandler = new App\Libs\Console();
$pingCount  = $cliHandler->getPingCount();
if (empty($pingCount) === true) {
    $pingCount = 2;
}

$mainPinger = new App\Libs\OpenvpnPinger(
    $cliHandler->getConfigFilePath(),
    $pingCount
);

if ($cliHandler->isMutted() === true) {
    $mainPinger->setOutputBehavior(true);
}

$mainPinger->getBestServer();
$mainPinger->prettyPrintResult();
