<?php

namespace App\Controller;

use App\Config\JwtHandler;

class UserController {


    // =======================
    // GET USER FROM TOKEN
    // =======================
    private function getUserFromToken() {

        $headers =
            getallheaders();


        $authHeader =
            $headers['Authorization']
            ?? $headers['authorization']
            ?? null;


        if (!$authHeader) {
            return null;
        }


        $token =
            str_replace(
                "Bearer ",
                "",
                $authHeader
            );


        $jwt =
            new JwtHandler();


        $decoded =
            $jwt->validateToken(
                $token
            );


        if (!$decoded) {
            return null;
        }


        return
            $decoded->data
            ?? null;

    }



    // =======================
    // REGISTER
    // =======================
    public function store() {

        header('Content-Type: application/json');

        $input = json_decode(
            file_get_contents("php://input"),
            true
        ) ?? [];


        if (

            empty($input['name']) ||

            empty($input['email']) ||

            empty($input['password'])

        ) {

            http_response_code(400);

            echo json_encode([
                "error" =>
                    "Name, email and password required"
            ]);

            return;
        }


        $role =
            $input['role']
            ?? 'editor';


        // ADMIN KEY
        if ($role === "admin") {

            $adminKey =
                $input['admin_key']
                ?? "";


            if ($adminKey !== "Vincenzo") {

                http_response_code(403);

                echo json_encode([
                    "error" =>
                        "Chiave admin non valida"
                ]);

                return;
            }

        }


        try {

            $service =
                new \App\Service\UserService();


            $ok =
                $service->createUser(

                    $input['name'],

                    $input['email'],

                    $input['password'],

                    $role

                );


            if ($ok) {

                echo json_encode([
                    "message" =>
                        "User created"
                ]);

            }

            else {

                http_response_code(500);

                echo json_encode([
                    "error" =>
                        "Failed to create user"
                ]);

            }

        }

        catch (\Exception $e) {

            http_response_code(500);

            echo json_encode([
                "error" =>
                    $e->getMessage()
            ]);

        }

    }



    // =======================
    // LOGIN
    // =======================
    public function login() {

        header('Content-Type: application/json');

        $input = json_decode(
            file_get_contents("php://input"),
            true
        ) ?? [];


        if (

            empty($input['email']) ||

            empty($input['password'])

        ) {

            http_response_code(400);

            echo json_encode([
                "error" =>
                    "Missing credentials"
            ]);

            return;
        }


        $service =
            new \App\Service\UserService();


        $token =
            $service->loginUser(

                $input['email'],

                $input['password']

            );


        if (!$token) {

            http_response_code(401);

            echo json_encode([
                "error" =>
                    "Invalid credentials"
            ]);

            return;

        }


        echo json_encode([

            "message" =>
                "Login successful",

            "token" =>
                $token

        ]);

    }



    // =======================
    // GET ALL USERS (ADMIN)
    // =======================
    public function index() {

        $user =
            $this->getUserFromToken();


        if (

            !$user ||

            $user->role !== "admin"

        ) {

            http_response_code(403);

            echo json_encode([
                "error" => "Forbidden"
            ]);

            return;

        }


        $service =
            new \App\Service\UserService();


        $users =
            $service->getAllUsers();


        echo json_encode(
            $users
        );

    }



    // =======================
    // DELETE USER (ADMIN)
    // =======================
    public function delete(
        $id
    ) {

        $user =
            $this->getUserFromToken();


        if (

            !$user ||

            $user->role !== "admin"

        ) {

            http_response_code(403);

            echo json_encode([
                "error" => "Forbidden"
            ]);

            return;

        }


        $service =
            new \App\Service\UserService();


        $ok =
            $service->deleteUser(
                $id
            );


        if ($ok) {

            echo json_encode([
                "message" =>
                    "User deleted"
            ]);

        }

        else {

            http_response_code(404);

            echo json_encode([
                "error" =>
                    "User not found"
            ]);

        }

    }

}