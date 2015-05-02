<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once 'vendor/autoload.php';

$isDevMode = true;
$config = Setup::createXMLMetadataConfiguration(array(__DIR__.'/Content/Mapper'), $isDevMode);

// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'bh3_user',
    'password' => 'siD87ddSD821',
    'dbname'   => 'bh3_db',
);

$entityManager = EntityManager::create($conn, $config);
