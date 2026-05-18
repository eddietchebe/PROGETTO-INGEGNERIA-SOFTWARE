<?php

namespace App\Service;

use App\Model\Category;

class CategoryService {

    public function getAll() {

        return Category::all();

    }

}