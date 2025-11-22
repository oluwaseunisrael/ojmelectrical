<?php
include('include/header.php');
include "config/conn.php";

// Define the number of blogs per page
$blogsPerPage = 10;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page <= 0) $page = 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $blogsPerPage;

// Get the total number of blogs
$totalBlogsQuery = "SELECT COUNT(*) AS total FROM blogposts";
$totalBlogsResult = mysqli_query($conn, $totalBlogsQuery);
$totalBlogsRow = mysqli_fetch_assoc($totalBlogsResult);
$totalBlogs = $totalBlogsRow['total'];

// Fetch the blogs for the current page
$query = "
    SELECT b.id, b.title, b.image, b.content, b.post_category, t.name as tag_name, b.created_at,
           (SELECT COUNT(*) FROM comments c WHERE c.blog_id = b.id) AS comment_count
    FROM blogposts b
    LEFT JOIN tags t ON b.post_tags = t.id
    ORDER BY b.id DESC 
    LIMIT $blogsPerPage OFFSET $offset";
$result = mysqli_query($conn, $query);

// Calculate total pages
$totalPages = ceil($totalBlogs / $blogsPerPage);
?>

<div class="blog-header" style="
    position: relative; 
    background: url('img/online-blog.jpg') no-repeat center center; 
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
  <h1 style="position: relative; z-index: 2; margin: 0 2%">Our Latest Blog</h1>
</div>

<div class="blog-grid-main" style="margin-top:80px">
    <?php if ($totalBlogs > 0): ?>
        <div class="blog-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <!-- Blog Post -->
            <div class="blog-card">
                <div class="position-relative">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                         alt="Blog Image" 
                         style="width: 100%; height: 300px; object-fit: cover;">
                    <span class="blog-date"><?php echo date('d M, Y', strtotime($row['created_at'])); ?></span>
                </div>
                <div class="blog-content">
                    <div class="blog-meta">
                        <span>By admin | <?php echo htmlspecialchars($row['tag_name']); ?></span>
                        <div class="comments">
                            <i class="bi bi-chat-left-text"></i>
                            <span><?php echo $row['comment_count']; ?></span>
                        </div>
                    </div>
                    <h3 class="blog-title" style="border-bottom: none!important;"> <?php echo htmlspecialchars($row['title']); ?></h3>
                    <a href="single-blog.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['title']); ?>" class="read-more">
                        READ MORE <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <!-- Message if no blogs are available -->
        <div class="no-blogs text-center">
            <h3>No blogs available at the moment. Please check back later!</h3>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<?php if ($totalBlogs > 0): ?>
<div class="modern-pagination-container d-flex justify-content-center mt-5">
    <ul class="modern-pagination">
        <?php if ($page > 1): ?>
        <li><a href="?page=<?php echo $page - 1; ?>"><i class="bi bi-chevron-left"></i></a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li><a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
        <li><a href="?page=<?php echo $page + 1; ?>"><i class="bi bi-chevron-right"></i></a></li>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?>

<?php include('include/footer.php'); ?>
