  <div class="dashboard">
    <?php require __DIR__ . "/../layout.php"; ?>
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
      <!-- Header -->
      <header class="header">
        <div>
          <!-- TODO pass to JS file this inline function -->
          <button class="menu-toggle">☰</button>
          <h1 id="pageTitle">Update post</h1>
        </div>
      </header>
      <?php require "form.php"; ?>
    </main>
  </div>