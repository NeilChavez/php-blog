<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo TITLE_SITE ?></title>
  <link rel="stylesheet" href="/src/css/styles.css">
</head>

<body>
  <?php require "../config/templates/header.php"; ?>
  <?php echo $content ?>
  <?php require "../config/templates/footer.php"; ?>
  <script src="/src/javascript/index.js"></script>
</body>

</html>