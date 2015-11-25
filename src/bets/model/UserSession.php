<?php

namespace bets\model;

class UserSession extends AbstractObject
{
    public $uuid;
    public $username;
    public $ip_address;
    public $last_activity;

    public function __construct($array = null)
    {
        if ($array !== null) {
            $this->uuid = $array['uuid'];
            $this->username = $array['username'];
            $this->ip_address = $array['ip_address'];
            $this->last_activity = $array['last_activity'];
        }
    }

}