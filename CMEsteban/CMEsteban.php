<?php

namespace CMEsteban;

class CMEsteban
{
    protected static $instance = null;
    public static $controller = null;
    public static $page = null;
    public static $template = null;

    // {{{ constructor
    private function __construct()
    {
        if (!session_id()) {
            @session_start();
        }

        $request = isset($_GET['page']) ? $_GET['page'] : 'home';
        $request = ltrim($request, '/');

        self::$controller = \CMEsteban\Lib\Setup::getController();

        $output = '';

        try {
            $output = self::$controller->getPageByRequest($request);
        } catch (Exception\NotFoundException $e) {
            try {
                $output = self::$controller->getPageByRequest('404');
            } catch (\Exception $se) {
                $output = $e->getMessage();
            }
        } catch (Exception\AccessException $e) {
            try {
                $output = self::$controller->getPageByRequest('403');
            } catch (\Exception $se) {
                $output = $e->getMessage();
            }
        } catch (\Exception $e) {
            $settings = \CMEsteban\Lib\Setup::getSettings();

            if ($settings['DevMode'] === true) {
               $output = $e;
            }
        }

        echo($output);
    }
    // }}}
    // {{{ init
    public function init()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
    }
    // }}}

    // {{{ setPage
    public function setPage($page)
    {
        self::$page = $page;
    }
    // }}}
    // {{{ setTemplate
    public function setTemplate($template)
    {
        self::$template = $template;
    }
    // }}}
}
