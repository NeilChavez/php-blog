<?php

namespace model;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use model\ActiveRecord\ActiveRecord;

class User extends ActiveRecord
{
  public $id;
  public $username;
  public $avatar;
  public $email;
  public $password;
  public $role;
  public $token;
  public $created_at;
  public $updated_at;
  static $table = "users";
  static $columns = ["id", "username", "avatar", "email", "password", "role", "token", "created_at", "updated_at"];
  static $errors = [];

  public function __construct($args = [])
  {
    $this->id = $args["id"] ?? null;
    $this->username = isset($args["username"]) ? trim($args["username"]) : "";
    $this->avatar = $args["avatar"] ?? null;
    $this->email = isset($args["email"]) ? trim($args["email"]) : "";
    $this->password = $args["password"] ?? "";
    $this->role = $args["role"] ?? "subscriber"; // by default subscriber
    $this->created_at = self::now() ?? "";
    $this->updated_at = $args["updated_at"] ?? "";
  }

  function validate(): array
  {
    $emailPattern = '/^\\S+@\\S+\\.\\S+$/';
    $isValidEmail = preg_match($emailPattern, $this->email);
    if (!$isValidEmail) {
      self::$errors[] = "Write a valid email.";
    }
    if ($this->username === "") {
      self::$errors[] = "Write a valid username.";
    }
    if (strlen($this->username) < 6) {
      self::$errors[] = "Username should be at least 6 characters.";
    }
    if (strlen($this->password) < 6) {
      self::$errors[] = "Password should be at least 6 characters.";
    }
    return self::$errors;
  }

  function createUser()
  {
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    $res = $this->save();
    if ($res) {
      header("Location: /check-your-email?message=created");
      exit;
    }
  }

  function editUser()
  {
    $res = $this->save();
    if ($res) {
      header("Location: /dashboard/users");
      exit;
    }
  }

  function createToken()
  {
    $token = bin2hex(random_bytes(50));
    $this->token = $token;
  }
  function sendVerificationEmail($email, $token)
  {
    $mail = new PHPMailer(true);
    try {
      // Server settings
      $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to DEBUG_SERVER for debugging
      $mail->isSMTP();
      $mail->Host = 'sandbox.smtp.mailtrap.io'; // Mailtrap SMTP server host 
      $mail->SMTPAuth = true;
      $mail->Username = USER_SMPT; // Your Mailtrap SMTP username
      $mail->Password = PASS_SMTP; // Your Mailtrap SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
      $mail->Port = 2525; // TCP port to connect to
      //Recipients
      $mail->setFrom('mail@fortest.com', "Neil Chavez"); //Sender's email and name
      $mail->addAddress($email); // Recipient's email
      //Content
      $mail->isHTML(true); //Set to true if sending HTML email
      $mail->Subject = 'Email Verification';
      $content = "<html>";
      $content .= "<body>";
      $content .= "<h1>Welcome to our blog!</h1>";
      $content .= "<p>Here you have the link to activate your user:</p>";
      $content .= "<a style='border: 2px solid blue;' href='" . DOMAIN_NAME . "/activate-user?token=" . $token . "'>";
      $content .= "Active you account!";
      $content .= "</a>";
      $content .= "</body>";
      $content .= "</html>";

      $mail->Body = $content;
      $mail->send();
      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  function isConfirmedUser()
  {
    //if is confirmed, the token is 1, if it's different the user has a token to confirm
    return $this->token === "1";
  }

  function deleteUser()
  {
    $imagePath = $_SERVER["DOCUMENT_ROOT"] . "/public/images/" . $this->avatar;
    if(file_exists($imagePath)){
      unlink($imagePath);
    }
    $res = $this->delete();
    if ($res) {
      header("Location: /dashboard/users");
    }
  }

  function setAvatar($fileName)
  {
    $this->avatar = $fileName;
  }

  function setPassword($password){
    $this->password = $password;
  }
}
