<?php

require_once 'vendor/autoload.php';

$request = isset($_GET['page']) ? $_GET['page'] : null;
$controller = new Bh\Lib\Controller();

echo $controller->getPage($request);
