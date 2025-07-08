  <header class="header">
    <a href="/home" class="logo"><?php echo TITLE_SITE ?></a>
    <div class="header-actions">
      <div id="authButtons">
        <?php if ($isLoggedIn): ?>
          <span style="color: var(--text-primary); margin-right: 10px;">Hello, <?php echo $_SESSION["user"] ?? "user"; ?>!</span>
          <a href="/dashboard" class="btn btn-primary">Dashboard</a>
          <a href="/logout" class="btn btn-secondary">Logout</a>
        <?php else: ?>
          <a href="/login" class="btn btn-secondary">Login</a>
          <a href="/sign-up" class="btn btn-primary">Sign up</a>
        <?php endif; ?>
      </div>
    </div>
  </header>