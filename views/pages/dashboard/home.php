  <div class="dashboard">

    <?php require "layout.php"; ?>
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
      <!-- Header -->
      <header class="header">
        <div>
          <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
          <h1 id="pageTitle">Dashboard</h1>
        </div>
      </header>
      <!-- Dashboard Section -->
      <section id="dashboard" class="content-section active">
        <?php if ($isAdmin):?>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-number" id="totalPosts">
              <?php echo $data["postCount"] ?>
            </div>
            <div class="stat-label">Total Posts</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="totalCategories">
              <?php echo $data["categoriesCount"] ?> </div>
            <div class="stat-label">Categories</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="totalComments"> <?php echo $data["commentsCount"] ?></div>
            <div class="stat-label">Comments</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="totalUsers">
              <?php echo $data["usersCount"] ?>
            </div>
            <div class="stat-label">Users</div>
          </div>
        </div>
        <?php endif ;?>

        <div class="recent-activity">
          <h3>Recent activity</h3>
          <div class="recent-activity-items">
            <div>
              <?php foreach ($lastsPosts as $post): ?>
                <a href="/post?id=<?php echo $post->id ?>">
                  <div class="activity-item">
                    <div class="activity-icon post">
                      📄
                    </div>
                    <div class="activity-content">
                      <div class="activity-title">New post:</div>
                      <p>
                        "<?php echo $post->title ?>"
                      </p>
                      <div class="activity-time">
                        <?php echo $post->created_at ?>
                      </div>
                    </div>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>
            <div>
              <?php foreach ($lastsComments as $comment): ?>
                <a href="/post?id=<?php echo $comment->post_id . "#" . $comment->id ?>">
                  <div class="activity-item">
                    <div class="activity-icon comment">💬</div>
                    <div class="activity-content">
                      <div class="activity-title">New Comment: </div>
                      <p><?php echo $comment->content ?></p>
                      <div class="activity-time">
                        <?php echo $comment->created_at ?>
                      </div>
                    </div>
                  </div>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>