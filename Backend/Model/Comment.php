<?php

namespace App\Model;

use App\Config\Dbconnection;
use PDO;

class Comment {


    // =======================
    // CREATE COMMENT
    // =======================
    public static function create(
        $content,
        $user_id,
        $post_id
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                INSERT INTO comments (

                    content,

                    user_id,

                    post_id

                )

                VALUES (

                    :content,

                    :user_id,

                    :post_id

                )

            ");


        return $stmt->execute([

            'content' => $content,

            'user_id' => $user_id,

            'post_id' => $post_id

        ]);

    }



    // =======================
    // GET COMMENTS BY POST
    // =======================
    public static function getByPost(
        $post_id
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                SELECT

                    comments.*,

                    users.name,

                    users.role

                FROM comments

                JOIN users
                    ON comments.user_id = users.id

                WHERE comments.post_id = :post_id

                ORDER BY comments.id DESC

            ");


        $stmt->execute([

            'post_id' => $post_id

        ]);


        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

    }



    // =======================
    // FIND COMMENT
    // =======================
    public static function findById(
        $id
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                SELECT *
                FROM comments
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
    // DELETE COMMENT
    // =======================
    public static function deleteById(
        $id
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                DELETE FROM comments
                WHERE id = :id

            ");


        return $stmt->execute([

            'id' => $id

        ]);

    }



    // =======================
    // UPDATE COMMENT
    // =======================
    public static function updateById(
        $id,
        $content
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                UPDATE comments

                SET content = :content

                WHERE id = :id

            ");


        return $stmt->execute([

            'content' => $content,

            'id' => $id

        ]);

    }

}