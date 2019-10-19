<?php

namespace CMEsteban;

class CMEsteban
{
    protected static $instance = null;
    public static $setup = null;
    public static $controller = null;
    public static $page = null;
    public static $template = null;

    // {{{ constructor
    private function __construct($setup)
    {
        if (!session_id()) {
            @session_start();
        }

        $request = isset($_GET['page']) ? $_GET['page'] : 'home';
        $request = ltrim($request, '/');

        self::$setup = $setup;
        self::$controller = self::$setup->getController();

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
            $settings = self::$setup->getSettings();

            if ($settings['DevMode'] === true) {
               $output = $e;
            }
        }

        echo($output);
    }
    // }}}
    // {{{ start
    public function start($setup)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($setup);
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
