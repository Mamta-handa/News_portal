<?php
include '../header.php';
require_once '../db_connect.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Get article ID
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$article_id = $_GET['id'];

// Check if article exists
$stmt = $pdo->prepare("SELECT title FROM news WHERE id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

if (!$article) {
    header('Location: dashboard.php');
    exit;
}

// Delete the article
$stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
if ($stmt->execute([$article_id])) {
    $_SESSION['delete_success'] = "Article '{$article['title']}' has been deleted successfully.";
} else {
    $_SESSION['delete_error'] = "Failed to delete the article. Please try again.";
}

header('Location: dashboard.php');
exit;
?>
