<?php

namespace App\Model;

use App\Config\Dbconnection;
use PDO;

class Post {

    // =======================
    // CREATE POST
    // =======================
    public static function create(
        $title,
        $content,
        $user_id,
        $category_id = null
    ) {

        $pdo = Dbconnection::connect();

        $stmt = $pdo->prepare("
            INSERT INTO posts (
                title,
                content,
                user_id,
                category_id
            )
            VALUES (
                :title,
                :content,
                :user_id,
                :category_id
            )
        ");

        $stmt->execute([

            'title' => $title,

            'content' => $content,

            'user_id' => $user_id,

            'category_id' => $category_id

        ]);


        return $pdo->lastInsertId();

    }



    // =======================
    // FIND POST BY ID
    // =======================
    public static function findById(
        $id
    ) {

        $pdo = Dbconnection::connect();

        $stmt = $pdo->prepare("
            SELECT *
            FROM posts
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
    // UPDATE POST
    // =======================
    public static function update(
        $id,
        $title,
        $content
    ) {

        $pdo = Dbconnection::connect();

        $stmt = $pdo->prepare("
            UPDATE posts
            SET
                title = :title,
                content = :content
            WHERE id = :id
        ");

        return $stmt->execute([

            'id' => $id,

            'title' => $title,

            'content' => $content

        ]);

    }



    // =======================
    // DELETE POST
    // =======================
    public static function delete(
        $id
    ) {

        $pdo = Dbconnection::connect();

        $stmt = $pdo->prepare("
            DELETE FROM posts
            WHERE id = :id
        ");

        return $stmt->execute([

            'id' => $id

        ]);

    }



    // =======================
    // GET ALL POSTS
    // =======================
    public static function all(
        $search = ""
    ) {

        $pdo =
            Dbconnection::connect();


        $stmt =
            $pdo->prepare("

                SELECT DISTINCT

                    posts.*,

                    users.name,

                    users.role,

                    categories.name AS category

                FROM posts

                JOIN users
                    ON posts.user_id = users.id

                LEFT JOIN categories
                    ON posts.category_id = categories.id

                LEFT JOIN post_tags
                    ON posts.id = post_tags.post_id

                LEFT JOIN tags
                    ON post_tags.tag_id = tags.id

                WHERE

                    posts.title LIKE :search

                    OR posts.content LIKE :search

                    OR categories.name LIKE :search

                    OR tags.name LIKE :search

                ORDER BY posts.id DESC

            ");


        $stmt->execute([

            'search' =>
                "%" . $search . "%"

        ]);


        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

    }

}