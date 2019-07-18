<?php

namespace CMEsteban\Lib;

class Setup
{
    public static function getSettings()
    {
        return [
            'Salt' => 'testSalt',
            'DevMode' => true,
            'DbHost' => 'localhost',
            'DbName' => $GLOBALS['DB_NAME'],
            'DbUser' => $GLOBALS['DB_USER'],
            'DbPass' => $GLOBALS['DB_PASS'],
        ];
    }
}

class Mapper
{
    // {{{ variables
    protected static $entityManager;
    // }}}
    // {{{ constructor
    private function __construct()
    {
        $settings = Setup::getSettings();
    }
    // }}}
    // {{{ find
    public static function find($class, $id, $showHidden = false)
    {
        //return self::getEntityManager()->find('CMEsteban\Entity\\' . $class, $id);
    }
    // }}}
    // {{{ findOneBy
    public static function findOneBy($class, array $conditions, $showHidden = false)
    {
        //return self::getEntityManager()->getRepository('CMEsteban\Entity\\' . $class)->findOneBy($conditions);
    }
    // }}}
    // {{{ findBy
    public static function findBy($class, array $conditions, $showHidden = false, array $order = [])
    {
        //return self::getEntityManager()->getRepository('CMEsteban\Entity\\' . $class)->findBy($conditions, $order);
    }
    // }}}
    // {{{ findAll
    public static function findAll($class, $showHidden = false)
    {
        //$entityClass = 'CMEsteban\Entity\\' . $class;
    }
    // }}}

    // {{{ save
    public static function save($object)
    {
        //return self::getEntityManager()->persist($object);
    }
    // }}}
    // {{{ commit
    public static function commit()
    {
        //self::getEntityManager()->flush();
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
