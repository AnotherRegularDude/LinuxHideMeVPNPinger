<?php

namespace App\Services;

use Webmozart\Assert\Assert;

/**
 * Parses ovpn files, and returns structured array with server's info.
 */
class SettingsParser
{
    private $_matchRegexp;


    /**
     * Set configs with scalar values from DI.
     *
     * @param string $matchRegexp Regular expression, that gets all info about remote servers.
     *
     * @Inject({"settings.parseRegexp"})
     */
    public function setDefaultConfigs(string $matchRegexp)
    {
        $this->_matchRegexp = $matchRegexp;

    }//end setDefaultConfigs()


    /**
     * Parse ovpn file at $pathToFile and return formatted info.
     *
     * @param string $pathToFile Path to parsed file.
     *
     * @return array parsed info by keys: [ip, city, country].
     */
    public function parseFile(string $pathToFile)
    {
        $this->_checkFile($pathToFile);
        list($matchCount, $mathes) = $this->_parseFileWithRegexp($pathToFile);

        return $this->_beautifyMatchedResults($mathes, $matchCount);

    }//end parseFile()


    /**
     * Checks file existance and read access.
     *
     * @throws \InvalidArgumentException if script can't access provided file;
     */
    private function _checkFile(string $pathToFile)
    {
        Assert::fileExists($pathToFile, "File at: '%s' doesn't exists!");
        Assert::readable($pathToFile, "File at: '%s' can't been readen!");

    }//end _checkFile()


    private function _parseFileWithRegexp(string $pathToFile)
    {
        $matchCount = preg_match_all($this->_matchRegexp, file_get_contents($pathToFile), $matches);

        return [
                $matchCount,
                $matches,
               ];

    }//end _parseFileWithRegexp()


    private function _beautifyMatchedResults(array $matches, int $matchCount)
    {
        $beautifiedMatches = [];

        for ($i = 0; $i < $matchCount; ++$i) {
            $beautifiedMatches[] = [
                                    'ip'      => $matches[1][$i],
                                    'country' => $matches[3][$i],
                                    'city'    => $matches[4][$i],
                                   ];
        }

        return $beautifiedMatches;

    }//end _beautifyMatchedResults()


}//end class
