<?php

namespace App\Model;

use App\Config\Dbconnection;
use PDO;

class User {


    // =======================
    // CREATE USER
    // =======================
    public static function create(
        $name,
        $email,
        $password,
        $role
    ) {

        $pdo = Dbconnection::connect();


        // HASH PASSWORD
        $hashedPassword =
            password_hash(
                $password,
                PASSWORD_DEFAULT
            );


        $stmt = $pdo->prepare("
            INSERT INTO users (
                name,
                email,
                password,
                role
            )
            VALUES (
                :name,
                :email,
                :password,
                :role
            )
        ");


        return $stmt->execute([

            'name' => $name,

            'email' => $email,

            'password' => $hashedPassword,

            'role' => $role

        ]);

    }



    // =======================
    // GET ALL USERS
    // =======================
    public static function all() {

        $pdo = Dbconnection::connect();


        $stmt = $pdo->query("
            SELECT
                id,
                name,
                email,
                role,
                created_at
            FROM users
            ORDER BY id DESC
        ");


        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

    }



    // =======================
    // FIND USER BY ID
    // =======================
    public static function findById(
        $id
    ) {

        $pdo = Dbconnection::connect();


        $stmt = $pdo->prepare("
            SELECT *
            FROM users
            WHERE id = :id
        ");


        $stmt->execute([

            'id' => $id

        ]);


        return $stmt->fetch(
            PDO::FETCH_ASSOC
        );

    }



    // =======================
    // FIND USER BY EMAIL
    // =======================
    public static function findByEmail(
        string $email
    ) {

        $pdo = Dbconnection::connect();


        $stmt = $pdo->prepare("
            SELECT *
            FROM users
            WHERE email = :email
        ");


        $stmt->execute([

            'email' => $email

        ]);


        return $stmt->fetch(
            PDO::FETCH_ASSOC
        );

    }



    // =======================
    // DELETE USER
    // =======================
    public static function delete(
        $id
    ) {

        $pdo = Dbconnection::connect();


        $stmt = $pdo->prepare("
            DELETE FROM users
            WHERE id = :id
        ");


        return $stmt->execute([

            'id' => $id

        ]);

    }

}