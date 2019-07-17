<?php

namespace CMEsteban\Lib;

class Log
{
    public static function log($message)
    {
        $logEntry = new \CMEsteban\Entity\LogEntry($message);
        Mapper::save($logEntry);
        Mapper::commit();
    }
}
