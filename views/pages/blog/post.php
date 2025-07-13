<div id="singlePostContent" class="single-post-content container">
  <h1><?php echo $post->title ?></h1>
  <div class="post-content-wrapper">
    <img class="single-post-image" src="/src/images/<?php echo $post->featured_image ?>" alt="post featured image">
  </div>
  <p class="post-meta">
    <a href="#"><?php echo $post->user_id ?>User</a>
  </p>
  <p>
    <?php echo $post->content ?>
  </p>


</div>
<?php require "comments/comment.php" ?>