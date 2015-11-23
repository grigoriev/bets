<?php

namespace bets\dao;

use bets\model\User;

class UserManager extends AbstractManager
{
    function create()
    {
    }

    function findById($id)
    {
        $user = new User();
        $user->id = $id;
        $user->username = 'grigoriev';
        $user->password = md5('123');
        $user->first_name = 'Sergey';
        $user->last_name = 'Grigoriev';
        $user->email = 's.grigoriev@gmail.com';
        return $user;
    }

    public function findAll()
    {
    }

    function findByName($username)
    {
        $user = new User();
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
        $user = new User();
        $user->id = 1;
        $user->username = $username;
        $user->password = md5($password);
        $user->first_name = 'Sergey';
        $user->last_name = 'Grigoriev';
        $user->email = 's.grigoriev@gmail.com';
        return $user;
    }

    function update($entity)
    {
    }

    function delete($entity)
    {
    }
}