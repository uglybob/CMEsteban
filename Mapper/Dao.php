<?php

namespace Bh\Mapper;

use \Bh\Exceptions\DataException;

class Dao
{
    public function __call($name, $arguments)
    {
        $xet = substr($name, 0, 3);
        $attribute = lcfirst(substr($name, 3, strlen($name) - 3));

        

        if ($xet === 'get') {
            return $this->$attribute};
        } elseif ($xet === 'set') {
            $this->$attribute = $arguments[0];
        }
    }
}
