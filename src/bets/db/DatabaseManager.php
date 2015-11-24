<?php

namespace bets\db;

use bets\config\Config;
use bets\exceptions\EntityNotFoundException;
use bets\exceptions\ResultIsNotUniqueException;
use PDO;

class DatabaseManager
{
    private static $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    public static function connect()
    {
        return new PDO(Config::$dsn, Config::$user, Config::$pass, self::$options);
    }

    public static function disconnect($pdo)
    {
        $pdo = null;
    }

    public static function selectAsObject($sql, $parameters = null)
    {
        return self::select(true, $sql, $parameters);
    }

    public static function select($unique, $sql, $parameters = null)
    {
        $result = null;
        $pdo = self::connect();
        $statement = $pdo->prepare($sql);
        self::bindParameters($parameters, $statement);
        $statement->execute();

        if ($unique) {
            $count = $statement->rowCount();
            if ($count === 1) {
                $result = $statement->fetch();
            } elseif ($count === 0) {
                throw new EntityNotFoundException();
            } else {
                throw new ResultIsNotUniqueException();
            }
        } else {
            $result = array();
            foreach ($statement as $row) {
                array_push($result, $row);
            }
        }

        self::closeStatement($statement);
        self::disconnect($pdo);
        return $result;
    }

    public static function selectAsArray($sql, $parameters = null)
    {
        return self::select(false, $sql, $parameters);
    }

    public static function closeStatement($statement)
    {
        $statement->closeCursor();
        $statement = null;
    }

    public static function create($sql, $parameters)
    {
        $pdo = self::connect();
        $statement = $pdo->prepare($sql);
        self::bindParameters($parameters, $statement);
        $statement->execute();
        self::closeStatement($statement);
        $id = $pdo->lastInsertId();
        self::disconnect($pdo);
        return $id;
    }

    /**
     * @param $parameters
     * @param $statement
     */
    public static function bindParameters($parameters, $statement)
    {
        if ($parameters !== null) {
            foreach ($parameters as $parameter) {
                $statement->bindParam($parameter->name, $parameter->value, $parameter->type);
            }
        }
    }

    public static function update($sql, $parameters)
    {
        $pdo = self::connect();
        $statement = $pdo->prepare($sql);
        self::bindParameters($parameters, $statement);
        $statement->execute();
        self::closeStatement($statement);
        self::disconnect($pdo);
    }

    public static function delete($sql, $parameters)
    {
        $pdo = self::connect();
        $statement = $pdo->prepare($sql);
        self::bindParameters($parameters, $statement);
        $statement->execute();
        self::closeStatement($statement);
        self::disconnect($pdo);
    }
}