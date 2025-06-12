<?php
include __DIR__ . "/../config/app.php";

use MVC\Router;
use controller\UserController;
use controller\AuthController;
use controller\CommentController;
use controller\PageController;
use controller\PostController;
use controller\SignUpController;

$router = new Router();

//pages 
$router->get("/home", [PageController::class, "index"]);
$router->get("/info", [PageController::class, "info"]);
$router->get("/about-us", [PageController::class, "aboutUs"]);
$router->get("/dashboard", [PageController::class, "dashboard"]);

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
 $router->get("/login", [AuthController::class, "login"]);
 $router->post("/login", [AuthController::class, "login"]);

//Users logout
 $router->get("/logout", [AuthController::class, "logout"]);

//Crud users
$router->get("/users/all", [UserController::class, "readAll"]);
$router->get("/users/create", [userController::class, "createUser"]);
$router->post("/users/create", [userController::class, "createUser"]);
$router->get("/users/edit", [userController::class, "editUser"]);
$router->post("/users/edit", [userController::class, "editUser"]);
$router->post("/users/delete", [userController::class, "deleteUser"]);
$router->get("/user", [userController::class, "findSingleUser"]);

//Crud comments
$router->post("/comment/create", [CommentController::class, "create"]);
$router->get("/comment/update", [CommentController::class, "update"]);
$router->post("/comment/update", [CommentController::class, "update"]);
$router->post("/comment/delete",[CommentController::class, "delete"]);

$router->checkRoutes();
