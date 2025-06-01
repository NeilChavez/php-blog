 <h1>Single post page</h1>
 <div>
   <article>
     <h2>
       <a href="/post?id=<?php echo $post->id ?>">
         <?php echo $post->title ?>
       </a>
     </h2>
     <div>id: <?php echo $post->id ?></div>
     <div><?php echo $post->slug ?></div>
     <div><?php echo $post->featured_image ?></div>
     <div><?php echo $post->content ?></div>
     <div><?php echo $post->status ?></div>
     <div><?php echo $post->created_at ?></div>
     <div><?php echo $post->updated_at ?></div>
     <div>Writted by: <span><?php echo $post->user_id ?></span>
     </div>
   </article>
 </div>