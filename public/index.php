<?php
include __DIR__ . "/../config/app.php";

use MVC\Router;
use controller\PageController;
use controller\PostController;

$router = new Router();

//pages 
$router->get("/home", [PageController::class, "index"]);
$router->get("/info", [PageController::class, "info"]);
$router->get("/about-us", [PageController::class, "aboutUs"]);

//Crud Posts
$router->get("/post/all", [PostController::class, "readAll"]);
$router->get("/post", [PostController::class, "findSinglePost"]);
$router->get("/post/create", [PostController::class, "createPost"]);
$router->post("/post/create", [PostController::class, "createPost"]);
$router->get("/post/edit", [PostController::class, "editPost"]);
$router->post("/post/edit", [PostController::class, "editPost"]);
$router->get("/posts/delete", [PostController::class, "deletePost"]);

$router->checkRoutes();
