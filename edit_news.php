<?php
$page_title = "Edit News - Admin Panel";
include '../header.php';
require_once '../db_connect.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$error = '';
$success = '';
$article = null;

// Get article ID
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$article_id = $_GET['id'];

// Fetch article data
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

if (!$article) {
    header('Location: dashboard.php');
    exit;
}

// Handle form submission
if ($_POST) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $author = trim($_POST['author']);
    
    if (empty($title) || empty($content) || empty($category) || empty($author)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE news SET title = ?, content = ?, category = ?, author = ? WHERE id = ?");
        
        if ($stmt->execute([$title, $content, $category, $author, $article_id])) {
            $success = "News article updated successfully!";
            // Refresh article data
            $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
            $stmt->execute([$article_id]);
            $article = $stmt->fetch();
        } else {
            $error = "Failed to update news article. Please try again.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0">
            <div class="admin-sidebar">
                <div class="p-3 text-white">
                    <h5><i class="fas fa-tachometer-alt me-2"></i>Admin Panel</h5>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="add_news.php">
                        <i class="fas fa-plus me-2"></i>Add News
                    </a>
                    <a class="nav-link" href="../index.php">
                        <i class="fas fa-globe me-2"></i>View Site
                    </a>
                    <a class="nav-link" href="../logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Edit News Article</h2>
                    <div>
                        <a href="../news.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye me-1"></i>Preview
                        </a>
                        <a href="dashboard.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-edit me-2"></i>Edit Article</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($error): ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($success): ?>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                                    </div>
                                <?php endif; ?>

                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title *</label>
                                        <input type="text" class="form-control" id="title" name="title" 
                                               value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($article['title']); ?>" 
                                               placeholder="Enter article title" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category *</label>
                                                <select class="form-select" id="category" name="category" required>
                                                    <option value="">Select Category</option>
                                                    <?php 
                                                    $categories = ['General', 'Technology', 'Sports', 'Business', 'Entertainment', 'Health', 'Politics'];
                                                    $selected_category = isset($_POST['category']) ? $_POST['category'] : $article['category'];
                                                    foreach ($categories as $cat): 
                                                    ?>
                                                        <option value="<?php echo $cat; ?>" <?php echo ($selected_category == $cat) ? 'selected' : ''; ?>>
                                                            <?php echo $cat; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="author" class="form-label">Author *</label>
                                                <input type="text" class="form-control" id="author" name="author" 
                                                       value="<?php echo isset($_POST['author']) ? htmlspecialchars($_POST['author']) : htmlspecialchars($article['author']); ?>" 
                                                       placeholder="Enter author name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content *</label>
                                        <textarea class="form-control" id="content" name="content" rows="12" 
                                                  placeholder="Enter article content..." required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : htmlspecialchars($article['content']); ?></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="dashboard.php" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Update Article
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h6><i class="fas fa-info-circle me-2"></i>Article Info</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Created:</strong><br><?php echo date('F j, Y \a\t g:i A', strtotime($article['created_at'])); ?></p>
                                <p><strong>Article ID:</strong> <?php echo $article['id']; ?></p>
                                <hr>
                                <div class="d-grid gap-2">
                                    <a href="../news.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Preview Article
                                    </a>
                                    <a href="delete_news.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this article?')">
                                        <i class="fas fa-trash me-1"></i>Delete Article
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
