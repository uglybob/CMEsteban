<?php

namespace CMEsteban\Entity;

/**
 * @MappedSuperclass
 **/
abstract class Named extends Entity
{
    /**
     * @Column(type="string", unique=true)
     **/
    protected $name;

    public function __construct($name)
    {
        parent::__construct();

        $this->name = $name;
    }
    public function __toString()
    {
        return $this->name;
    }

    public static function getHeadings()
    {
        return ['Name'];
    }
    public function getRow()
    {
        return [\CMEsteban\Page\Module\Text::shortenString($this->getName(), 30)];
    }
}
