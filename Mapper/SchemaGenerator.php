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
    public function __construct($pdo)
    {
        if (!($pdo instanceof \PDO)) {
            throw new DataException('PDO required');
        }
        $this->pdo = $pdo;
    }
    // }}}

    // {{{ addDao
    public function addDao($dao)
    {
        if ($dao instanceof Dao) {
            $this->dao[$dao->getClass()] = $dao;
        } else {
            throw new DataException('Duplicate or invalid mapper');
        }
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

        foreach ($this->dao as $dao) {
            $create = 'CREATE TABLE IF NOT EXISTS `' . $dao->getClass() . '` (' .
                '`id` INT AUTO_INCREMENT NOT NULL, ' .
                '`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, ';

            foreach ($dao->getFields() as $field) {
                $create .= '`' . $field->getName() . '` ' . $this->translateType($field->getType()) . ' ' . $this->translateAttributes($field) . ',';

                if (
                    $field->getType() === 'Oto'
                    || $field->getType() === 'Mto'
                ) {
                    $this->getDao($field->getClass());
                    $alter = 'ALTER TABLE `' . $dao->getClass() . '` ADD FOREIGN KEY (`' . $field->getName() . '`) REFERENCES `' . $field->getClass() . '` (`id`);';
                }
            }

            $create .= 'PRIMARY KEY(`id`)' .
                ') CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;';

            $creates[] = $create;
            $alters[] = $alter;
        }

        $this->sql = array_merge($creates, $alters);
    }
    // }}}
    // {{{ schemaApply
    public function schemaApply()
    {
        foreach ($this->sql as $query) {
            var_dump($query);
            try {
                //$this->pdo->exec($query);
            } catch(\PDOException $e) {
                echo $e->getMessage();
            }
        }
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
            'Oto'       => 'INT',
            'Mto'       => 'INT',
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
