<?php

namespace CMEsteban;

class CMEsteban
{
    public function __construct($controller = null)
    {
        if (!session_id()) {
            session_start();
        }

        $request = isset($_GET['page']) ? $_GET['page'] : 'home';
        $request = ltrim($request, '/');

        if (is_null($controller)) {
            $controller = new Lib\Controller();
        }

        $output = '';

        try {
            $output = $controller->getPageByRequest($request);
        } catch (Exception\NotFoundException $e) {
            try {
                $output = $controller->getPageByRequest('404');
            } catch (\Exception $se) {
                $output = $e->getMessage();
            }
        } catch (Exception\AccessException $e) {
            try {
                $output = $controller->getPageByRequest('403');
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
}
