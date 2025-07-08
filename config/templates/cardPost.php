
      <div class="post-card">
        <div class="post-image-container">
          <img src="/src/images/<?php echo $post->featured_image?>" alt="featured image" class="post-card-image">
        </div>
        <div class="">
          <h2><a href="/post?id=<?php echo $post->id?>"><?php echo $post->title ?></a></h2>
          <p class="post-meta">
            <a href="">User</a> In <a href="#">category</a> <?php echo $post->updated_at ?? $post->created_at ?>
          </p>
          <p class="post-excerpt"></p>
          <a href="/post?id=<?php echo $post->id ?>" class="btn btn-secondary btn-small">Read More</a>
        </div>
      </div>