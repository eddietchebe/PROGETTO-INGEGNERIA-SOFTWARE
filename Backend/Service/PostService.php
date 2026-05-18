<?php

namespace App\Service;

use App\Model\Post;
use App\Model\Tag;

class PostService {

    // =======================
    // CREATE POST
    // =======================
    public function createPost(
        $input,
        $user_id
    ) {

        $category_id =
            $input['category_id'] ?? null;


        $tags =
            $input['tags'] ?? [];


        // create post
        $post_id =
            Post::create(

                $input['title'],

                $input['content'],

                $user_id,

                $category_id

            );


        // create tags + relation
        foreach ($tags as $tagName) {

            $tag_id =
                Tag::findOrCreate(
                    $tagName
                );


            Tag::attachToPost(

                $post_id,

                $tag_id

            );

        }

        return true;

    }



    // =======================
    // UPDATE POST
    // =======================
    public function updatePost(
        $id,
        $input,
        $user
    ) {

        // find post
        $post =
            Post::findById(
                $id
            );


        if (!$post) {
            return false;
        }


        // permission check
        if (

            $post['user_id'] != $user->id &&

            $user->role !== "admin"

        ) {

            return false;

        }


        return Post::update(

            $id,

            $input['title'],

            $input['content']

        );

    }



    // =======================
    // DELETE POST
    // =======================
    public function deletePost(
        $id,
        $user
    ) {

        // find post
        $post =
            Post::findById(
                $id
            );


        if (!$post) {
            return false;
        }


        // permission check
        if (

            $post['user_id'] != $user->id &&

            $user->role !== "admin"

        ) {

            return false;

        }


        return Post::delete(
            $id
        );

    }



    // =======================
    // GET POSTS
    // =======================
    public function getAllPosts(
        $search = ""
    ) {

        return Post::all(
            $search
        );

    }

}