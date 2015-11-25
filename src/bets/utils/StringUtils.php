<?php

namespace bets\utils;

class StringUtils
{
    public static function startsWith($haystack, $needle)
    {
        return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
}