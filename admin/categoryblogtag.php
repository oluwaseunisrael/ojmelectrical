<?php 
session_start(); 
include('includes/header.php');
include "../config/conn.php";

// Fetch categories and tags
$categories_sql = "SELECT * FROM categories";
$categories_result = mysqli_query($conn, $categories_sql);

$tags_sql = "SELECT * FROM tags";
$tags_result = mysqli_query($conn, $tags_sql);
?>

<div class="container mt-5">
    <!-- Tags Section -->
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="tagsHeading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tagsSection" aria-expanded="true" aria-controls="tagsSection">
                    Tags
                </button>
            </h2>
            <div id="tagsSection" class="accordion-collapse collapse show" aria-labelledby="tagsHeading" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-primary">Manage Tags</h4>
                        <a href="add-tags.php" class="btn btn-success">Add Tag</a>
                    </div>
                    <?php if (isset($_SESSION['tags_status'])): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?php 
                                echo $_SESSION['tags_status']; 
                                unset($_SESSION['tags_status']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <table class="table table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($tags_result)): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <a href="edit-tag.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="delete-tag.php?id=<?php echo $row['id']; ?>" 
                                           onclick="return confirm('Are you sure you want to delete this tag?');" 
                                           class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="accordion-item mt-4">
            <h2 class="accordion-header" id="categoriesHeading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#categoriesSection" aria-expanded="false" aria-controls="categoriesSection">
                    Categories
                </button>
            </h2>
            <div id="categoriesSection" class="accordion-collapse collapse" aria-labelledby="categoriesHeading" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-primary">Manage Categories</h4>
                        <a href="categories.php" class="btn btn-success">Add Category</a>
                    </div>
                    <?php if (isset($_SESSION['categories_status'])): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?php 
                                echo $_SESSION['categories_status']; 
                                unset($_SESSION['categories_status']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <table class="table table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($categories_result)): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <a href="edit-category.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="delete-category.php?id=<?php echo $row['id']; ?>" 
                                           onclick="return confirm('Are you sure you want to delete this category?');" 
                                           class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
