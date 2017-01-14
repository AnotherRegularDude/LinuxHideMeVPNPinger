<?php

use PHPUnit\Framework\TestCase;
use App\Services\SettingsParser;

class SettingsParserTest extends TestCase
{
    private $_parser;
    private $_settingsFilePath;

    public function setUp()
    {
        $this->_parser = new SettingsParser();
        $this->_parser->setDefaultConfigs('/remote ((?+1)+(\d+\.?))[0-9 ]+#[ ]?([[:alnum:] ]+),[ ]?([[:alnum:] ]+)/');
        $this->_settingsFilePath = __DIR__.'/../resources/test.ovpn';
        $this->_emptyFilePath = __DIR__.'/../resources/empty.file';
    }

    public function testWithDefaults()
    {
        $result = $this->_parser->parseFile($this->_settingsFilePath);

        $this->assertCount(2, $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testOnBadFile()
    {
        $this->_parser->parseFile('testnotexists.test');
    }

    public function testOnEmptyFile()
    {
        $result = $this->_parser->parseFile($this->_emptyFilePath);

        $this->assertEmpty($result);
    }
}
