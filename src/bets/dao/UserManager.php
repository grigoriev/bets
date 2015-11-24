<?php

namespace bets\dao;

use bets\db\DatabaseManager;
use bets\db\QueryParam;
use bets\exceptions;
use bets\exceptions\EntityNotFoundException;
use bets\model\User;
use PDO;


class UserManager extends AbstractManager
{
    function create($entity)
    {
        $parameters = array(
            new QueryParam(':username', $entity->username, PDO::PARAM_STR),
            new QueryParam(':password', $entity->password, PDO::PARAM_STR),
            new QueryParam(':first_name', $entity->first_name, PDO::PARAM_STR),
            new QueryParam(':last_name', $entity->last_name, PDO::PARAM_STR),
            new QueryParam(':email', $entity->email, PDO::PARAM_STR),
        );

        $entity->id = DatabaseManager::create('INSERT INTO users (username, password, first_name, last_name, email) VALUES (:username, :password, :first_name, :last_name, :email)', $parameters);
        return $entity;
    }

    function findById($id)
    {
        $parameters = array(
            new QueryParam(':id', $id, PDO::PARAM_INT),
        );

        $selected = DatabaseManager::selectAsObject('SELECT * FROM users WHERE id = :id', $parameters);
        return new User($selected);
    }

    public function findAll()
    {
        $selected = DatabaseManager::selectAsArray('SELECT * FROM users');

        $result = array();
        foreach ($selected as $row) {
            array_push($result, new User($row));
        }
        return $result;
    }

    function findByName($username)
    {
        $parameters = array(
            new QueryParam(':username', $username, PDO::PARAM_STR),
        );

        $selected = DatabaseManager::selectAsObject('SELECT * FROM users WHERE username = :username', $parameters);
        return new User($selected);
    }

    function authenticate($username, $password)
    {
        $parameters = array(
            new QueryParam(':username', $username, PDO::PARAM_STR),
            new QueryParam(':password', md5($password), PDO::PARAM_STR),
        );

        try {
            DatabaseManager::selectAsObject('SELECT * FROM users WHERE username = :username AND password = :password', $parameters);
        } catch (EntityNotFoundException $e) {
            return false;
        }
        return true;
    }

    function update($entity)
    {
        $parameters = array(
            new QueryParam(':id', $entity->id, PDO::PARAM_INT),
            new QueryParam(':username', $entity->username, PDO::PARAM_STR),
            new QueryParam(':password', $entity->password, PDO::PARAM_STR),
            new QueryParam(':first_name', $entity->first_name, PDO::PARAM_STR),
            new QueryParam(':last_name', $entity->last_name, PDO::PARAM_STR),
            new QueryParam(':email', $entity->email, PDO::PARAM_STR),
        );

        DatabaseManager::update('UPDATE users SET username = :username, password = :password, first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id', $parameters);
        return $entity;
    }

    function delete($entity)
    {
        $parameters = array(
            new QueryParam(':id', $entity->id, PDO::PARAM_INT),
        );

        DatabaseManager::delete('delete from users WHERE id = :id', $parameters);
        $entity = null;
    }
}