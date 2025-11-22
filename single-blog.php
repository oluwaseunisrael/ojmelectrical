<?php
include('include/header.php');
include('config/conn.php');

// Fetch the blog post details by ID
$blog_id = $_GET['id']; // Blog ID passed via query string
$query = "
    SELECT b.id, b.title, b.image, b.content, b.post_category, t.name as tag_name, b.created_at 
    FROM blogposts b 
    LEFT JOIN tags t ON b.post_tags = t.id 
    WHERE b.id = '$blog_id'";
$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);

// Fetch comments for this blog post
$comments_query = "SELECT * FROM comments WHERE blog_id = '$blog_id' ORDER BY created_at DESC";
$comments_result = mysqli_query($conn, $comments_query);
?>
<div class="blog-header" style="
    position: relative; 
    background: url('uploads/<?php echo htmlspecialchars($post['image']); ?>') no-repeat center center; 
    background-size: cover; 
    min-height: 500px; 
    border-radius: 0px!important;
    background-position: top center;
    display: flex; 
    align-items: center; 
    justify-content: center; 
    color: white;">
  
  <!-- Overlay -->
  <div style="
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Dark overlay */
      z-index: 1;
      border-radius: inherit;"></div>

  <!-- Blog Title -->
  <h1 style="position: relative; z-index: 2; margin: 0 6%; display: flex;!important justify-content: center!important; align-items: center!important;"><?php echo htmlspecialchars($post['title']); ?></h1>
</div>


<div class="blog-single-post">
  <!-- Main Content -->
  <div class="blog-single-post-one">
    <div class="blog-single-post-img">
      <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Blog Image" style="width: 100%; height: 500px; object-fit: cover;">
      <div class="post-date">
        <span><?php echo date('d M, Y', strtotime($post['created_at'])); ?></span>
      </div>
    </div>
    <div class="blog-single-post-comment">
      <span><i class="bi bi-person"></i> Admin</span>
      <span><i class="bi bi-chat-dots"></i> <?php echo mysqli_num_rows($comments_result); ?> Comments</span>
    </div>
    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

    <hr>

    <!-- Tags and Social Share -->
    <div class="blog-single-post-tag">
      <div class="blog-single-post-tag-one">
        <span>Tags: </span>
        <span class="span"><?php echo htmlspecialchars($post['tag_name']); ?></span>
      </div>
      <div class="blog-single-post-tag-two">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode("http://yourwebsite.com/blog.php?id=" . $post['id']); ?>" target="_blank">
          <i class="bi bi-facebook"></i>
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode("http://yourwebsite.com/blog.php?id=" . $post['id']); ?>" target="_blank">
          <i class="bi bi-twitter"></i>
        </a>
        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode("http://yourwebsite.com/blog.php?id=" . $post['id']); ?>" target="_blank">
          <i class="bi bi-whatsapp"></i>
        </a>
        <a href="https://www.linkedin.com/shareArticle?url=<?php echo urlencode("http://yourwebsite.com/blog.php?id=" . $post['id']); ?>" target="_blank">
          <i class="bi bi-linkedin"></i>
        </a>
      </div>
    </div>

    <!-- Comments Section -->
    <h3><?php echo mysqli_num_rows($comments_result); ?> Comments</h3>
    <div class="comment-box">
      <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
      <div class="comment-main">
        <div class="comment-main-content" style="">
          <div class="comment-main-one" style="display: grid!important; gap:0;">
            <h2><?php echo htmlspecialchars($comment['name']); ?></h2>
            <span><?php echo date('d M, Y', strtotime($comment['created_at'])); ?></span>
          </div>
          <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
        </div>
      </div>
      <?php endwhile; ?>
    </div>

    <!-- Comment Form -->
    <div class="container-fluid mt-5 containers">
      <h3 class="text-center mb-4">Leave a Comment</h3>
      <form action="add-comment.php" method="POST">
        <input type="hidden" name="blog_id" value="<?php echo $post['id']; ?>">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="nameInput" class="form-label">Enter Name</label>
            <input type="text" class="form-control" id="nameInput" name="name" placeholder="Your Name" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="emailInput" class="form-label">Enter Email</label>
            <input type="email" class="form-control" id="emailInput" name="email" placeholder="Your Email" required>
          </div>
        </div>
        <div class="mb-3">
          <label for="messageInput" class="form-label">Enter Message</label>
          <textarea class="form-control" id="messageInput" name="content" rows="5" placeholder="Write your comment here..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100 submit-btn">Submit Comment</button>
      </form>
    </div>
  </div>


  <!-- Sidebar with Latest Posts -->
  <div class="blog-single-post-two">
    <div class="container">
  <!-- Modern Search Bar -->
  
</div>

    <?php
include('config/conn.php');

// Fetch the latest 3 blog posts
$query = "
    SELECT b.id, b.title, b.image, b.created_at, t.name AS tag_name 
    FROM blogposts b 
    LEFT JOIN tags t ON b.post_tags = t.id 
    ORDER BY b.created_at DESC 
    LIMIT 3";  // This LIMIT ensures only 3 posts are fetched
$result = mysqli_query($conn, $query);
?>

<div class="blog-single-post-latest">
  <h3>Latest Posts</h3>
  
  <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="blog-single-post-latest-box">
      <div class="blog-single-post-latest-img">
        <!-- Blog image with dynamic source -->
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Latest Post Image" style="width: 100%; height: 150px; object-fit: cover;">
      </div>
      <div class="blog-single-post-latest-content">
        <!-- Blog metadata: Author (Admin), Blog Title -->
        <span><i class="bi bi-person"></i> Admin</span>
        <p>
          <!-- Link to view the full blog post -->
          <a href="single-blog.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['title']); ?>">
    <?php echo htmlspecialchars($row['title']); ?>
</a>

        </p>
      </div>
    </div>
  <?php endwhile; ?>
</div>

  <?php
include('config/conn.php');

// Query to get all categories and the number of blog posts in each category
$query = "
    SELECT c.id AS category_id, c.name AS category_name, 
           IFNULL(COUNT(b.id), 0) AS post_count
    FROM categories c
    LEFT JOIN blogposts b ON b.post_category = c.id
    GROUP BY c.id
    ORDER BY c.name ASC"; // Order categories alphabetically

$result = mysqli_query($conn, $query);
?>

<div class="container mt-5 container-fluids">
  <h3 class="text-center mb-4">Categories</h3>
  <ul class="list-group categories-list">
    
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="blog-category.php?category_id=<?php echo $row['category_id']; ?>" class="text-decoration-none">
          <?php echo htmlspecialchars($row['category_name']); ?>
        </a>
        <span class="badge rounded-pill"><?php echo $row['post_count']; ?></span>
      </li>
    <?php endwhile; ?>
    
  </ul>
</div>

<?php
include('config/conn.php');

// Query to get tags and the number of blog posts associated with each tag
$query = "
    SELECT t.name AS tag_name, COUNT(b.id) AS post_count
    FROM tags t
    LEFT JOIN blogposts b ON FIND_IN_SET(t.id, b.post_tags)
    GROUP BY t.name
    ORDER BY t.name ASC"; // Order tags alphabetically
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5 container-fluids">
  <h3 class="text-center mb-4">Tags</h3>
  <div class="tags-container gap-3">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <a href="tag.php?tag=<?php echo urlencode($row['tag_name']); ?>" class="tag-link">
        <?php echo htmlspecialchars($row['tag_name']); ?> (<?php echo $row['post_count']; ?>)
      </a>
    <?php endwhile; ?>
  </div>
</div>

<?php
include('config/conn.php');

// Query to get the latest 5 comments
$query = "
    SELECT c.id, c.name, c.content, b.title AS blog_title, b.id AS blog_id
    FROM comments c
    LEFT JOIN blogposts b ON c.blog_id = b.id
    ORDER BY c.created_at DESC
    LIMIT 5";
$result = mysqli_query($conn, $query);
?>

<div class="beautiful-recent-comments container my-5">
  <h3 class="beautiful-comments-title">Recent Comments</h3>

  <?php while ($row = mysqli_fetch_assoc($result)): ?>
  <div class="beautiful-comment-item">
    <div class="beautiful-comment-icon">
      <i class="bi bi-chat-dots-fill"></i>
    </div>
    <div class="beautiful-comment-content">
      <h4 class="comment-author"><?php echo htmlspecialchars($row['name']); ?></h4>
      <p>on <a href="single-blog.php?id=<?php echo $row['blog_id']; ?>&title=<?php echo urlencode($row['blog_title']); ?>" class="comment-link">
    <?php echo htmlspecialchars($row['blog_title']); ?>
</a></p>

    </div>
  </div>
  <?php endwhile; ?>
</div>


  </div>

</div>


<?php
include('include/footer.php');
?>