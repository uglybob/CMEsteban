<?php

namespace CMEsteban\Lib;

class Setup
{
    public static function getSettings()
    {
        return [
            'Salt' => 'testSalt',
            'DevMode' => true,
        ];
    }
}

class Mapper
{
    // {{{ variables
    protected static $data;
    // }}}

    // {{{ reset
    public function reset()
    {
        self::$data = [];
    }
    // }}}
    // {{{ insertData
    public function insertData($data)
    {
        $class = get_class($data);

        self::$data[$class][] = $data;
        $id = count(self::$data[$class]);

        $reflection = new \ReflectionClass('CMEsteban\Entity\Entity');
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($data, $id);
    }
    // }}}
    // {{{ match
    public static function match($conditions, $object)
    {
        foreach ($conditions as $attribute => $value) {
            $getter = 'get' . $attribute;

            if ($object->$getter() != $value) {
                return false;
            }
        }

        return true;
    }
    // }}}

    // {{{ find
    public static function find($class, $id, $showHidden = false)
    {
        return self::findOneBy($class, ['id' => $id], $showHidden);
    }
    // }}}
    // {{{ findOneBy
    public static function findOneBy($class, array $conditions, $showHidden = false)
    {
        $class = 'CMEsteban\\Entity\\' . $class;

        if (array_key_exists($class, self::$data)) {
            foreach (self::$data[$class] as $id => $object) {
                if (self::match($conditions, $object)) {
                    return $object;
                }
            }
        }

        return null;
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
}
