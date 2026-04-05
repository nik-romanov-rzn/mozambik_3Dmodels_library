<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$modelsCount = $pdo->query("SELECT COUNT(*) FROM models")->fetchColumn();
$requestsCount = $pdo->query("SELECT COUNT(*) FROM contact_requests")->fetchColumn();
$newRequestsCount = $pdo->query("SELECT COUNT(*) FROM contact_requests WHERE status='new'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Админка</title>
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
            <div class="admin-brand">МОЗАМБИК ADMIN</div>
            <div class="admin-subtitle">Панель управления моделями и заявками</div>
        </div>

        <div class="admin-actions">
            <a href="models.php" class="admin-link-btn">Модели</a>
            <a href="model-create.php" class="admin-btn">Добавить модель</a>
            <a href="requests.php" class="admin-link-btn">Заявки</a>
            <a href="logout.php" class="admin-btn-secondary">Выйти</a>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="glass-card stat-card">
            <h3>Модели</h3>
            <div class="value"><?= (int)$modelsCount ?></div>
            <div class="desc">Всего товаров в каталоге</div>
        </div>

        <div class="glass-card stat-card">
            <h3>Заявки</h3>
            <div class="value"><?= (int)$requestsCount ?></div>
            <div class="desc">Все входящие сообщения</div>
        </div>

        <div class="glass-card stat-card">
            <h3>Новые</h3>
            <div class="value"><?= (int)$newRequestsCount ?></div>
            <div class="desc">Необработанные заявки</div>
        </div>
    </div>

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