<?php

namespace App\Config;


use App\Config\Dbconnection;

class DatabaseSetup {

    public static function createTables() {

        

        $pdo = Dbconnection::connect();


        // =======================
        // USERS
        // =======================
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (

                id INT AUTO_INCREMENT PRIMARY KEY,

                name VARCHAR(100) NOT NULL,

                email VARCHAR(150) NOT NULL UNIQUE,

                password VARCHAR(255) NOT NULL,

                role VARCHAR(20) DEFAULT 'editor',

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

            )
        ");



        // =======================
        // CATEGORIES
        // =======================
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS categories (

                id INT AUTO_INCREMENT PRIMARY KEY,

                name VARCHAR(100) NOT NULL UNIQUE

            )
        ");



        // =======================
        // TAGS
        // =======================
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS tags (

                id INT AUTO_INCREMENT PRIMARY KEY,

                name VARCHAR(100) NOT NULL UNIQUE

            )
        ");



        // =======================
        // POSTS
        // =======================
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS posts (

                id INT AUTO_INCREMENT PRIMARY KEY,

                title VARCHAR(255) NOT NULL,

                content TEXT NOT NULL,

                user_id INT NOT NULL,

                category_id INT NULL,

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                FOREIGN KEY (user_id)
                    REFERENCES users(id)
                    ON DELETE CASCADE,

                FOREIGN KEY (category_id)
                    REFERENCES categories(id)
                    ON DELETE SET NULL

            )
        ");



        // =======================
        // COMMENTS
        // =======================
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS comments (

                id INT AUTO_INCREMENT PRIMARY KEY,

                content TEXT NOT NULL,

                user_id INT NOT NULL,

                post_id INT NOT NULL,

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                FOREIGN KEY (user_id)
                    REFERENCES users(id)
                    ON DELETE CASCADE,

                FOREIGN KEY (post_id)
                    REFERENCES posts(id)
                    ON DELETE CASCADE

            )
        ");


        // =======================
        // ANNOUNCEMENTS
        // =======================
        $pdo->exec("

            CREATE TABLE IF NOT EXISTS announcements (

                id INT AUTO_INCREMENT PRIMARY KEY,

                message TEXT NOT NULL,

                admin_id INT NOT NULL,

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                FOREIGN KEY (admin_id)
                    REFERENCES users(id)
                    ON DELETE CASCADE

            )

        ");



        // =======================
        // POST_TAGS
        // =======================
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS post_tags (

                id INT AUTO_INCREMENT PRIMARY KEY,

                post_id INT NOT NULL,

                tag_id INT NOT NULL,

                FOREIGN KEY (post_id)
                    REFERENCES posts(id)
                    ON DELETE CASCADE,

                FOREIGN KEY (tag_id)
                    REFERENCES tags(id)
                    ON DELETE CASCADE,

                UNIQUE(post_id, tag_id)

            )
        ");



        // =======================
        // DEFAULT CATEGORIES
        // =======================
        $pdo->exec("
            INSERT IGNORE INTO categories (name)
            VALUES

            ('PHP'),
            ('Docker'),
            ('MySQL'),
            ('Security'),
            ('API'),
            ('Frontend')
        ");



        // =======================
        // DEFAULT TAGS
        // =======================
        $pdo->exec("
            INSERT IGNORE INTO tags (name)
            VALUES

            ('backend'),
            ('jwt'),
            ('mysql'),
            ('docker'),
            ('api'),
            ('cms')
        ");

        
    }
    

   

}

