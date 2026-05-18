<?php

namespace App\Service;

use App\Model\Comment;

class CommentService {


    // =======================
    // GET COMMENTS
    // =======================
    public function getCommentsByPost(
        $postId
    ) {

        return Comment::getByPost(
            $postId
        );

    }



    // =======================
    // CREATE COMMENT
    // =======================
    public function createComment(
        $content,
        $userId,
        $postId
    ) {

        return Comment::create(

            $content,

            $userId,

            $postId

        );

    }



    // =======================
    // DELETE COMMENT
    // =======================
    public function deleteComment(
        $commentId,
        $user
    ) {

        $comment =
            Comment::findById(
                $commentId
            );


        if (!$comment) {

            return false;

        }


        if (

            $comment['user_id'] != $user->id &&

            $user->role !== "admin"

        ) {

            return false;

        }


        return Comment::deleteById(
            $commentId
        );

    }



    // =======================
    // UPDATE COMMENT
    // =======================
    public function updateComment(
        $commentId,
        $content,
        $user
    ) {

        $comment =
            Comment::findById(
                $commentId
            );


        if (!$comment) {

            return false;

        }


        if (

            $comment['user_id'] != $user->id &&

            $user->role !== "admin"

        ) {

            return false;

        }


        return Comment::updateById(

            $commentId,

            $content

        );

    }

}