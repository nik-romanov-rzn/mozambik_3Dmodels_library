<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? 'new');

    $stmt = $pdo->prepare("UPDATE contact_requests SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

$requests = $pdo->query("SELECT * FROM contact_requests ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Заявки</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="grid-overlay"></div>
<div class="bg-glow glow-1"></div>
<div class="bg-glow glow-2"></div>

<div class="admin-wrap">
    <div class="admin-topbar">
        <div>
            <div class="admin-brand">Заявки</div>
            <div class="admin-subtitle">Сообщения с формы контактов</div>
        </div>

        <div class="admin-actions">
            <a href="index.php" class="admin-link-btn">Назад</a>
        </div>
    </div>

    <?php foreach ($requests as $request): ?>
        <div class="glass-card request-card">
            <div class="request-meta">
                <p><strong>Имя:</strong> <?= htmlspecialchars($request['name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($request['email']) ?></p>
                <p><strong>Телефон:</strong> <?= htmlspecialchars($request['phone']) ?></p>
                <p><strong>Тема:</strong> <?= htmlspecialchars($request['subject']) ?></p>
                <p><strong>Дата:</strong> <?= htmlspecialchars($request['created_at']) ?></p>
                <p><strong>Статус:</strong> <span class="tag"><?= htmlspecialchars($request['status']) ?></span></p>
            </div>

            <div class="request-message">
                <strong>Сообщение:</strong><br>
                <?= nl2br(htmlspecialchars($request['message'])) ?>
            </div>

            <form method="post" class="status-form">
                <input type="hidden" name="id" value="<?= (int)$request['id'] ?>">
                <select name="status">
                    <option value="new" <?= $request['status'] === 'new' ? 'selected' : '' ?>>new</option>
                    <option value="in_progress" <?= $request['status'] === 'in_progress' ? 'selected' : '' ?>>in_progress</option>
                    <option value="done" <?= $request['status'] === 'done' ? 'selected' : '' ?>>done</option>
                </select>
                <button type="submit" class="admin-btn">Обновить</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<script>
document.addEventListener('mousemove', (e) => {
    document.querySelectorAll('.bg-glow').forEach((g, i) => {
        const s = (i + 1) * 20;
        const x = (0.5 - e.clientX / window.innerWidth) * s;
        const y = (0.5 - e.clientY / window.innerHeight) * s;
        g.style.transform = `translate(${x}px, ${y}px)`;
    });
});
</script>
</body>
</html>