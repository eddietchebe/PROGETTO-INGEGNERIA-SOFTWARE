<?php

namespace App\Config;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler {

    private string $secret = "MY_SECRET_KEY";


    public function generateToken($user): string {

        $payload = [

            "iss" => "localhost",

            "iat" => time(),

            "exp" => time() + 3600,

            "data" => [

                "id" => $user['id'],

                "name" => $user['name'],

                "email" => $user['email'],

                "role" => $user['role']

            ]
        ];

        return JWT::encode(
            $payload,
            $this->secret,
            "HS256"
        );
    }



    public function validateToken($token) {

        try {

            return JWT::decode(
                $token,
                new Key($this->secret, "HS256")
            );

        } catch (\Exception $e) {

            return null;
        }
    }
}