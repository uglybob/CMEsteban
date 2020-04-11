<?php

namespace CMEsteban;

use CMEsteban\Lib\CacheExternal;

class CMEsteban
{
    public static $instance = null;
    public static $setup = null;
    public static $cache = null;
    public static $frontCache = null;
    public static $controller = null;
    public static $page = null;
    public static $template = null;

    private function __construct($setup)
    {
        self::$setup = $setup;
        self::$cache = self::$setup->instantiateCache();
        self::$frontCache = new CacheExternal($setup->getSettings('Path') . '/CMEsteban/Cache', '/CMEsteban/Cache');
        self::$controller = self::$setup->instantiateController();
    }
    public static function startQuiet($setup)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($setup);
        }
    }
    public static function start($setup)
    {
        self::startQuiet($setup);

        if (!session_id()) {
            @session_start();
        }

        $request = isset($_GET['page']) ? $_GET['page'] : 'home';
        $request = ltrim($request, '/');

        $output = '';

        try {
            $output = self::$controller->renderPage($request);
        } catch (Exception\NotFoundException $e) {
            try {
                $output = self::$controller->renderPage('404');
            } catch (\Exception $se) {
                $output = $e->getMessage();
            }
        } catch (Exception\AccessException $e) {
            try {
                $output = self::$controller->renderPage('403');
            } catch (\Exception $se) {
                $output = $e->getMessage();
            }
        } catch (\Exception $e) {
            $settings = self::$setup->getSettings();

            if ($settings['DevMode'] === true) {
               $output = $e;
            }
        }

        echo($output);
    }

    public static function setPage($page)
    {
        self::$page = $page;
    }
    public static function setTemplate($template)
    {
        self::$template = $template;
    }
    public static function autoClear()
    {
        if (self::$cache) {
            self::$cache->autoClear();
        }

        if (self::$frontCache) {
            self::$frontCache->autoClear();
        }
    }
}
