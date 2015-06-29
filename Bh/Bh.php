<?php

namespace Bh;

class Bh
{
    public function __construct($contentNamespace)
    {
        $request = isset($_GET['page']) ? $_GET['page'] : null;
        $controller = new Lib\Controller($contentNamespace);

        echo $controller->getPage($request);
    }
}
