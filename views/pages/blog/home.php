  <div class="container">
    <?php require "../config/templates/hero.php"; ?>
  </div>

  <div class="container">
    <h1>Ultimi Post</h1>
    <div class="blog-layout">
      <main class="blog-main-content">
        <?php require "../config/templates/postList.php"; ?>
      </main>
      <aside class="blog-sidebar">
        <?php require "../config/templates/asideCategories.php"; ?>
      </aside>
    </div>
  </div>