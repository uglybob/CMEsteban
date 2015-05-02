<?php
require_once 'vendor/autoload.php';

$controller = new \Bh\Lib\Controller();
$entityManager = $controller->getMapper();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);

