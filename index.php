<?php
$page_title = "Home - News Portal";
include 'header.php';
require_once 'db_connect.php';

// Get latest news
$stmt = $pdo->prepare("SELECT * FROM news ORDER BY created_at DESC LIMIT 12");
$stmt->execute();
$news_articles = $stmt->fetchAll();
?>

<div class="container mt-4">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="jumbotron bg-primary text-white p-5 rounded">
                <h1 class="display-4">Welcome to News Portal</h1>
                <p class="lead">Stay updated with the latest news and breaking stories from around the world.</p>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a class="btn btn-light btn-lg" href="register.php" role="button">
                        <i class="fas fa-user-plus me-2"></i>Join Now
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Latest News</h2>
        </div>
        
        <?php if (empty($news_articles)): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>No news articles available at the moment.
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($news_articles as $article): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card news-card shadow-sm">
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2"><?php echo htmlspecialchars($article['category']); ?></span>
                            <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                            <p class="card-text">
                                <?php echo htmlspecialchars(substr($article['content'], 0, 120)) . '...'; ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($article['author']); ?>
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i><?php echo date('M j, Y', strtotime($article['created_at'])); ?>
                                </small>
                            </div>
                            <div class="mt-3">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="news.php?id=<?php echo $article['id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Read More
                                    </a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-lock me-1"></i>Login to Read
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- Call to Action for Non-logged Users -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h4>Want to read full articles?</h4>
                        <p class="mb-3">Join our community to access complete news stories and stay informed.</p>
                        <a href="register.php" class="btn btn-primary me-2">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                        <a href="login.php" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
