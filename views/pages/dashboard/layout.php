   <?php
    $isAdmin = false;
    $isAuthor = false;
    $isSubscriber = false;
    match ($_SESSION["role"]) {
      "admin" => $isAdmin = true,
      "author" => $isAuthor = true,
      "subscriber" => $isSubcriber = true
    }
    ?>
   <!-- Sidebar -->
   <nav class="sidebar" id="sidebar">
     <div class="sidebar-header">
       <h3>Role: <bold>
           <?php echo strtoupper($_SESSION["role"]); ?>
         </bold>
       </h3>
     </div>
     <div class="sidebar-nav">
       <a href="/dashboard" class="nav-item" data-section="dashboard">
         <i>📊</i> Dashboard
       </a>
       <?php if ($isAdmin || $isAuthor): ?>
         <a href="/dashboard/posts" class="nav-item" data-section="posts">
           <i>📄</i> Posts
         </a>
       <?php endif; ?>
       <a href="/dashboard/comments" class="nav-item" data-section="comments">
         <i>💬</i> Comments
       </a>
       <?php if ($isAdmin): ?>
         <a href="/dashboard/users" class="nav-item" data-section="users">
           <i>👥</i> Users
         </a>
         <a href="/dashboard/categories" class="nav-item" data-section="categories">
           <i>📁</i> Categories
         </a>
       <?php endif; ?>
     </div>
   </nav>
   <div id="dashboardOverlay" class="dashboard-overlay"></div>