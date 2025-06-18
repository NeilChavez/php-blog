<div class="postsList">
  <?php
  $count = array_fill(0, 10, "a");
  foreach ($count as $value): ?>
  <?php require "cardPost.php";?>
  <?php endforeach; ?>
</div>