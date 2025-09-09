<?php
$page_title = "Add News - Admin Panel";
include '../header.php';
require_once '../db_connect.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$error = '';
$success = '';

if ($_POST) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $author = trim($_POST['author']);
    
    if (empty($title) || empty($content) || empty($category) || empty($author)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO news (title, content, category, author) VALUES (?, ?, ?, ?)");
        
        if ($stmt->execute([$title, $content, $category, $author])) {
            $success = "News article added successfully!";
            // Clear form data
            $_POST = array();
        } else {
            $error = "Failed to add news article. Please try again.";
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
                    <a class="nav-link active" href="add_news.php">
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
                    <h2>Add News Article</h2>
                    <a href="dashboard.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                    </a>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-plus me-2"></i>New Article</h5>
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
                                               value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" 
                                               placeholder="Enter article title" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category *</label>
                                                <select class="form-select" id="category" name="category" required>
                                                    <option value="">Select Category</option>
                                                    <option value="General" <?php echo (isset($_POST['category']) && $_POST['category'] == 'General') ? 'selected' : ''; ?>>General</option>
                                                    <option value="Technology" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Technology') ? 'selected' : ''; ?>>Technology</option>
                                                    <option value="Sports" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Sports') ? 'selected' : ''; ?>>Sports</option>
                                                    <option value="Business" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Business') ? 'selected' : ''; ?>>Business</option>
                                                    <option value="Entertainment" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Entertainment') ? 'selected' : ''; ?>>Entertainment</option>
                                                    <option value="Health" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Health') ? 'selected' : ''; ?>>Health</option>
                                                    <option value="Politics" <?php echo (isset($_POST['category']) && $_POST['category'] == 'Politics') ? 'selected' : ''; ?>>Politics</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="author" class="form-label">Author *</label>
                                                <input type="text" class="form-control" id="author" name="author" 
                                                       value="<?php echo isset($_POST['author']) ? htmlspecialchars($_POST['author']) : $_SESSION['username']; ?>" 
                                                       placeholder="Enter author name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content *</label>
                                        <textarea class="form-control" id="content" name="content" rows="12" 
                                                  placeholder="Enter article content..." required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="dashboard.php" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Publish Article
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h6><i class="fas fa-info-circle me-2"></i>Publishing Guidelines</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Write clear and engaging titles
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Choose appropriate category
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Provide complete and accurate content
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Review before publishing
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
