<?php

namespace Bh;

class Bh
{
    public function __construct($controller = null)
    {
        $request = isset($_GET['page']) ? $_GET['page'] : null;

        if (is_null($controller)) {
            $controller = new Lib\Controller();
        }

        echo $controller->getPage($request);
    }
}
