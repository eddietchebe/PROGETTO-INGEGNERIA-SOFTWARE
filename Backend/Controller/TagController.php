<?php

namespace App\Controller;

use App\Service\TagService;

class TagController {

    public function index() {

        $service =
            new TagService();

        echo json_encode(

            $service->getAll()

        );

    }

}