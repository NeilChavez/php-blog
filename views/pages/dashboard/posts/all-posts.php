  <div class="dashboard">
    <?php require __DIR__ . "/../layout.php"; ?>
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
      <!-- Header -->
      <header class="header">
        <div>
          <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
          <h1 id="pageTitle">The posts</h1>
        </div>
      </header>
      <!-- Posts Section -->
      <section id="posts" class="content-section active">
        <div class="section-header">
          <h2>Manage Posts</h2>
          <a href="/dashboard/posts/create" class="btn btn-primary">+ New Post</a>
          <?php if (isset($_GET) && isset($_GET["message"])): ?>
            <span class="status-badge btn-success center">
              <?php echo ucfirst(str_replace("-", " ", $_GET["message"])) . "!" ?>
            </span>
          <?php endif ?>
        </div>
        <div class="table-container">
          <table id="postsTable">
            <thead>
              <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Status</th>
                <th>Last Update</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="postsTableBody">
              <?php foreach ($posts as $post): ?>
                <tr>
                  <td>
                    <img style="width: 50px; height: 50px; object-fit:contain" src="/src/images/<?php echo $post->featured_image ?>" alt="failed">
                  </td>
                  <td>
                    <b>
                      <?php echo $post->title ?>
                    </b>
                  </td>
                  <td>
                    <span class="status-badge status-<?php echo $post->status ?>">
                      <?php echo $post->status ?>
                    </span>
                  </td>
                  <td><?php echo $post->updated_at ?? $post->created_at ?></td>
                  <td>
                    <a href="/dashboard/posts/edit?id=<?php echo $post->id ?>" class="btn btn-small btn-primary">Edit</a>
                    <a href="/dashboard/posts/delete?id=<?php echo $post->id ?>" class="btn btn-small btn-danger">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
      </section>