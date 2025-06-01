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
