<?php

namespace App\Controller;

use App\Model\Post;
use App\Config\Dbconnection;
use App\Config\JwtHandler;

class PostController {

    // 🔐 GET USER FROM TOKEN
    private function getUserFromToken() {

        $headers = getallheaders();

        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$authHeader) {
            return null;
        }

        $token = str_replace("Bearer ", "", $authHeader);

        $jwt = new JwtHandler();
        $decoded = $jwt->validateToken($token);

        if (!$decoded) return null;

        return $decoded->data ?? $decoded->{0} ?? null;
    }


    // 📝 CREATE POST
   public function store() {

        $user = $this->getUserFromToken();

        if (!$user) {

            http_response_code(401);

            echo json_encode([
                "error" => "Unauthorized"
            ]);

            return;
        }


        // =======================
        // ADMIN CANNOT CREATE POSTS
        // =======================
        if ($user->role === "admin") {

            http_response_code(403);

            echo json_encode([
                "error" => "Admin cannot create posts"
            ]);

            return;
        }


        $input = json_decode(
            file_get_contents("php://input"),
            true
        );


        if (

            empty($input['title']) ||

            empty($input['content'])

        ) {

            http_response_code(400);

            echo json_encode([
                "error" => "Missing fields"
            ]);

            return;
        }


        $service =
            new \App\Service\PostService();


        $service->createPost(

            $input,

            $user->id

        );


        echo json_encode([
            "message" => "Post created"
        ]);
    }


    // ✏️ UPDATE POST
   public function update($id) {

        $user = $this->getUserFromToken();

        if (!$user) {
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized"]);
            return;
        }

        $input = json_decode(
            file_get_contents("php://input"),
            true
        );

        if (
            empty($input['title']) ||
            empty($input['content'])
        ) {

            http_response_code(400);

            echo json_encode([
                "error" => "Missing fields"
            ]);

            return;
        }


        $service = new \App\Service\PostService();

        $ok = $service->updatePost(

            $id,

            $input,

            $user

        );


        if (!$ok) {

            http_response_code(403);

            echo json_encode([
                "error" => "Forbidden or post not found"
            ]);

            return;
        }


        echo json_encode([
            "message" => "Post updated"
        ]);
    }


    // 🗑 DELETE POST
   public function delete($id) {

        $user = $this->getUserFromToken();

        if (!$user) {

            http_response_code(401);

            echo json_encode([
                "error" => "Unauthorized"
            ]);

            return;
        }


        $service = new \App\Service\PostService();

        $ok = $service->deletePost(

            $id,

            $user

        );


        if (!$ok) {

            http_response_code(403);

            echo json_encode([
                "error" => "Forbidden or post not found"
            ]);

            return;
        }


        echo json_encode([
            "message" => "Post deleted"
        ]);
    }


    // 📄 GET POSTS
    public function index() {

        $search =
            $_GET['search'] ?? "";

        $service =
            new \App\Service\PostService();

        $posts =
            $service->getAllPosts(
                $search
            );

        echo json_encode(
            $posts
        );
    }
}