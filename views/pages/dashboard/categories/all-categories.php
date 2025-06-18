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
      <!-- Categories Section -->
      <section id="categories" class="content-section active">
        <div class="section-header">
          <h2>Gestione Categorie</h2>
          <a href="/dashboard/category/create" class="btn btn-primary">+ Nuova Categoria</a>
        </div>
        <div class="table-container">
          <table id="categoriesTable">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Azioni</th>
              </tr>
            </thead>
            <tbody id="categoriesTableBody">
              <?php foreach ($categories as $category): ?>
                <tr>
                  <td><?php echo $category->name ?></td>
                  <td><?php echo $category->description ?></td>
                  <td>
                    <a href="/dashboard/category/update?id=9" class="btn btn-small btn-primary">Edit</a>
                    <a href="/dashboard/category/delete?id=9" class="btn btn-small btn-danger">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>

    </main>
  </div>