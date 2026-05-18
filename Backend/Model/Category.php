<?php

namespace App\Model;

use App\Config\Dbconnection;
use PDO;

class Category {

    public static function all() {

        $pdo = Dbconnection::connect();

        $stmt = $pdo->query("
            SELECT *
            FROM categories
            ORDER BY name ASC
        ");

        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

    }

}