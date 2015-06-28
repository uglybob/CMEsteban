<?php

class Bh
{
    public function __construct($contentNamespace)
    {
        $request = isset($_GET['page']) ? $_GET['page'] : null;
        $controller = new Bh\Lib\Controller();
        $controller->registerNamespace($contentNamespace);

        echo $controller->getPage($request);
    }
}
