<?php

namespace bets\model;

class User extends AbstractObject
{
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;

    public function __construct($array = null)
    {
        if ($array !== null) {
            $this->username = $array['username'];
            $this->password = $array['password'];
            $this->first_name = $array['first_name'];
            $this->last_name = $array['last_name'];
            $this->email = $array['email'];
        }
    }

}