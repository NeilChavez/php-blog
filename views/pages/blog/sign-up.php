<?php if (count($errors) > 0): ?>
  <?php foreach ($errors as $error): ?>
    <div class="status-badge status-inactive center">
      <?php echo $error ?></div>
  <?php endforeach ?>
<?php endif ?>

<div class="container auth-container">
  <div class="auth-card">
    <h2>Register</h2>
    <form id="signupForm" action="/sign-up" method="POST">
      <div class="form-group">
        <label for="newUsername">Username</label>
        <input type="text" id="username" name="username"
          value="<?php echo $user->username ?? "" ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="newEmail">Email</label>
        <input type="text" id="email" name="email" value="<?php echo $user->email ?? "" ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="newPassword">Password</label>
        <input type="password" id="password" name="password"
          value="<?php echo $user->password ?? "" ?>" class="form-control" required>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Create an Account</button>
      </div>
    </form>
    <p>Already have an account? <a href="/login">Login here!</a></p>
  </div>
</div>