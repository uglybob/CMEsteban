<?php

namespace CMEsteban\Lib;

abstract class Component
{
    protected function getSetup()
    {
        return CMEsteban::$setup;
    }
    protected function getController()
    {
        return CMEsteban::$controller;
    }
    protected function getPage()
    {
        return CMEsteban::$page;
    }
    protected function getTemplate()
    {
        return CMEsteban::$template;
    }
    protected function getCache()
    {
        return CMEsteban::$cache;
    }
    protected function getFrontCache()
    {
        return CMEsteban::$frontCache;
    }
}
