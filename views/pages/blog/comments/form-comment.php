<div class="comment-form">
  <h3>
    <?php
    if (!isset($action)) {
      $action = "create";
    }
    echo $formTitle = match (true) {
      $action === "create" => "Write your comment",
      $action === "update" => "Edit your comment",
      default => "Write your comment"
    };
    ?>
  </h3>
  <form action=<?php
                $str = "/comment/" . $action;
                if ($action === "update") {
                  $str .= "?post_id=" . $post->id . "&comment_id=" . $targetComment->id;
                }
                echo $str

                ?> method="POST" id="form-comment">
    <input type="hidden" name="post_id" value="<?php echo $post->id ?>">
    <input type="hidden" name="user_id" value="<?php
    @session_start();
    if (isset($_SESSION["id"])) {
      echo $_SESSION["id"];
    }
    ?>">
    <div class="form-group">
      <label for="commentText">Your comment</label>
      <textarea id="commentText" class="form-control" name="content" id="comment" rows="5" required>
           <?php echo $targetComment->content ??  ""  ?> 
      </textarea>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Send comment</button>
    </div>
  </form>
</div>