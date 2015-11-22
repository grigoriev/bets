<?php

namespace bets\dao;

class UserManager extends AbstractManager
{
    function create()
    {
    }

    function findById($id)
    {
        $user = new \bets\model\User();
        $user->id = $id;
        $user->username = 'grigoriev';
        $user->password = md5('123');
        $user->first_name = 'Sergey';
        $user->last_name = 'Grigoriev';
        $user->email = 's.grigoriev@gmail.com';
        return $user;
    }

    function findByName($username)
    {
        $user = new \bets\model\User();
        $user->id = 1;
        $user->username = $username;
        $user->password = md5('123');
        $user->first_name = 'Sergey';
        $user->last_name = 'Grigoriev';
        $user->email = 's.grigoriev@gmail.com';
        return $user;
    }

    function authenticate($username, $password)
    {
        $user = new \bets\model\User();
        $user->id = 1;
        $user->username = $username;
        $user->password = md5($password);
        $user->first_name = 'Sergey';
        $user->last_name = 'Grigoriev';
        $user->email = 's.grigoriev@gmail.com';
        return $user;
    }

    function update()
    {
    }

    function delete()
    {
    }
}