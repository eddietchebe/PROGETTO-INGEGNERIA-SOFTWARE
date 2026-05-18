<?php

namespace App\Controller;

use App\Config\JwtHandler;

class AnnouncementController {

    private function getUserFromToken() {

        $headers =
            getallheaders();


        $authHeader =

            $headers['Authorization']

            ??

            $headers['authorization']

            ??

            null;


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

            ??

            $decoded->{0}

            ??

            null;

    }



    // =======================
    // CREATE (ADMIN)
    // =======================
    public function store() {

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


        $input =
            json_decode(
                file_get_contents(
                    "php://input"
                ),
                true
            );


        $service =
            new \App\Service\AnnouncementService();


        $service->createAnnouncement(

            $input['message'],

            $user->id

        );


        echo json_encode([
            "message" => "Announcement created"
        ]);

    }


    public function update($id) {

        $input = json_decode(
            file_get_contents("php://input"),
            true
        );


        $service =
            new \App\Service\AnnouncementService();


        $service->updateAnnouncement(

            $id,

            $input['message']

        );


        echo json_encode([
            "message" => "Announcement updated"
        ]);

    }



    public function delete($id) {

        $service =
            new \App\Service\AnnouncementService();


        $service->deleteAnnouncement(
            $id
        );


        echo json_encode([
            "message" => "Announcement deleted"
        ]);

    }



    // =======================
    // GET
    // =======================
    public function index() {

        $service =
            new \App\Service\AnnouncementService();


        echo json_encode(

            $service->getAllAnnouncements()

        );

    }

}