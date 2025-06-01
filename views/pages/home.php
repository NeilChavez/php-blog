<h1>Info home</h1>
<?php

if(isset($_GET["message"]) && str_ends_with(($_GET["message"]), "success"))
{
  ?>
  <div style="border: 5px solid green; width: fit-content;"> <?php echo $_GET["message"]?>!</div>
  <?php 
}
;
?>
<?php dump($posts) ?>
