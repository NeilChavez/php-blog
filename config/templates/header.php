  <header class="header">
    <a href="/home" class="logo">Il Mio Blog</a>
    <div class="header-actions">
      <div id="authButtons">
        <?php if ($isLoggedIn): ?>
          <span style="color: var(--text-primary); margin-right: 10px;">Hello, <?php echo $_SESSION["user"] ?? "user"; ?>!</span>
          <a href="/dashboard" class="btn btn-primary">Dashboard</a>
          <a href="#" class="btn btn-secondary">Logout</a>
        <?php else: ?>
          <a href="/login" class="btn btn-secondary">Login</a>
          <a href="/sign-up" class="btn btn-primary">Registrati</a>
        <?php endif; ?>
      </div>
      <button id="darkModeToggle" class="dark-mode-toggle">💡</button>
    </div>
  </header>