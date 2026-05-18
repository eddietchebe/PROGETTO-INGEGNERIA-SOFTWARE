<?php

namespace App\Model;

use App\Config\Dbconnection;
use PDO;

class Announcement {

    // =======================
    // CREATE
    // =======================
    public static function create(
        $message,
        $admin_id
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                INSERT INTO announcements (

                    message,
                    admin_id

                )

                VALUES (

                    :message,
                    :admin_id

                )

            ");


        return $stmt->execute([

            'message' =>
                $message,

            'admin_id' =>
                $admin_id

        ]);

    }



    public static function update($id, $message) {

        $pdo = Dbconnection::connect();

        $stmt = $pdo->prepare("
            UPDATE announcements
            SET message = :message
            WHERE id = :id
        ");

        return $stmt->execute([

            'message' => $message,

            'id' => $id

        ]);

    }



    public static function delete($id) {

        $pdo = Dbconnection::connect();

        $stmt = $pdo->prepare("
            DELETE FROM announcements
            WHERE id = :id
        ");

        return $stmt->execute([

            'id' => $id

        ]);

    }



    // =======================
    // GET LATEST
    // =======================
    public static function all() {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->query("

                SELECT

                    announcements.*,

                    users.name

                FROM announcements

                JOIN users
                    ON users.id = announcements.admin_id

                ORDER BY announcements.id DESC

            ");


        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

    }

}