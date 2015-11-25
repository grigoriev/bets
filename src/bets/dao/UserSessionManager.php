<?php

namespace bets\dao;

use bets\db\DatabaseManager;
use bets\db\QueryParam;
use bets\exceptions;
use bets\exceptions\EntityNotFoundException;
use bets\model\Error;
use bets\model\UserSession;
use bets\utils\UUID;
use Exception;
use PDO;


class UserSessionManager extends AbstractManager
{
    function create($entity)
    {
        $entity->uuid = UUID::generate();
        $entity->last_activity = UUID::generate();
        $parameters = array(
            new QueryParam(':uuid', $entity->uuid, PDO::PARAM_STR),
            new QueryParam(':username', $entity->username, PDO::PARAM_STR),
            new QueryParam(':ip_address', $entity->ip_address, PDO::PARAM_STR),
        );

        try {
            $existingSession = $this->findByUsernameAndIpAddress($entity->username, $entity->ip_address);
            return $this->update($existingSession);
        } catch (EntityNotFoundException $e) {
            try {
                DatabaseManager::create('INSERT INTO user_sessions (uuid, username, ip_address, last_activity) VALUES (:uuid, :username, :ip_address, now())', $parameters);
                return $this->findById($entity->uuid);
            } catch (Exception $e) {
                return new Error($e);
            }
        }
    }

    function findById($uuid)
    {
        $parameters = array(
            new QueryParam(':uuid', $uuid, PDO::PARAM_STR),
        );

        $selected = DatabaseManager::selectAsObject('SELECT * FROM user_sessions WHERE uuid = :uuid', $parameters);
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

    function findByUsername($username)
    {
        $parameters = array(
            new QueryParam(':username', $username, PDO::PARAM_STR),
        );

        $selected = DatabaseManager::selectAsArray('SELECT * FROM user_sessions WHERE username = :username', $parameters);

        $result = array();
        foreach ($selected as $row) {
            array_push($result, new UserSession($row));
        }
        return $result;
    }

    public function findByUsernameAndIpAddress($username, $ip_address)
    {
        $parameters = array(
            new QueryParam(':username', $username, PDO::PARAM_STR),
            new QueryParam(':ip_address', $ip_address, PDO::PARAM_STR),
        );

        try {
            $selected = DatabaseManager::selectAsObject('SELECT * FROM user_sessions WHERE username = :username AND ip_address = :ip_address', $parameters);
            return new UserSession($selected);
        } catch (EntityNotFoundException $e) {
            return new UserSession();
        }
    }

    function update($entity)
    {
        $parameters = array(
            new QueryParam(':uuid', $entity->uuid, PDO::PARAM_STR),
            new QueryParam(':username', $entity->username, PDO::PARAM_STR),
            new QueryParam(':ip_address', $entity->ip_address, PDO::PARAM_STR),
        );

        DatabaseManager::update('UPDATE user_sessions SET uuid = :uuid, username = :username, ip_address = :ip_address, last_activity = now() WHERE uuid = :uuid', $parameters);
        return $this->findById($entity->uuid);
    }

    function delete($entity)
    {
        $parameters = array(
            new QueryParam(':uuid', $entity->uuid, PDO::PARAM_STR),
        );

        DatabaseManager::delete('DELETE FROM user_sessions WHERE uuid = :uuid', $parameters);
        $entity = null;
    }


}