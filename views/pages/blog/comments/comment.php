<div class="comments-section container">
  <?php if (count($post->comments) > 0): ?>
    <h3>Comments (<span id="commentsCount"><?php echo count($post->comments) ?></span>)</h3>
  <?php else: ?>
    <h3>Comments (<span id="commentsCount">0</span>)</h3>
  <?php endif ?>
  <?php if (isset($_GET) && isset($_GET["message"])): ?>
    <div class="status-badge btn-success center" id="success-badge">
      <?php echo ucfirst(str_replace("-", " ", $_GET["message"])) . "!" ?>
    </div>
  <?php endif ?>
  <div id="commentsList">
    <?php foreach ($post->comments as $comment): ?>
      <div class="comment-item" id="<?php echo $comment->id ?>">
        <?php if (isset($_SESSION["id"]) &&  $comment->user_id === $_SESSION["id"]): ?>
          <div class="d-flex gap">
            <a href="/comment/update?comment_id=<?php echo $comment->id ?>&post_id=<?php echo $post->id ?>#form-comment" class="btn btn-small btn-warning">Edit</a>
            <form action="/comment/delete" method="POST">
              <input type="hidden" name="post_id" value="<?php echo $post->id ?>">
              <input type="hidden" name="comment_id" value="<?php echo $comment->id ?>">
              <button class="btn btn-small btn-danger">Delete</button>
            </form>
          </div>
        <?php endif; ?>

        <p>
          <span class="comment-author">
            <?php echo $comment->username ?>
          </span>
          <span class="comment-date">
            <?php echo $comment->created_at ?? $comment->updated_at ?>
          </span>
        </p>
        <p class="comment-text"><?php echo $comment->content ?></p>

      </div>
    <?php endforeach ?>
  </div>
  <?php require "form-comment.php"; ?>
</div>