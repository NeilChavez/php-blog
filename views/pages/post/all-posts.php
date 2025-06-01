<li>List all posts</li>

<?php
foreach ($posts as $post) {
?>
  <ul>
    <div>
      <article style="border: solid 4px black;">
        <h2>
          <a href="/post?id=<?php echo $post->id ?>">
            <?php echo $post->title ?>
          </a>
        </h2>
        <div>
          <a href="/posts/delete?id=<?php echo $post->id ?>">
            X 
          </a>
        </div>
        <div>id: <?php echo $post->id ?></div>
        <div><?php echo $post->slug ?></div>
        <!-- <img src="/src/images/<?php echo $post->featured_image ?>"> -->
        <?php
        if (str_starts_with($post->featured_image, "https")): ?>
          <img style="max-width: 200px; max-height: auto;" src="<?php echo $post->featured_image ?>">
        <?php else : ?>
          <img style="max-width: 200px; max-height: auto;" src="/src/images/<?php echo $post->featured_image ?>">
        <?php endif ?>
        <div><?php echo $post->featured_image ?></div>
        <div><?php echo $post->content ?></div>
        <div><?php echo $post->status ?></div>
        <div><?php echo $post->created_at ?></div>
        <div><?php echo $post->updated_at ?></div>
        <div>Writted by: <span><?php echo $post->user_id ?></span>
        </div>
        <a href="/post/edit?id=<?php echo $post->id ?>">Edit Article</a>
      </article>
    </div>
  </ul>
<?php } ?>