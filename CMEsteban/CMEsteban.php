<?php

namespace CMEsteban;

use CMEsteban\Lib\CacheFile;

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
        self::$frontCache = new CacheFile($setup->getSettings('Path') . '/CMEsteban/Cache', '/CMEsteban/Cache');
        self::$controller = self::$setup->getController();
    }
    public function startQuiet($setup)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($setup);
        }
    }
    public function start($setup)
    {
        self::startQuiet($setup);

        if (!session_id()) {
            @session_start();
        }

        $request = isset($_GET['page']) ? $_GET['page'] : 'home';
        $request = ltrim($request, '/');

        $output = '';

        try {
            $output = self::$controller->getPage($request);
        } catch (Exception\NotFoundException $e) {
            try {
                $output = self::$controller->getPage('404');
            } catch (\Exception $se) {
                $output = $e->getMessage();
            }
        } catch (Exception\AccessException $e) {
            try {
                $output = self::$controller->getPage('403');
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

    public function setPage($page)
    {
        self::$page = $page;
    }
    public function setTemplate($template)
    {
        self::$template = $template;
    }
}
