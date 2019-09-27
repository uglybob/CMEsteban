<?php

namespace CMEsteban\Lib;

class Mapper
{
    // {{{ variables
    protected static $entityManager;
    // }}}
    // {{{ constructor
    private function __construct()
    {
        self::connect();
    }
    // }}}

    // {{{ init
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
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        var_dump($metadata);
    }
    // }}}
    // {{{ connect
    public function connect()
    {
        $settings = Setup::getSettings();

        $conn = $settings['DbConn'];
        $config = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration(
            [
                __DIR__ . '/../Mapper',
                'CMEsteban/Mapper',
            ],
            $settings['DevMode']
        );

        self::$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
    }
    // }}}
    // {{{ getEntityManager
    public static function getEntityManager()
    {
        if (!self::$entityManager) {
            new Mapper();
        }

        return self::$entityManager;
    }
    // }}}

    // {{{ find
    public static function find($class, $id, $showHidden = false)
    {
        return self::getEntityManager()->find('CMEsteban\Entity\\' . $class, $id);
    }
    // }}}
    // {{{ findOneBy
    public static function findOneBy($class, array $conditions, $showHidden = false)
    {
        return self::getEntityManager()->getRepository('CMEsteban\Entity\\' . $class)->findOneBy($conditions);
    }
    // }}}
    // {{{ findBy
    public static function findBy($class, array $conditions, $showHidden = false, array $order = [])
    {
        return self::getEntityManager()->getRepository('CMEsteban\Entity\\' . $class)->findBy($conditions, $order);
    }
    // }}}
    // {{{ findAll
    public static function findAll($class, $showHidden = false)
    {
        $entityClass = 'CMEsteban\Entity\\' . $class;

        if ($showHidden) {
            return self::getEntityManager()->getRepository($entityClass)->findAll();
        } else {
            return self::getEntityManager()->getRepository($entityClass)->findBy(['deleted' => 'false']);
        }
    }
    // }}}

    // {{{ save
    public static function save($object)
    {
        return self::getEntityManager()->persist($object);
    }
    // }}}
    // {{{ commit
    public static function commit()
    {
        self::getEntityManager()->flush();
    }
    // }}}
}
