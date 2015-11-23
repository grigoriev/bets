<?php

namespace bets\dao;

abstract class AbstractManager implements Manager
{
    protected static $instances = array();

    final private function __construct()
    {
    }

    final private function __clone()
    {
    }

    /**
     * @return UserManager|
     */
    final public static function instance()
    {
        $calledClass = get_called_class();

        if (!isset($instances[$calledClass])) {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }
}