<?php

namespace bets\utils;

class UUID
{
    public static function generate()
    {
        mt_srand((double)microtime() * 10000);
        $char = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($char, 0, 8) . $hyphen
            . substr($char, 8, 4) . $hyphen
            . substr($char, 12, 4) . $hyphen
            . substr($char, 16, 4) . $hyphen
            . substr($char, 20, 12);
        return $uuid;
    }
}