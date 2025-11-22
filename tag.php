<?php
include('include/header.php');
include "config/conn.php";

// Define the number of blogs per page
$blogsPerPage = 10;

// Get the tag name from the URL
$tagName = isset($_GET['tag']) ? trim($_GET['tag']) : '';
if (empty($tagName)) {
    echo "<p>Invalid tag.</p>";
    include('include/footer.php');
    exit();
}

// Check if the tag exists in the database
$tagQuery = "SELECT id FROM tags WHERE name = ?";
$stmt = $conn->prepare($tagQuery);
$stmt->bind_param("s", $tagName);
$stmt->execute();
$tagResult = $stmt->get_result();
if ($tagResult->num_rows == 0) {
    echo "<p>Tag not found.</p>";
    include('include/footer.php');
    exit();
}

// Get the tag ID for further queries
$tag = $tagResult->fetch_assoc();
$tagId = $tag['id'];

// Pagination setup
$blogsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page <= 0) $page = 1;

$offset = ($page - 1) * $blogsPerPage;

// Query to fetch the total number of blogs for this tag
$totalBlogsQuery = "SELECT COUNT(*) AS total FROM blogposts WHERE FIND_IN_SET(?, post_tags)";
$stmt = $conn->prepare($totalBlogsQuery);
$stmt->bind_param("i", $tagId);
$stmt->execute();
$totalBlogsResult = $stmt->get_result();
$totalBlogsRow = $totalBlogsResult->fetch_assoc();
$totalBlogs = $totalBlogsRow['total'];

// Query to fetch blog posts associated with this tag for pagination
$blogsQuery = "
    SELECT b.id, b.title, b.image, b.content, b.created_at,
           (SELECT COUNT(*) FROM comments c WHERE c.blog_id = b.id) AS comment_count
    FROM blogposts b
    WHERE FIND_IN_SET(?, b.post_tags)
    ORDER BY b.created_at DESC
    LIMIT ? OFFSET ?";
$stmt = $conn->prepare($blogsQuery);
$stmt->bind_param("iii", $tagId, $blogsPerPage, $offset);
$stmt->execute();
$blogsResult = $stmt->get_result();

// Calculate the total number of pages
$totalPages = ceil($totalBlogs / $blogsPerPage);
?>

<div class="blog-header" style="position: relative; background: url('img/header-img2.png') no-repeat center center; background-size: cover; min-height: 500px; border-radius: 0px!important; background-position: top center; display: flex; align-items: center; justify-content: center; color: white;">
  <!-- Overlay -->
  <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1; border-radius: inherit;"></div>

  <!-- Blog Title -->
  <h1 style="position: relative; z-index: 2; margin: 0 2%"><?php echo htmlspecialchars($tagName); ?></h1>
</div>

<div class="blog-grid-main" style="margin-top:80px">
    <div class="blog-grid">
        <?php if ($blogsResult->num_rows > 0): ?>
            <?php while ($blog = $blogsResult->fetch_assoc()): ?>
                <div class="blog-card">
                    <div class="position-relative">
                        <img src="uploads/<?php echo htmlspecialchars($blog['image']); ?>" alt="Blog Image" style="width: 100%; height: 300px; object-fit: cover;">
                        <span class="blog-date"><?php echo date('d M, Y', strtotime($blog['created_at'])); ?></span>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span>By admin | Tag: <?php echo htmlspecialchars($tagName); ?></span>
                            <div class="comments">
                                <i class="bi bi-chat-left-text"></i>
                                <span><?php echo $blog['comment_count']; ?></span>
                            </div>
                        </div>
                        <h3 class="blog-title" style="border-bottom: none!important;"><?php echo htmlspecialchars($blog['title']); ?></h3>
                        <a href="single-blog.php?id=<?php echo $blog['id']; ?>" class="read-more">
                            READ MORE <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No blogs available for this tag.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Pagination -->
<div class="modern-pagination-container d-flex justify-content-center mt-5">
    <ul class="modern-pagination">
        <?php if ($page > 1): ?>
        <li><a href="?tag=<?php echo urlencode($tagName); ?>&page=<?php echo $page - 1; ?>"><i class="bi bi-chevron-left"></i></a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li><a href="?tag=<?php echo urlencode($tagName); ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
        <li><a href="?tag=<?php echo urlencode($tagName); ?>&page=<?php echo $page + 1; ?>"><i class="bi bi-chevron-right"></i></a></li>
        <?php endif; ?>
    </ul>
</div>

<?php include('include/footer.php'); ?>
