<?php
include __DIR__ . "/../config/app.php";

use MVC\Router;
use controller\PageController;
use controller\PostController;
use controller\SignUpController;

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

//Users sign up
$router->get("/sign-up", [SignUpController::class, "signUp"]);
$router->post("/sign-up", [SignUpController::class, "signUp"]);

//Verify email of signed up users
$router->get("/check-your-email", [SignUpController::class, "checkYouEmail"]);
$router->get("/activate-user", [SignUpController::class, "activateUser"]);

//Users login
// $router->get("/login", [LoginController::class, "login"]);
// $router->post("/login", [LoginController::class, "login"]);

//Users login/logout
// $router->get("/logout", [LoginController::class, "logout"]);
// $router->post("/logout", [LoginController::class, "logout"]);

$router->checkRoutes();
