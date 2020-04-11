<?php

namespace CMEsteban\Test;

class CMEstebanTest extends CMEstebanTestCase
{
    public function testCMEstebanDefault()
    {
        $expected =
            preg_quote('<!DOCTYPE html><html><head><title></title><meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" /><meta name="date.rendered" content="') .
            ".*" .
            preg_quote('" /></head><body><div id="content"><div id="main"></div></div></body></html>');

        $this->expectOutputRegex("|$expected|");

        $setup = new \CMEsteban\Lib\Setup();
        \CMEsteban\CMEsteban::start($setup);
    }
    public function testCMEstebanCustomController()
    {
        $this->expectOutputString('This is a custom controller page.');

        $setup = new \CMEsteban\Lib\Setup();
        $setup->testController = new \CMEsteban\Lib\CustomController();

        \CMEsteban\CMEsteban::start($setup);
    }
}
