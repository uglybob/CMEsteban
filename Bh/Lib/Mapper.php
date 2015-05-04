<?php

namespace Bh\Lib;

class Mapper
{
    // {{{ variables
    protected $entityManager;
    // }}}
    // {{{ constructor
    public function __construct()
    {
        $isDevMode = true;
        $config = \Doctrine\ORM\Tools\Setup::createXMLMetadataConfiguration(
            [
                __DIR__.'/../Content/Mapper',
                __DIR__.'/../Mapper',
            ],
            $isDevMode
        );

        $settings = \Bh\Lib\Setup::getSettings();
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
        return $this->entityManager->find('Bh\Content\Entity\\' . $class, $id);
    }
    // }}}
    // {{{ findAll
    public function findAll($class, $showHidden = false)
    {
        if ($showHidden) {
            return $this->entityManager->getRepository('Bh\Content\Entity\\' . $class)->findAll();
        } else {
            return $this->entityManager->getRepository('Bh\Content\Entity\\' . $class)->findBy(['deleted' => 'false']);
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
