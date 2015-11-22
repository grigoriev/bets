<?php

namespace bets\dao;

abstract class AbstractManager
{
    protected static $instances = array();

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    final public static function instance()
    {
        $calledClass = get_called_class();

        if (!isset($instances[$calledClass])) {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }
}