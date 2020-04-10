<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;
use CMEsteban\Entity\User;
use CMEsteban\Entity\Page;

class Mapper
{
    protected static $entityManager;
    private function __construct()
    {
        self::connect();
    }

    public static function init()
    {
        $path = __DIR__ . '/../Entity/*.php';
        $classes = [];

        foreach (glob($path) as $file) {
            $class = '\CMEsteban\Entity\\' . basename($file, '.php');
            $reflectionClass = new \ReflectionClass($class);

            if ($reflectionClass->isInstantiable()) {
                $classes[] = $class;
            }
        }

        $em = Mapper::getEntityManager();
        $conn = $em->getConnection();
        $conn->getConfiguration()->setSQLLogger(null);

        $sm = $conn->getSchemaManager();

        $metadata = [];
        foreach ($classes as $class) {
            array_push($metadata, $em->getClassMetadata($class));
        }
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $schemaTool->createSchema($metadata);

        $admin = new User('sebastian');
        $admin->setPass('yesitsreallyme');
        $admin->setEmail('sebastian@cmesteban.test');
        $admin->setLevel(5);

        self::save($admin);
        self::commit();
    }
    public function connect()
    {
        $settings = CMEsteban::$setup->getSettings();

        $conn = $settings['DbConn'];
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            [
                realpath(__DIR__ . '/../Entity'),
                'CMEsteban/Entity',
            ],
            $settings['DevMode']
        );
        $config->setAutoGenerateProxyClasses(\Doctrine\Common\Proxy\AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS);

        self::$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
    }
    public static function getEntityManager()
    {
        if (!self::$entityManager) {
            new Mapper();
        }

        return self::$entityManager;
    }

    public static function find($class, $id, $showHidden = false)
    {
        try {
            $result = self::getEntityManager()->find('CMEsteban\Entity\\' . $class, $id);
        } catch (\Doctrine\DBAL\Exception\TableNotFoundException $e) {
            self::init();
            $result = self::getEntityManager()->find('CMEsteban\Entity\\' . $class, $id);
        }

        return $result;
    }
    public static function findOneBy($class, array $conditions, $showHidden = false)
    {
        try {
            $result = self::getEntityManager()->getRepository('CMEsteban\Entity\\' . $class)->findOneBy($conditions);
        } catch (\Doctrine\DBAL\Exception\TableNotFoundException $e) {
            self::init();
            $result = self::getEntityManager()->getRepository('CMEsteban\Entity\\' . $class)->findOneBy($conditions);
        }

        return $result;
    }
    public static function findBy($class, array $conditions, $showHidden = false, array $order = [])
    {
        try {
            $result = self::getEntityManager()->getRepository('CMEsteban\Entity\\' . $class)->findBy($conditions, $order);
        } catch (\Doctrine\DBAL\Exception\TableNotFoundException $e) {
            self::init();
            $result = self::getEntityManager()->getRepository('CMEsteban\Entity\\' . $class)->findBy($conditions, $order);
        }

        return $result;
    }
    public static function findAll($class, $showHidden = false)
    {
        $entityClass = 'CMEsteban\Entity\\' . $class;

        if ($showHidden) {
            try {
                $result = self::getEntityManager()->getRepository($entityClass)->findAll();
            } catch (\Doctrine\DBAL\Exception\TableNotFoundException $e) {
                self::init();
                $result = self::getEntityManager()->getRepository($entityClass)->findAll();
            }
        } else {
            $result = self::findBy($class, ['deleted' => false], $showHidden);
        }

        return $result;
    }

    public static function save($entity)
    {
        self::getEntityManager()->persist($entity);
    }
    public static function commit()
    {
        self::getEntityManager()->flush();

        if (CMEsteban::$cache) {
            CMEsteban::$cache->autoclear();
        }
    }
}
