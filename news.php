<?php
$page_title = "News Article - News Portal";
include 'header.php';
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$article = null;

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $article = $stmt->fetch();
    
    if (!$article) {
        $error = "Article not found.";
    }
} else {
    $error = "No article specified.";
}
?>

<div class="container mt-4">
    <?php if ($error): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
        </div>
        <div class="text-center">
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Back to Home
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-light text-dark"><?php echo htmlspecialchars($article['category']); ?></span>
                            <small>
                                <i class="fas fa-clock me-1"></i>
                                <?php echo date('F j, Y \a\t g:i A', strtotime($article['created_at'])); ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <h1 class="card-title mb-4"><?php echo htmlspecialchars($article['title']); ?></h1>
                        
                        <div class="mb-4">
                            <div class="bg-light p-3 rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                <i class="fas fa-newspaper fa-5x text-muted"></i>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>By <?php echo htmlspecialchars($article['author']); ?>
                            </small>
                        </div>
                        
                        <div class="article-content">
                            <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="index.php" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Back to News
                            </a>
                            <div class="text-muted">
                                <small>Published on <?php echo date('M j, Y', strtotime($article['created_at'])); ?></small>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
