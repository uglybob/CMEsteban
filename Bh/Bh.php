<?php

namespace Bh;

class Bh
{
    public function __construct($controller = null)
    {
        if (!session_id()) {
            session_start();
        }

        $request = isset($_GET['page']) ? $_GET['page'] : null;

        if (is_null($controller)) {
            $controller = new Lib\Controller();
        }

        $page = $controller->getPageByRequest($request);
        echo $page->render();
    }
}
