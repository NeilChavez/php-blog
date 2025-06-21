<form method="POST">
  <div class="form-group">
    <label>Category Name</label>
    <input type="text" value="<?php echo $category->name ?? "" ?>" class="form-control" name="name" required>
  </div>
  <div class="form-group">
    <label>Description</label>
    <textarea class="form-control" name="description" rows="3" required>
      <?php echo $category->description ?? "" ?>
    </textarea>
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>