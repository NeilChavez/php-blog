  <?php
  if (count($errors) > 0) {
    foreach ($errors as $error) {
  ?>
      <div style="border: 5px solid red; width: fit-content;"> <?php echo $error ?>!</div>
  <?php
    }
  }
  ?>
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <?php if (isset($user->avatar)): ?>
        <img style="width: 300px; height: 150px; object-fit:contain" src="/src/images/<?php echo $user->avatar ?>" alt="<?php echo $user->username ?>">
        <br>
        <input type="hidden" name="avatar" id="avatar" value="<?php echo $user->avatar ?>">
        <br>
        <div>Want to change image? Upload a new one:</div>
      <?php endif ?>
      <input type="file" name="file">
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?php echo $user->username ?? ""; ?>" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required value="<?php echo $user->email ?? "" ?>" class="form-control">
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required value="<?php echo $user->password ?? "" ?>" class="form-control">
      </div>
    </div>

    <div class="form-group">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </form>