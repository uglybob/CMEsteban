<?php

namespace CMEsteban\Lib;

use CMEsteban\CMEsteban;

class CacheOpcode extends CacheFile
{
    public function write($index, $data)
    {
        $file = $this->getDir() . "/$key";
        $val = var_export($data, true);
        $val = str_replace('stdClass::__set_state', '(object)', $val);
        $tmp = "$file." . uniqid('', true) . '.tmp';

        $result = file_put_contents($tmp, '<?php $val = ' . $val . ';', LOCK_EX);
        $result = $result && rename($tmp, $file);

        return $result;
    }
    public function readData($index)
        @include "/tmp/$index";

        return isset($val) ? $val : false;
    }
}
