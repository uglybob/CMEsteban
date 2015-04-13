<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

class SchemaGenerator
{
    // {{{ variables
    protected $pdo = null;
    protected $mappers = [];
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

    // {{{ addMapper
    public function addMapper($mapper)
    {
        if (
            !array_key_exists($mapper->getClass(), $this->mappers)
            && $mapper instanceof Mapper
        ) {
            $this->mappers[$mapper->getClass()] = $mapper;
        } else {
            throw new DataException('Duplicate or invalid mapper');
        }
    }
    // }}}
    // {{{ getMapper
    public function getMapper($mapperName)
    {
        if (!array_key_exists($mapperName, $this->mappers)) {
            throw new DataException($mapperName . ' doesn\'t exist');
        }

        return $this->mappers[$mapperName];
    }
    // }}}
    // {{{ schemaGenerate
    public function schemaGenerate()
    {
        $creates = [];
        $alters = [];

        foreach ($this->mappers as $mapper) {
            $create = 'CREATE TABLE IF NOT EXISTS `' . $mapper->getClass() . '` (' .
                '`id` INT AUTO_INCREMENT NOT NULL, ' .
                '`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, ';

            foreach ($mapper->getFields() as $field) {
                $create .= '`' . $field->getName() . '` ' . $this->translateType($field->getType()) . ' ' . $this->translateAttributes($field) . ',';

                if (
                    $field->getType() === 'Oto'
                    || $field->getType() === 'Mto'
                ) {
                    $this->getMapper($field->getClass());
                    $alter = 'ALTER TABLE `' . $mapper->getClass() . '` ADD FOREIGN KEY (`' . $field->getName() . '`) REFERENCES `' . $field->getClass() . '` (`id`);';
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
                $this->pdo->exec($query);
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
