<?php
include __DIR__ . "/../config/app.php";

use MVC\Router;
use controller\AuthController;
use controller\PageController;
use controller\PostController;
use controller\UserController;
use controller\SignUpController;
use controller\CommentController;
use controller\CategoryController;
use controller\DashboardController;

$router = new Router();

/**********************
 * Blog public routes *
 **********************/
//pages 
$router->get("/home", [PageController::class, "index"]);
$router->get("/info", [PageController::class, "info"]);
$router->get("/about-us", [PageController::class, "aboutUs"]);
$router->get("/categories", [PageController::class, "byCategories"]);

/*********************************************************
 * Dashboard private routes with relatives CRUDS actions *
 *********************************************************/
$router->get("/dashboard", [DashboardController::class, "index"]);
$router->get("/dashboard/posts", [DashboardController::class, "posts"]);
$router->get("/dashboard/categories", [DashboardController::class, "categories"]);
$router->get("/dashboard/comments", [DashboardController::class, "comments"]);
$router->get("/dashboard/users", [DashboardController::class, "users"]);

//Crud Posts
$router->get("/dashboard/posts/create", [PostController::class, "createPost"]);
$router->post("/dashboard/posts/create", [PostController::class, "createPost"]);
$router->get("/dashboard/posts/edit", [PostController::class, "editPost"]);
$router->post("/dashboard/posts/edit", [PostController::class, "editPost"]);
$router->get("/dashboard/posts/delete", [PostController::class, "deletePost"]);

//Crud Category
$router->get("/dashboard/categories/all", [CategoryController::class, "readAll"]);
$router->get("/dashboard/category/create", [CategoryController::class, "create"]);
$router->post("/dashboard/category/create", [CategoryController::class, "create"]);
$router->get("/dashboard/category/update", [CategoryController::class, "update"]);
$router->post("/dashboard/category/update", [CategoryController::class, "update"]);
$router->post("/dashboard/category/delete", [CategoryController::class, "delete"]);
$router->get("/blog/not-authorized", [PageController::class, "notAuthorized"]);

//Approve or delete comments
$router->get("/dashboard/comments/to-approve", [CommentController::class, "toApprove"]);
$router->post("/dashboard/comment/approve", [CommentController::class, "approve"]);
$router->post("/dashboard/comment/unapprove", [CommentController::class, "unapprove"]);
$router->post("/dashboard/comment/delete", [CommentController::class, "delete"]);
//Crud users
$router->get("/dashboard/users/create", [userController::class, "createUser"]);
$router->post("/dashboard/users/create", [userController::class, "createUser"]);
$router->get("/dashboard/users/edit", [userController::class, "editUser"]);
$router->post("/dashboard/users/edit", [userController::class, "editUser"]);
$router->post("/dashboard/users/delete", [userController::class, "deleteUser"]);

//Crud comments
$router->post("/comment/create", [CommentController::class, "create"]);
$router->get("/comment/update", [CommentController::class, "update"]);
$router->post("/comment/update", [CommentController::class, "update"]);
$router->post("/comment/delete",[CommentController::class, "delete"]);


$router->get("/user", [userController::class, "findSingleUser"]);
$router->get("/post", [PostController::class, "findSinglePost"]);
$router->get("/post/all", [PostController::class, "readAll"]);
$router->get("/users/all", [UserController::class, "readAll"]);

//Users sign up
$router->get("/sign-up", [SignUpController::class, "signUp"]);
$router->post("/sign-up", [SignUpController::class, "signUp"]);

//Verify email of signed up users
$router->get("/blog/check-your-email", [SignUpController::class, "checkYouEmail"]);
$router->get("/blog/activate-user", [SignUpController::class, "activateUser"]);

//Users login
 $router->get("/login", [AuthController::class, "login"]);
 $router->post("/login", [AuthController::class, "login"]);

//Users logout
 $router->get("/logout", [AuthController::class, "logout"]);

$router->checkRoutes();
