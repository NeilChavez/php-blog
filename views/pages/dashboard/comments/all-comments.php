    <div class="dashboard">

      <?php require __DIR__ . "/../layout.php"; ?>
      <!-- Main Content -->
      <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
          <div>
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            <h1 id="pageTitle">Dashboard</h1>
          </div>
        </header>
        <!-- Comments Section -->
        <section id="comments" class="content-section active">
          <div class="section-header">
            <h2>Manage Comments</h2>
            <div>

              <a href="/dashboard/comments/to-approve" class="btn btn-primary">Show comments to approve</a>
              <a href="/dashboard/comments" class="btn btn-primary">Show all comments</a>
            </div>
          </div>
          <div class="table-container">
            <table id="commentsTable">
              <thead>
                <tr>
                  <th>Author</th>
                  <th>Post</th>
                  <th>Comment</th>
                  <th>Status</th>
                  <th>Data</th>
                  <th>Azioni</th>
                </tr>
              </thead>
              <?php if (count($comments) > 0): ?>
                <tbody id="commentsTableBody">
                  <?php foreach ($comments as $comment): ?>
                    <tr>
                      <td><?php echo $comment->user_id ?></td>
                      <td><?php echo $comment->post_id ?></td>
                      <td><?php echo $comment->content ?> </td>
                      <td><span class="status-badge status-<?php echo $comment->status ?>">
                          <?php echo $comment->status === 'published' ? 'Approved' : 'To approve' ?></span></td>
                      <td>
                        <?php echo $comment->updated_at ?? $comment->created_at ?>
                      </td>
                      <td>
                        <form action="/dashboard/comment/approve" method="POST">
                          <input type="hidden" value="<?php echo $comment->id ?>" name="comment_id">
                          <button class="btn btn-small btn-success ">Approve</button>
                        </form>
                        <form action="/dashboard/comment/delete" method="POST">
                          <input type="hidden" value="<?php echo $comment->id ?>" name="comment_id">
                          <button class="btn btn-small btn-danger ">Approve</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              <?php endif; ?>

            </table>
            <?php if (count($comments) === 0): ?>
              <div class="text-center padding-top">
                <b class="center">There are no comments to see</b>
            </div>
            <?php endif ?>
          </div>
        </section>
      </main>
    </div>