<?php

namespace Bh;

class Bh
{
    public function __construct($controller = null)
    {
        if (!session_id()) {
            session_start();
        }

        $request = isset($_GET['page']) ? $_GET['page'] : 'home';

        if (is_null($controller)) {
            $controller = new Lib\Controller();
        }

        $output = '';

        try {
            $output = $controller->getPageByRequest($request)->render();
        } catch (Exception\NotFoundException $e) {
            try {
                $output = $controller->getPageByRequest('404')->render();
            } catch (\Exception $se) {
                $output = $e->getMessage();
            }
        } catch (Exception\AccessException $e) {
            try {
                $output = $controller->getPageByRequest('403')->render();
            } catch (\Exception $se) {
                $output = $e->getMessage();
            }
        } catch (\Exception $e) {
            $settings = \Bh\Lib\Setup::getSettings();

            if ($settings['DevMode'] === true) {
               $output = $e;
            }
        }

        echo($output);
    }
}
