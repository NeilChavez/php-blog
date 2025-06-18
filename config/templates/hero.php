    <section class="hero-section featured">
      <div class="hero-posts-grid" id="heroPostsGrid">
        <!-- Hero posts will be loaded here by JavaScript -->

        <?php
        $count = array_fill(0, 3, "a");
        foreach ($count as $value): ?>
          <?php require "cardPost.php"; ?>
        <?php endforeach; ?>
      </div>
    </section>