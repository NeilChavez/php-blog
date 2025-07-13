<?php if (count($errors) > 0): ?>
  <?php foreach ($errors as $error): ?>
    <div class="status-badge status-inactive center">
      <?php echo $error ?></div>
  <?php endforeach ?>
<?php endif ?>

<div class="container auth-container">
  <div class="auth-card">
    <h2>Login</h2>
    <form id="loginForm" method="POST">
      <div class="form-group">
        <label for="username">Your email</label>
        <input class="form-control"
          type="email" id="email" name="email" value="<?php echo $user->email ?? "" ?>">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control"
          type="password" id="password" name="password" value="<?php echo $user->password ?? "" ?>" required>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>
    <p>Not register yet? <a href="/sign-up">Sign up!</a></p>
  </div>
</div>