<?php

// =======================
// CORS
// =======================
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


// =======================
// AUTOLOAD
// =======================
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Dbconnection;
use App\Config\DatabaseSetup;
use App\Controller\UserController;
use App\Controller\PostController;
use App\Controller\CommentController;


// =======================
// URL + METHOD
// =======================
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


// REMOVE FINAL SLASH
$uri = rtrim($uri, '/');

if ($uri === '') {
    $uri = '/';
}


// =======================
// JSON RESPONSE
// =======================
header('Content-Type: application/json');


// =======================
// DATABASE INIT
// =======================
$pdo = Dbconnection::connect();

DatabaseSetup::createTables();



// =======================
// CATEGORIES & TAGS
// =======================
if (
    $uri === "/categories" &&
    $method === "GET"
) {

    (new \App\Controller\CategoryController())
        ->index();

    exit;
}


if (
    $uri === "/tags" &&
    $method === "GET"
) {

    (new \App\Controller\TagController())
        ->index();

    exit;
}



// =======================
// POSTS
// =======================

// GET POSTS
if (
    $uri === '/posts' &&
    $method === 'GET'
) {

    (new PostController())
        ->index();

    exit;
}


// CREATE POST
if (
    $uri === '/posts' &&
    $method === 'POST'
) {

    (new PostController())
        ->store();

    exit;
}


// UPDATE POST
if (

    preg_match(
        '#^/posts/(\d+)$#',
        $uri,
        $matches
    )

    &&

    $method === 'PUT'

) {

    (new PostController())
        ->update(
            $matches[1]
        );

    exit;
}


// DELETE POST
if (

    preg_match(
        '#^/posts/(\d+)$#',
        $uri,
        $matches
    )

    &&

    $method === 'DELETE'

) {

    (new PostController())
        ->delete(
            $matches[1]
        );

    exit;
}



// =======================
// COMMENTS
// =======================

// GET COMMENTS
if (

    $uri === '/comments'

    &&

    $method === 'GET'

) {

    $post_id =
        $_GET['post_id']
        ?? null;


    (new CommentController())
        ->index(
            $post_id
        );

    exit;
}


// CREATE COMMENT
if (

    $uri === '/comments'

    &&

    $method === 'POST'

) {

    (new CommentController())
        ->store();

    exit;
}


// UPDATE COMMENT
if (

    preg_match(
        '#^/comments/(\d+)$#',
        $uri,
        $matches
    )

    &&

    $method === 'PUT'

) {

    (new CommentController())
        ->update(
            $matches[1]
        );

    exit;
}


// DELETE COMMENT
if (

    preg_match(
        '#^/comments/(\d+)$#',
        $uri,
        $matches
    )

    &&

    $method === 'DELETE'

) {

    (new CommentController())
        ->delete(
            $matches[1]
        );

    exit;
}



// =======================
// USERS
// =======================

// REGISTER
if (

    $uri === '/user'

    &&

    $method === 'POST'

) {

    (new UserController())
        ->store();

    exit;
}


// LOGIN
if (

    $uri === '/login'

    &&

    $method === 'POST'

) {

    (new UserController())
        ->login();

    exit;
}


// GET ALL USERS (ADMIN)
if (

    $uri === '/users'

    &&

    $method === 'GET'

) {

    (new UserController())
        ->index();

    exit;
}


// DELETE USER (ADMIN)
if (

    preg_match(
        '#^/users/(\d+)$#',
        $uri,
        $matches
    )

    &&

    $method === 'DELETE'

) {

    (new UserController())
        ->delete(
            $matches[1]
        );

    exit;
}




// =======================
// ANNOUNCEMENTS
// =======================

// GET
if (

    $uri === '/announcements'

    &&

    $method === 'GET'

) {

    (new \App\Controller\AnnouncementController())
        ->index();

    exit;

}


// CREATE
if (

    $uri === '/announcements'

    &&

    $method === 'POST'

) {

    (new \App\Controller\AnnouncementController())
        ->store();

    exit;

}


if (
    preg_match('#^/announcements/(\d+)$#', $uri, $matches)
    && $method === 'PUT'
) {

    (new \App\Controller\AnnouncementController())
        ->update($matches[1]);

    exit;
}


if (
    preg_match('#^/announcements/(\d+)$#', $uri, $matches)
    && $method === 'DELETE'
) {

    (new \App\Controller\AnnouncementController())
        ->delete($matches[1]);

    exit;
}



// =======================
// 404
// =======================
http_response_code(404);

echo json_encode([

    "error" =>
        "Route not found",

    "method" =>
        $method,

    "path" =>
        $uri

]);