    <div class="dashboard">

      <?php require __DIR__ . "/../layout.php"; ?>
      <!-- Main Content -->
      <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
          <div>
            <!-- TODO change toggle onclick online -->
            <button class="menu-toggle">☰</button>
            <h1 id="pageTitle">All users</h1>
          </div>
        </header>
        <!-- Users Section -->
        <section id="users" class="content-section active">
          <div class="section-header">
            <h2>Manage users</h2>
            <a href="/dashboard/users/create" class="btn btn-primary">+ New user</a>
            <?php if (isset($_GET) && isset($_GET["message"])): ?>
              <span class="status-badge btn-success center">
                <?php echo ucfirst(str_replace("-", " ", $_GET["message"])) . "!" ?>
              </span>
            <?php endif ?>
          </div>
          <div class="table-container">
            <table id="usersTable">
              <thead>
                <tr>
                  <th>Avatar</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Last update</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="usersTableBody">
                <?php foreach ($users as $user): ?>
                  <tr>
                    <td style="  
                    padding: 0 0.5rem;
                    aspect-ratio: 1 / 1;
     position: relative;
     width: 50px;
     height: 50px;
  ">
                      <img style="
                      	    width: 50px;
     height: 50px;
     border-radius: 100%;
     position:absolute;
     object-fit: cover;
     left: 50%;
     top: 50%;
     transform: translate(-50%, -60%);"
                        src="/src/images/<?php echo $user->avatar ?>" alt="failed">

                    </td>
                    <td><?php echo $user->username ?></td>
                    <td><?php echo $user->email ?></td>
                    <td><?php echo $user->role ?></td>
                    <td><?php echo $user->updated_at ?? $user->created_at ?></td>
                    <td>
                      <a href="/dashboard/users/edit?id=<?php echo $user->id ?>" class="btn btn-small btn-primary">Edit</a>
                      <form action="/dashboard/users/delete" method="POST">
                        <input type="hidden" value="<?php echo $user->id ?>" name="id">
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