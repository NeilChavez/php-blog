  <div class="dashboard">
    <?php require __DIR__ . "/../layout.php"; ?>
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
      <!-- Header -->
      <header class="header">
        <div>
          <button class="menu-toggle">☰</button>
          <h1 id="pageTitle">The categories</h1>
        </div>
      </header>
      <!-- Categories Section -->
      <section id="categories" class="content-section active">
        <div class="section-header">
          <h2>Manage categories</h2>
          <a href="/dashboard/category/create" class="btn btn-primary">+ New Category</a>
        </div>
        <div class="table-container">
          <table id="categoriesTable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="categoriesTableBody">
              <?php foreach ($categories as $category): ?>
                <tr>
                  <td><?php echo $category->name ?></td>
                  <td><?php echo $category->description ?></td>
                  <td>
                    <a href="/dashboard/category/update?id=<?php echo $category->id ?>" class="btn btn-small btn-primary">Edit</a>
                    <form action="/dashboard/category/delete" method="POST">
                      <input type="hidden" name="id" value="<?php echo $category->id ?>">
                      <button class="btn btn-small btn-danger">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>