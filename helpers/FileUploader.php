<?php

namespace helper;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileUploader
{
  private static $allowedFiles = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
  private static $errors = [];
  private static $imagesPath = "/src/images/";

  static function validate($entityImage)
  {
    if (!$entityImage && !in_array($_FILES["file"]["type"], self::$allowedFiles)) {
      self::$errors[] = "The format is not valid";
    }
    // if (!count($_FILES) > 0) {
    //   self::$errors[] = "You need to upload an image";
    // }
    if ($_FILES["file"]["size"] > 8388608) {
      self::$errors[] = "The file uploaded is too big, max 8MB";
    }
    return self::$errors;
  }

  static function upload($fileImageName, $entityImage)
  {
    $documentRoot = $_SERVER["DOCUMENT_ROOT"];
    $errors = self::validate($entityImage);
    $imageName = "";
    //upload image only if it passes validations
    if (!count($errors) > 0) {
      //upload new file
      $fileImageName = $_FILES["file"]["name"];
      //generate directory for images
      if (!is_dir($documentRoot . self::$imagesPath)) {
        mkdir($documentRoot . self::$imagesPath);
      }
      if ($fileImageName) {
        $oldImage = $documentRoot . self::$imagesPath . $entityImage;
        //if the entity has already an image and the user want to upload a new image, so we need to delete the "old" image
        if ($entityImage) {
          is_file($oldImage) && unlink($oldImage);
        }
        $temp = $_FILES["file"]["tmp_name"];
        $manager = new ImageManager(new Driver());
        $image = $manager->read($temp);
        $imageName = self::generateRandomName();
        $image->save($documentRoot . self::$imagesPath . $imageName);
      } else {
        $imageName = $entityImage;
      }
    }
    return [
      "errors" => $errors,
      "imageName" => $imageName
    ];
  }

  private static function generateRandomName()
  {
    $randomName = uniqid(rand(), true) . ".jpg";
    return $randomName;
  }
}
