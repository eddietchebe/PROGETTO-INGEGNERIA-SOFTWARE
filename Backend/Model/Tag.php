<?php

namespace App\Model;

use App\Config\Dbconnection;
use PDO;

class Tag {

    // =======================
    // GET ALL TAGS
    // =======================
    public static function all() {

        $pdo =
            Dbconnection::connect();

        $stmt =
            $pdo->query("

                SELECT *
                FROM tags
                ORDER BY name ASC

            ");

        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

    }



    // =======================
    // FIND OR CREATE TAG
    // =======================
    public static function findOrCreate(
        $name
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                SELECT id
                FROM tags
                WHERE name = :name

            ");


        $stmt->execute([

            'name' => $name

        ]);


        $tag =
            $stmt->fetch(
                PDO::FETCH_ASSOC
            );


        if ($tag) {

            return $tag['id'];

        }


        $stmt =
            $pdo->prepare("

                INSERT INTO tags (
                    name
                )

                VALUES (
                    :name
                )

            ");


        $stmt->execute([

            'name' => $name

        ]);


        return $pdo->lastInsertId();

    }



    // =======================
    // LINK POST + TAG
    // =======================
    public static function attachToPost(
        $post_id,
        $tag_id
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                INSERT IGNORE INTO post_tags (

                    post_id,

                    tag_id

                )

                VALUES (

                    :post_id,

                    :tag_id

                )

            ");


        return $stmt->execute([

            'post_id' => $post_id,

            'tag_id' => $tag_id

        ]);

    }

}