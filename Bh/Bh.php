<?php

namespace Bh;

class Bh
{
    public function __construct()
    {
        $request = isset($_GET['page']) ? $_GET['page'] : null;
        $controller = new Lib\Controller();

        echo $controller->getPage($request);
    }
}
