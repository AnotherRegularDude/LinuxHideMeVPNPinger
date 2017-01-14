<?php
/**
 * Definitions for DI.
 */

use function DI\object as object;

return [
        'settings.pathToFile'  => __DIR__.'/../resources/hideme.ovpn',
        'settings.parseRegexp' => '/remote ((?+1)+(\d+\.?))[0-9 ]+#[ ]?([[:alnum:] ]+),[ ]?([[:alnum:] ]+)/',
       ];
