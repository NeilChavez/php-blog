    <section class="hero-section featured">
      <div class="hero-posts-grid" id="heroPostsGrid">
        <?php
        foreach ($featuredPosts as $post): ?>
          <?php require "cardPost.php"; ?>
        <?php endforeach; ?>
      </div>
    </section>