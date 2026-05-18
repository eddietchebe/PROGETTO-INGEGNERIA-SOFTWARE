<?php

namespace App\Service;

use App\Model\Announcement;

class AnnouncementService {

    public function createAnnouncement(
        $message,
        $admin_id
    ) {

        return Announcement::create(

            $message,

            $admin_id

        );

    }


    public function updateAnnouncement(
        $id,
        $message
    ) {

        return Announcement::update(
            $id,
            $message
        );

    }



    public function deleteAnnouncement(
        $id
    ) {

        return Announcement::delete(
            $id
        );

    }



    public function getAllAnnouncements() {

        return Announcement::all();

    }

}