<?php

namespace App\Config;

use PDO;
use PDOException;

class Dbconnection {

    public static function connect(): PDO {

        try {

            $pdo = new PDO(
                "mysql:host=db;dbname=testdb;charset=utf8mb4",
                "testuser",
                "testpass"
            );

            $pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $pdo->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            return $pdo;

        } catch (PDOException $e) {

            die("Database connection error: " . $e->getMessage());
        }
    }
}