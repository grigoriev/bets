<?php

namespace bets\dao;

use bets\db\DatabaseManager;
use bets\db\QueryParam;
use bets\exceptions;
use bets\exceptions\EntityNotFoundException;
use bets\model\Error;
use bets\model\User;
use Exception;
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

        try {
            DatabaseManager::create('INSERT INTO users (username, password, first_name, last_name, email) VALUES (:username, :password, :first_name, :last_name, :email)', $parameters);
            return $entity;
        } catch (Exception $e) {
            return new Error($e);
        }
    }

    function findById($username)
    {
        $parameters = array(
            new QueryParam(':username', $username, PDO::PARAM_STR),
        );

        try {
            $selected = DatabaseManager::selectAsObject('SELECT * FROM users WHERE username = :username', $parameters);
            return new User($selected);
        } catch (EntityNotFoundException $e) {
            return new User();
        } catch (Exception $e) {
            return new Error($e);
        }
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

    function authenticate($username, $password)
    {
        $parameters = array(
            new QueryParam(':username', $username, PDO::PARAM_STR),
            new QueryParam(':password', md5($password), PDO::PARAM_STR),
        );

        try {
            DatabaseManager::selectAsObject('SELECT * FROM users WHERE username = :username AND password = :password', $parameters);
            return true;
        } catch (EntityNotFoundException $e) {
            return false;
        }
    }

    function update($entity)
    {
        $parameters = array(
            new QueryParam(':username', $entity->username, PDO::PARAM_STR),
            new QueryParam(':password', $entity->password, PDO::PARAM_STR),
            new QueryParam(':first_name', $entity->first_name, PDO::PARAM_STR),
            new QueryParam(':last_name', $entity->last_name, PDO::PARAM_STR),
            new QueryParam(':email', $entity->email, PDO::PARAM_STR),
        );

        DatabaseManager::update('UPDATE users SET password = :password, first_name = :first_name, last_name = :last_name, email = :email WHERE username = :username', $parameters);
        return $entity;
    }

    function delete($entity)
    {
        $parameters = array(
            new QueryParam(':username', $entity->username, PDO::PARAM_INT),
        );

        DatabaseManager::delete('DELETE FROM users WHERE username = :username', $parameters);
        $entity = null;
    }
}