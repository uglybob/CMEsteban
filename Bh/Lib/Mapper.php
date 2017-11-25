<?php

namespace Bh\Lib;

class Mapper
{
    // {{{ variables
    protected static $entityManager;
    // }}}
    // {{{ constructor
    private function __construct()
    {
        $settings = Setup::getSettings();

        $config = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration(
            [
                __DIR__ . '/../Mapper',
                'Bh/Mapper',
            ],
            $settings['DevMode']
        );

        $conn = array(
            'driver'   => 'pdo_mysql',
            'user'     => $settings['DbUser'],
            'password' => $settings['DbPass'],
            'dbname'   => $settings['DbName'],
            'host'     => $settings['DbHost'],
        );
        self::$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
    }
    // }}}

    // {{{ find
    public static function find($class, $id, $showHidden = false)
    {
        return self::getEntityManager()->find('Bh\Entity\\' . $class, $id);
    }
    // }}}
    // {{{ findOneBy
    public static function findOneBy($class, array $conditions, $showHidden = false)
    {
        return self::getEntityManager()->getRepository('Bh\Entity\\' . $class)->findOneBy($conditions);
    }
    // }}}
    // {{{ findBy
    public static function findBy($class, array $conditions, $showHidden = false, array $order = [])
    {
        return self::getEntityManager()->getRepository('Bh\Entity\\' . $class)->findBy($conditions, $order);
    }
    // }}}
    // {{{ findAll
    public static function findAll($class, $showHidden = false)
    {
        $entityClass = 'Bh\Entity\\' . $class;

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

    // {{{ getEntityManager
    public static function getEntityManager()
    {
        if (!self::$entityManager) {
            new Mapper();
        }

        return self::$entityManager;
    }
    // }}}
}
