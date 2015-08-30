<?php

namespace Bh\Lib;

class Log
{
    public static function log($message)
    {
        $logEntry = new \Bh\Entity\LogEntry($message);
        Mapper::save($logEntry);
        Mapper::commit();
    }
}
