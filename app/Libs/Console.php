<?php

namespace App\Libs;

use App\Helpers\ArrayAdditional;

/**
 * Helps with CLI arguments.
 *
 * @todo: Folder with ovpn files for parsing.
 */
class Console
{
    use ArrayAdditional;

    const DEFAULT_PATH = __DIR__.'/../../configs/hide_me.ovpn';

    private $_parsedOpts;

    private $_shortOpts = 'sf:p:';
    private $_longOpts  = [
                           'silence',
                           'file:',
                           'ping-count:',
                          ];


    public function __construct()
    {
        $this->_parsedOpts = getopt($this->_shortOpts, $this->_longOpts);

    }//end __construct()


    public function isMutted()
    {
        if ($this->_anyInArray(array_keys($this->_parsedOpts), ['s', 'silence']) === true) {
            return true;
        }

        return false;

    }//end isMutted()


    public function getConfigFilePath()
    {
        $pathToFile = $this->_valueAtAnyKey($this->_parsedOpts, ['f', 'file']);
        if (empty($pathToFile) === true) {
            return self::DEFAULT_PATH;
        }

        if (file_exists($pathToFile) === false) {
            return  self::DEFAULT_PATH;
        }

        return $pathToFile;

    }//end getConfigFilePath()


    public function getPingCount()
    {
        $pingCount = $this->_valueAtAnyKey($this->_parsedOpts, ['p', 'ping-count']);
        if (isset($pingCount) === true && $pingCount > 0) {
            return $pingCount;
        }

        return null;

    }//end getPingCount()


}//end class
