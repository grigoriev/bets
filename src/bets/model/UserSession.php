<?php

namespace bets\model;

class UserSession extends AbstractObject
{
    public $id;
    public $username;
    public $ip_address;
    public $last_activity;

    public function __construct($array = null)
    {
        if ($array !== null) {
            $this->id = $array['id'];
            $this->username = $array['username'];
            $this->ip_address = $array['ip_address'];
            $this->last_activity = $array['last_activity'];
        }
    }

}