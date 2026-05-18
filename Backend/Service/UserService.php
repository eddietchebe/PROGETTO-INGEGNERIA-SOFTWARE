<?php

namespace App\Service;

use App\Model\User;
use App\Config\JwtHandler;

class UserService {


    // =======================
    // REGISTER
    // =======================
    public function createUser(
        $name,
        $email,
        $password,
        $role
    ) {

        return User::create(

            $name,

            $email,

            $password,

            $role

        );

    }



    // =======================
    // LOGIN
    // =======================


    public function loginUser(
        $email,
        $password
    ) {

        error_log("EMAIL: " . $email);

        error_log("PASSWORD INPUT: " . $password);


        $user = User::findByEmail($email);


        error_log(
            "USER FOUND: " .
            json_encode($user)
        );


        if (
            !$user ||
            !password_verify(
                $password,
                $user['password']
            )
        ) {

            error_log("PASSWORD CHECK FAILED");

            return null;
        }


        error_log("PASSWORD OK");


        $jwt = new JwtHandler();

        return $jwt->generateToken($user);

    }



    /*
    public function loginUser(
        $email,
        $password
    ) {

        $user =
            User::findByEmail(
                $email
            );


        if (

            !$user ||

            !password_verify(

                $password,

                $user['password']

            )

        ) {

            return null;

        }


        $jwt =
            new JwtHandler();


        return $jwt->generateToken(
            $user
        );

    }*/



    // =======================
    // GET ALL USERS
    // =======================
    public function getAllUsers() {

        return User::all();

    }



    // =======================
    // DELETE USER
    // =======================
    public function deleteUser(
        $id
    ) {

        $user =
            User::findById(
                $id
            );


        if (!$user) {

            return false;

        }


        return User::delete(
            $id
        );
    }

    

}