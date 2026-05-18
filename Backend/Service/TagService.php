<?php

namespace App\Service;

use App\Model\Tag;

class TagService {

    public function getAll() {

        return Tag::all();

    }

}