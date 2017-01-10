<?php

namespace App\Libs;

/**
 * App's main class, which provides ping and parsing methods.
 */
class OpenvpnPinger
{
    const MATCH_PATTERN = '/remote ((?+1)+(\d+\.?))[0-9 ]+#[ ]?([[:alnum:] ]+),[ ]?([[:alnum:] ]+)/';

    private $_vpnServers = [];
    private $_minPing    = 10000;
    private $_silent     = false;

    private $_pingHostCount;
    private $_ovpnFilePath;
    private $_bestServerPosition;


    public function __construct(string $ovpnFilePath, int $pingHostCount = 0)
    {
        $this->_ovpnFilePath           = $ovpnFilePath;
        $this->_pingHostCount          = $pingHostCount;
        list($matchCount, $parsedData) = $this->_parseOVPNFile();

        for ($i = 0; $i < $matchCount; ++$i) {
            $this->_vpnServers[] = [
                                    'ip'      => $parsedData[1][$i],
                                    'country' => $parsedData[3][$i],
                                    'city'    => $parsedData[4][$i],
                                   ];
        }

    }//end __construct()


    public function setOutputBehavior(bool $printOnlyResult)
    {
        $this->_silent = $printOnlyResult;

    }//end setOutputBehavior()


    public function getBestServer()
    {
        foreach ($this->_vpnServers as $position => $serverData) {
            $this->_outputMessage("Processing server {$serverData['country']}, {$serverData['city']}... \n");
            $ping = $this->_pingHost($serverData['ip']);
            if (boolval($ping) === false) {
                $this->_outputMessage("Server doesn't responde, skipping...\n");
                continue;
            }

            if ($ping < $this->_minPing) {
                $this->_minPing            = $ping;
                $this->_bestServerPosition = $position;
            }
        }

        return isset($this->_bestServerPosition);

    }//end getBestServer()


    public function prettyPrintResult()
    {
        $serverData = $this->_vpnServers[$this->_bestServerPosition];
        echo "Finished!\n";
        echo "Best server: {$serverData['country']} {$serverData['city']}\n";
        echo "Ping: $this->_minPing\n";
        echo "Ip: {$serverData['ip']}\n";
        echo "GG WP!\n";

    }//end prettyPrintResult()


    private function _outputMessage(string $message)
    {
        if ($this->_silent === false) {
            echo $message;
        }

    }//end _outputMessage()


    private function _pingHost(string $host)
    {
        $fnr = 'FNR == 2 { print $(NF-1) }';

        return intval(shell_exec("ping -c {$this->_pingHostCount} $host 2>/dev/null | awk '$fnr' | cut -d'=' -f2"));

    }//end _pingHost()


    private function _parseOVPNFile()
    {
        $matchCount = preg_match_all(self::MATCH_PATTERN, file_get_contents($this->_ovpnFilePath), $matches);

        return [
                $matchCount,
                $matches,
               ];

    }//end _parseOVPNFile()


}//end class
