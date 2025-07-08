        <div class="categories-list">
          <h3>Categories</h3>
          <ul id="categoriesList">
            <?php foreach ($categories as $category): ?>
              <li>
                <a href="/categories?id=<?php echo $category->id ?>&category=<?php echo $category->name ?>"><?php echo $category->name ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>