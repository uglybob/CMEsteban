<?php

namespace CMEsteban\Lib;

class CacheExternal extends CacheFile
{
    public function __construct($path, $external = null)
    {
        $this->external = $external;

        parent::__construct($path);
    }


    public function getLink($index, $includeExpired = false)
    {
        $result = false;
        $name = $this->isGettable($index, $includeExpired);

        if ($name) {
            $result = $this->external . "/$index";
        }

        return $result;
    }
}
