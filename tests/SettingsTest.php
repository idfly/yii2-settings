<?php

require dirname(__FILE__) . '/../Settings.php';
use idfly\settings\Settings;

class SettingsTest extends PHPUnit_Framework_TestCase
{
    // ...

	public function tearDown()
	{
		Settings::$getSettings = null;
	}

	private function _setConfig($config) {
		Settings::$getSettings = function() use($config) {
			return $config;
		};
	}

    public function testGetReturnsValue()
    {
        $this->_setConfig(['a' => 'VALUE']);
        $actual = Settings::get('a');
        $this->assertEquals('VALUE', $actual);
    }

    public function testGetReturnsDefault()
    {
        $this->_setConfig([]);
        $actual = Settings::get('NON_EXISTED_KEY', 'DEFAULT');
        $this->assertEquals('DEFAULT', $actual);
    }

    public function testGetReturnsValueByArray()
    {
        $this->_setConfig(['a' => ['b' => 'VALUE']]);
        $actual = Settings::get(['a', 'b']);
        $this->assertEquals('VALUE', $actual);
    }

    public function testGetReturnsDefaultByArray()
    {
        $this->_setConfig(['a' => ['b' => 'VALUE']]);
        $actual = Settings::get(['a', 'NON_EXISTED_KEY'], 'DEFAULT');
        $this->assertEquals('DEFAULT', $actual);
    }

    // ...
}

