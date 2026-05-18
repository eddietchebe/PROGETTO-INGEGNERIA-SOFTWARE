<?php

namespace App\Controller;

use App\Model\Comment;
use App\Config\Dbconnection;
use App\Config\JwtHandler;

class CommentController {

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


    public function store() {

        $user = $this->getUserFromToken();

        if (!$user) {
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized"]);
            return;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        if (
            empty($input['content']) ||
            empty($input['post_id'])
        ) {
            http_response_code(400);
            echo json_encode(["error" => "Missing or invalid fields"]);
            return;
        }

        $service = new \App\Service\CommentService();

        $ok = $service->createComment(
            $input['content'],
            $user->id,
            $input['post_id']
        );

        if ($ok) {
            echo json_encode(["message" => "Comment added"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed"]);
        }
    }


    public function delete($id) {

        $user = $this->getUserFromToken();

        if (!$user) {

            http_response_code(401);

            echo json_encode([
                "error" => "Unauthorized"
            ]);

            return;
        }


        $service =
            new \App\Service\CommentService();


        $ok =
            $service->deleteComment(

                $id,

                $user

            );


        if ($ok) {

            echo json_encode([
                "message" => "Comment deleted"
            ]);

        }

        else {

            http_response_code(403);

            echo json_encode([
                "error" => "Forbidden"
            ]);

        }

    }


    public function update($id) {

        $user = $this->getUserFromToken();

        if (!$user) {

            http_response_code(401);

            echo json_encode([
                "error" => "Unauthorized"
            ]);

            return;
        }


        $input = json_decode(
            file_get_contents("php://input"),
            true
        );


        if (empty($input['content'])) {

            http_response_code(400);

            echo json_encode([
                "error" => "Content required"
            ]);

            return;
        }


        $service =
            new \App\Service\CommentService();


        $ok =
            $service->updateComment(

                $id,

                $input['content'],

                $user

            );


        if ($ok) {

            echo json_encode([
                "message" => "Comment updated"
            ]);

        }

        else {

            http_response_code(403);

            echo json_encode([
                "error" => "Forbidden"
            ]);

        }

    }


    public function index($post_id) {

            if (empty($post_id)) {
                http_response_code(400);
                echo json_encode(["error" => "post_id is required"]);
                return;
            }

            $service = new \App\Service\CommentService();

            $comments = $service->getCommentsByPost($post_id);

            echo json_encode($comments);
    }
}