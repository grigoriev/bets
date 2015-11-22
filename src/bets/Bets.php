<?php

namespace bets;

class Bets
{
    public static function registerAutoloader()
    {
        spl_autoload_register(__NAMESPACE__ . '\\Bets::loader');
    }

    public static function loader($className)
    {
        $file = dirname(dirname(__FILE__)) . '/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}