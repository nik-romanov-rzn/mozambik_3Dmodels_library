<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("DELETE FROM models WHERE id = ?");
$stmt->execute([$id]);

header('Location: ../admin/models.php');
exit;