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
      <label>Title</label>
      <input type="text" id="title" name="title" value="<?php echo $post->title ?? ""; ?>" class="form-control" required>
    </div>
    <div class="form-group">
      <?php if (isset($post->featured_image)): ?>
        <img style="width: 300px; height: 150px; object-fit:contain" src="/src/images/<?php echo $post->featured_image ?>" alt="image in form">
        <br>
        <input type="hidden" name="featured_image" id="featured_image" value="<?php echo $post->featured_image ?>">
        <br>
        <div>Want to change image? Upload a new one:</div>
      <?php endif ?>
      <input type="file" name="file">
    </div>

    <div class="form-group">
      <label>Content</label>
      <textarea class="form-control" name="content" rows="5" required>
        <?php
        echo $post->content ?? "";
        ?>
    </textarea>
    </div>
    <div class="form-group">
      <label>Choose the categories:</label>
      <div class="d-flex gap">
        <?php foreach ($categories as $category): ?>
          <label for="<?php echo $category->id ?>">
            <?php echo $category->name ?>
            <input type="hidden" name="categories[]" value="0">
            <input type="checkbox" name="categories[]" id="<?php echo $category->id ?>" value="<?php echo $category->id ?>"
              <?php echo in_array($category->id, $post->categories) ? "checked" : ""; ?>>
          </label>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="form-group">
      <label>Status</label>
      <select class="form-control" name="status" required>
        <option disabled>--Please choose an option--</option>
        <option value="draft" <?php
                              if ($post->status === "draft"): ?>
          selected
          <?php endif  ?>>Draft</option>
        <option value="published" <?php
                                  if ($post->status === "published"): ?>
          selected
          <?php endif  ?>>Published</option>
      </select>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </form>