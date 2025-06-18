    <div class="dashboard">

      <?php require "sidebar.php"; ?>
      <!-- Main Content -->
      <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
          <div>
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            <h1 id="pageTitle">Dashboard</h1>
          </div>
        </header>


        <!-- Users Section -->
        <section id="users" class="content-section active">
          <div class="section-header">
            <h2>Gestione Utenti</h2>
            <button class="btn btn-primary" onclick="showAddModal('user')">+ Nuovo Utente</button>
          </div>
          <div class="table-container">


            <table id="usersTable">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Ruolo</th>
                  <th>Status</th>
                  <th>Data Registrazione</th>
                  <th>Azioni</th>
                </tr>
              </thead>
              <tbody id="usersTableBody">

                <tr>

                  <td>${post.title}</td>
                  <td>${post.category}</td>
                  <td>${post.author}</td>
                  <td><span class="status-badge status-${post.status}">${post.status === 'published' ? 'Pubblicato' : 'Bozza'}</span></td>
                  <td>${formatDate(post.date)}</td>
                  <td>
                    <button class="btn btn-small btn-primary">Modifica</button>
                    <button class="btn btn-small btn-danger">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

      </main>
    </div>