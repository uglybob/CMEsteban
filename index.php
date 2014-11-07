<?php
require_once __DIR__ . '/vendor/autoload.php';

$request    = isset($_GET['page']) ? $_GET['page'] : null;
$controller = new BH\Lib\Controller($request);

try {
    echo $controller->getPage();
} catch (BH\Exceptions\InvalidClassException $e) {
    echo $controller->getPage('Home');
}
