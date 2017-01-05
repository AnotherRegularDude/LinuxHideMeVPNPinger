<?php

namespace WhoCares;

class OpenvpnPinger
{
    const OVPN_FILE_NAME = 'hide_me.ovpn';
    const MATCH_PATTERN = "/remote ((?+1)+(\d+\.?))[0-9 ]+#[ ]?([[:alnum:] ]+),[ ]?([[:alnum:] ]+)/";

    private $vpnServers;

    private $minPing;
    private $bestServerPosition;

    public function __construct()
    {
        $this->vpnServers = [];
        $this->minPing = 10000;
        list($matchCount, $parsedData) = $this->parseOVPNFile();

        for ($i = 0; $i < $matchCount; ++$i) {
            $this->vpnServers[] = [
                'ip' => $parsedData[1][$i],
                'country' => $parsedData[3][$i],
                'city' => $parsedData[4][$i],
            ];
        }
    }

    public function getBestServer()
    {
        foreach ($this->vpnServers as $position => $serverData) {
            echo "Processing server {$serverData['country']} {$serverData['city']}... \n";
            $ping = $this->pingHost($serverData['ip']);

            if ($ping < $this->minPing) {
                $this->minPing = $ping;
                $this->bestServerPosition = $position;
            }
        }

        $this->prettyPrintResult();
    }

    private function prettyPrintResult()
    {
        $serverData = $this->vpnServers[$this->bestServerPosition];
        echo "Finished!\n";
        echo "Best server: {$serverData['country']} {$serverData['city']}\n";
        echo "Ping: $this->minPing\n";
        echo "Ip: {$serverData['ip']}\n";
        echo "GG WP!\n";
    }

    private function pingHost(string $host, int $count = 2)
    {
        $fnr = 'FNR == 2 { print $(NF-1) }';

        return intval(shell_exec("ping -c $count $host |  awk '$fnr' | cut -d'=' -f2"));
    }

    private function parseOVPNFile()
    {
        $matchCount = preg_match_all(self::MATCH_PATTERN, file_get_contents(self::OVPN_FILE_NAME), $matches);

        return [$matchCount, $matches];
    }
}
