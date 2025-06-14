<?php

namespace controller;

use model\Category;
use MVC\Router;

class CategoryController
{
  static function readAll(Router $router)
  {
    $categories = Category::getAll();
    $router->render("/categories/all-categories", [
      "categories" => $categories
    ]);
  }
  static function create(Router $router)
  {
    $category = new Category;
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $category = new Category($_POST);
      $errors = array_merge($errors, $category->validate());
      if (empty($errors)) {
        $res = $category->save();
        if ($res) {
          header("Location: /categories/all");
          exit;
        }
      }
    }
    $router->render("categories/create", [
      "category" => $category,
      "errors" => $errors
    ]);
  }

  static function update(Router $router)
  {
    $category = new Category;
    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $category->sincronize($_POST);
      $errors = array_merge($errors, $category->validate());
      if (empty($errors)) {
        $res = $category->save();
        if ($res) {
          header("Location: /categories/all-categories");
          exit;
        }
      }
    }
    $router->render("categories/create", [
      "category" => $category,
      "errors" => $errors
    ]);
  }
  static function delete()
  {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $id = $_POST["id"];
      $category =  Category::find($id);
      if ($category) {
        $category->delete();
        header("Location: /categories/all?message=success-category-deleted");
        exit;
      }
    }
  }
}
