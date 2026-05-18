<?php

namespace App\Controller;

use App\Service\CategoryService;

class CategoryController {

    public function index() {

        $service =
            new CategoryService();

        echo json_encode(

            $service->getAll()

        );

    }

}