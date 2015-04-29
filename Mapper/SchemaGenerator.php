<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

class SchemaGenerator
{
    // {{{ variables
    protected $pdo = null;
    protected $daos = [];
    // }}}
    // {{{ constructor
    public function __construct()
    {
        $this->pdo = Mapper::getPdo();
    }
    // }}}

    // {{{ addDao
    public function addDao($dao)
    {
        $this->daos[$dao] = \Bh\Lib\Controller::getClass('Mapper', $dao);
    }
    // }}}
    // {{{ getDao
    public function getDao($daoName)
    {
        if (!array_key_exists($daoName, $this->daos)) {
            throw new DataException($daoName . ' doesn\'t exist');
        }

        return $this->daos[$daoName];
    }
    // }}}
    // {{{ schemaGenerate
    public function schemaGenerate()
    {
        $creates = [];
        $alters = [];

        foreach ($this->daos as $dao => $daoClass) {
            $create = 'CREATE TABLE IF NOT EXISTS `' . $dao . '` (' .
                '`id` INT UNSIGNED AUTO_INCREMENT NOT NULL, ' .
                '`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, ';

            foreach (\Bh\Mapper\Dao::getFields($daoClass) as $field) {
                $create .= '`' . $field->getName() . '` ' . $this->translateType($field->getType()) . ' ' . $this->translateAttributes($field) . ',';

                if (
                    $field->getType() === 'Oto'
                    || $field->getType() === 'Mto'
                ) {
                    $this->getDao($field->getClass());
                    $alters[] = 'ALTER TABLE `' . $dao . '` ADD FOREIGN KEY (`' . $field->getName() . '`) REFERENCES `' . $field->getClass() . '` (`id`);';
                }
            }

            $create .= 'PRIMARY KEY(`id`)' .
                ') CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;';

            $creates[] = $create;
        }

        $this->sql = array_merge($creates, $alters);
    }
    // }}}
    // {{{ schemaRun
    public function schemaRun()
    {
        foreach ($this->sql as $query) {
            try {
                $this->pdo->exec($query);
            } catch(\PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    // }}}
    // {{{ schemaApply
    public function schemaApply($entities)
    {
        foreach ($entities as $entity) {
            $this->addDao($entity);
        }

        $this->schemaGenerate();
        $this->schemaRun();
    }
    // }}}

    // {{{ translateType
    protected function translateType($type)
    {
        $matrix = [
            'Boolean'   => 'BOOLEAN',
            'Email'     => 'TEXT',
            'Number'    => 'INT',
            'Password'  => 'TEXT',
            'Tel'       => 'TEXT',
            'Text'      => 'TEXT',
            'TextArea'  => 'TEXT',
            'File'      => 'TEXT',
            'Url'       => 'TEXT',
            'Date'      => 'TIMESTAMP',
            'Oto'       => 'INT UNSIGNED',
            'Mto'       => 'INT UNSIGNED',
            'Otp'       => 'INT UNSIGNED',
        ];

        if (!array_key_exists($type, $matrix)) {
            throw new DataException('Type "' . $type . '" doesn\'t exist');
        }

        return $matrix[$type];
    }
    // }}}
    // {{{ translateAttributes
    protected function translateAttributes($field)
    {
        $attributes = ($this->isNullAllowed($field)) ? 'DEFAULT NULL' : 'NOT NULL';

        return $attributes;
    }
    // }}}

    // {{{ isNullAllowed
    protected function isNullAllowed($field)
    {
        $noNull = ['Oto', 'Mto'];

        return !in_array($field->getType(), $noNull)
            && !(
                array_key_exists('required', $field->getParams())
                && $field->getParams()['required'] === true
            );
    }
    // }}}
}
