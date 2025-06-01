<section>

  <h1>Update your post</h1>
  <?php
  if (count($errors) > 0) {
    foreach ($errors as $error) {
  ?>
      <div style="border: 5px solid red; width: fit-content;"> <?php echo $error ?>!</div>
  <?php
    }
  }
  ?>
  <form enctype="multipart/form-data" method="post">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" value="<?php
                                                      echo $post->title ?? "";
                                                      ?>"><br><br>

    <?php if (isset($post->featured_image)): ?>
      <img style="width: 300px; height: 150px; object-fit:contain" src="/src/images/<?php echo $post->featured_image ?>" alt="image in form">
      <br>
      <input type="hidden" name="featured_image" id="featured_image" value="<?php echo $post->featured_image ?>">
      <br>
      <div>Want to change image? Upload a new one:</div>
    <?php endif ?>
    <input type="file" name="file">
    <br> <br>
    <div>
      <label for="content">Content:</label>
    </div>
    <textarea id="content" name="content" rows="5" cols="30">
    <?php
    echo $post->content ?? "";
    ?>
    </textarea><br><br>
    <br> <br>
    <select name="status" id="status">
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
    <br> <br>
    <input type="submit" value="Submit">
  </form>

</section>