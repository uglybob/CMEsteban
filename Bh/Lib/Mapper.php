<?php

namespace Bh\Lib;

class Mapper
{
    // {{{ variables
    protected $entityManager;
    protected $controller;
    // }}}
    // {{{ constructor
    public function __construct($controller)
    {
        $this->controller = $controller;

        // @todo handle
        $isDevMode = true;
        $settings = $this->controller->getSettings();

        $config = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration(
            [
                __DIR__.'/../Mapper',
                $settings['MapperPath'],
            ],
            $isDevMode
        );

        $conn = array(
            'driver'   => 'pdo_mysql',
            'user'     => $settings['DbUser'],
            'password' => $settings['DbPass'],
            'dbname'   => $settings['DbName'],
        );
        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);
    }
    // }}}

    // {{{ find
    public function find($class, $id, $showHidden = false)
    {
        $entityClass = $this->controller->getClass('Entity', $class);

        return $this->entityManager->find($entityClass, $id);
    }
    // }}}
    // {{{ findAll
    public function findAll($class, $showHidden = false)
    {
        $entityClass = $this->controller->getClass('Entity', $class);

        if ($showHidden) {
            return $this->entityManager->getRepository($entityClass)->findAll();
        } else {
            return $this->entityManager->getRepository($entityClass)->findBy(['deleted' => 'false']);
        }
    }
    // }}}

    // {{{ save
    public function save($object)
    {
        $this->entityManager->persist($object);
    }
    // }}}
    // {{{ commit
    public function commit()
    {
        $this->entityManager->flush();
    }
    // }}}

    // {{{ getEntityManager
    public function getEntityManager()
    {
        return $this->entityManager;
    }
    // }}}
}
