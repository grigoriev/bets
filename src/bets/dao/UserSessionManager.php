<?php

namespace bets\dao;

use bets\db\DatabaseManager;
use bets\db\QueryParam;
use bets\exceptions;
use bets\exceptions\EntityNotFoundException;
use bets\model\User;
use bets\model\UserSession;
use PDO;


class UserSessionManager extends AbstractManager
{
    function guid()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
            return mb_strtolower($uuid);
        }
    }

    function create($entity)
    {
        $parameters = array(
            new QueryParam(':id', $this->guid(), PDO::PARAM_STR),
            new QueryParam(':username', $entity->username, PDO::PARAM_STR),
            new QueryParam(':ip_address', $entity->ip_address, PDO::PARAM_STR),
        );

        DatabaseManager::create('INSERT INTO user_sessions (id, username, ip_address, last_activity) VALUES (:id, :username, :ip_address, now())', $parameters);
        return $entity;
    }

    function findById($id)
    {
        $parameters = array(
            new QueryParam(':id', $id, PDO::PARAM_STR),
        );

        $selected = DatabaseManager::selectAsObject('SELECT * FROM user_sessions WHERE id = :id', $parameters);
        return new UserSession($selected);
    }

    public function findAll()
    {
        $selected = DatabaseManager::selectAsArray('SELECT * FROM user_sessions');

        $result = array();
        foreach ($selected as $row) {
            array_push($result, new UserSession($row));
        }
        return $result;
    }

    function findByName($username)
    {
        $parameters = array(
            new QueryParam(':username', $username, PDO::PARAM_STR),
        );

        $selected = DatabaseManager::selectAsObject('SELECT * FROM user_sessions WHERE username = :username', $parameters);
        return new UserSession($selected);
    }

    function update($entity)
    {
        $parameters = array(
            new QueryParam(':id', $entity->id, PDO::PARAM_STR),
            new QueryParam(':username', $entity->username, PDO::PARAM_STR),
            new QueryParam(':ip_address', $entity->ip_address, PDO::PARAM_STR),
        );

        DatabaseManager::update('UPDATE user_sessions SET id = :id, username = :username, ip_address = :ip_address, last_activity = now() WHERE id = :id', $parameters);
        return $entity;
    }

    function delete($entity)
    {
        $parameters = array(
            new QueryParam(':id', $entity->id, PDO::PARAM_STR),
        );

        DatabaseManager::delete('delete from user_sessions WHERE id = :id', $parameters);
        $entity = null;
    }
}