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
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-number" id="totalPosts">12</div>
            <div class="stat-label">Total Posts</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="totalCategories">5</div>
            <div class="stat-label">Categories</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="totalComments">48</div>
            <div class="stat-label">Comments</div>
          </div>
          <div class="stat-card">
            <div class="stat-number" id="totalUsers">23</div>
            <div class="stat-label">Users</div>
          </div>
        </div>

        <div class="recent-activity">
          <h3>Recent activity</h3>
          <div id="recentActivity">
            <div class="activity-item">
              <div class="activity-icon post">📄</div>
              <div class="activity-content">
                <div class="activity-title">Nuovo post pubblicato: "Guida al CSS Grid"</div>
                <div class="activity-time">2 ore fa</div>
              </div>
            </div>
            <div class="activity-item">
              <div class="activity-icon comment">💬</div>
              <div class="activity-content">
                <div class="activity-title">Nuovo commento da Mario Rossi</div>
                <div class="activity-time">4 ore fa</div>
              </div>
            </div>
            <div class="activity-item">
              <div class="activity-icon user">👤</div>
              <div class="activity-content">
                <div class="activity-title">Nuovo utente registrato: giulia.verdi@email.com</div>
                <div class="activity-time">1 giorno fa</div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>