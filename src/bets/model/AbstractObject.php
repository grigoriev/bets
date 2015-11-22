<?php

namespace bets\model;

abstract class AbstractObject
{
    public function json()
    {
        return json_encode((array)$this);
    }
}