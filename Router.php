<?php

namespace MVC;

class Router
{
  public $GET_routes;
  public $POST_routes;
  public function __construct()
  {
    $this->GET_routes = [];
    $this->POST_routes = [];
  }
  public function get(string $route, array $fn)
  {
    $this->GET_routes[$route] = $fn;
  }

  public function post(string $route, array $fn)
  {
    $this->POST_routes[$route] = $fn;
  }

  public function checkRoutes()
  {
    $urlTokenized = strtok($_SERVER["REQUEST_URI"], "?");
    $url = $urlTokenized === "/" ? "/home" : $urlTokenized;
    $method = $_SERVER["REQUEST_METHOD"];
    $protectedRoutes = ["/dashboard", "/post/create", "/post/edit", "/posts/delete", "/logout", "/users/create", "/users/edit", "/users/delete", "/comment/create", "/comment/update", "/comment/delete", "/categories/all", "/category/create", "/category/delete"];
    $isLoggedIn = false;
    @session_start();
    if (isset($_SESSION["user"])) {
      $isLoggedIn = true;
    }
    if(in_array($url, $protectedRoutes) && !$isLoggedIn){
      header("Location: /login");
      exit;
    }   
    $fn = "";
    if ($method === "GET") {
      $fn = $this->GET_routes[$url] ?? null;
    }
    if ($method === "POST") {
      $fn = $this->POST_routes[$url] ?? null;
    }

    if ($fn) {
      call_user_func($fn, $this);
    } else {
      $this->notFound();
    }
  }

  private function notFound()
  {
    http_response_code(404);
    echo "Page not found";
  }

  public function render($view, $args = []) {
    foreach($args as $key => $value)
    {
      $$key = $value;
    }
    ob_start();
    include_once __DIR__ . "/views/pages/" . $view . ".php";
    $content = ob_get_clean();
    include_once __DIR__ . "/views/layout.php";
  }
}
