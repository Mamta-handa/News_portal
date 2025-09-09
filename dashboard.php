<?php
$page_title = "Admin Dashboard - News Portal";
include '../header.php';
require_once '../db_connect.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_news FROM news");
$total_news = $stmt->fetch()['total_news'];

$stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users WHERE role = 'user'");
$total_users = $stmt->fetch()['total_users'];

// Get recent news
$stmt = $pdo->prepare("SELECT * FROM news ORDER BY created_at DESC LIMIT 10");
$stmt->execute();
$recent_news = $stmt->fetchAll();
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
                    <a class="nav-link active" href="dashboard.php">
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
                <h2 class="mb-4">Dashboard</h2>
                
                <?php if (isset($_SESSION['delete_success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['delete_success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['delete_success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['delete_error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $_SESSION['delete_error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['delete_error']); ?>
                <?php endif; ?>
                
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo $total_news; ?></h4>
                                        <p class="mb-0">Total News Articles</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-newspaper fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo $total_users; ?></h4>
                                        <p class="mb-0">Registered Users</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <a href="add_news.php" class="btn btn-primary me-2">
                                    <i class="fas fa-plus me-1"></i>Add New Article
                                </a>
                                <a href="../index.php" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>View Website
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent News Table -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-list me-2"></i>Recent News Articles</h5>
                        <a href="add_news.php" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>Add New
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recent_news)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No news articles yet.</p>
                                <a href="add_news.php" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Add First Article
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_news as $news): ?>
                                            <tr>
                                                <td><?php echo $news['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars(substr($news['title'], 0, 50)); ?></strong>
                                                    <?php if (strlen($news['title']) > 50) echo '...'; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($news['category']); ?></span>
                                                </td>
                                                <td><?php echo htmlspecialchars($news['author']); ?></td>
                                                <td><?php echo date('M j, Y', strtotime($news['created_at'])); ?></td>
                                                <td>
                                                    <a href="../news.php?id=<?php echo $news['id']; ?>" class="btn btn-sm btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="edit_news.php?id=<?php echo $news['id']; ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="delete_news.php?id=<?php echo $news['id']; ?>" class="btn btn-sm btn-outline-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this article?')" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
