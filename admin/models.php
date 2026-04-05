<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$models = $pdo->query("SELECT * FROM models ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Модели</title>
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
            <div class="admin-brand">Каталог моделей</div>
            <div class="admin-subtitle">Управление карточками товаров</div>
        </div>

        <div class="admin-actions">
            <a href="index.php" class="admin-link-btn">Назад</a>
            <a href="model-create.php" class="admin-btn">Добавить модель</a>
        </div>
    </div>

    <div class="glass-card section-card">
        <h2 class="section-title">Все модели</h2>

        <div class="table-wrap">
            <table class="admin-table">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Slug</th>
                    <th>Популярная</th>
                    <th>Действия</th>
                </tr>

                <?php foreach ($models as $model): ?>
                    <tr>
                        <td><?= (int)$model['id'] ?></td>
                        <td><?= htmlspecialchars($model['title']) ?></td>
                        <td><span class="tag"><?= htmlspecialchars($model['category']) ?></span></td>
                        <td><?= htmlspecialchars($model['slug']) ?></td>
                        <td><?= !empty($model['is_featured']) ? 'Да' : 'Нет' ?></td>
                        <td>
                            <div class="actions-row">
                                <a class="small-btn" href="model-edit.php?id=<?= (int)$model['id'] ?>">Редактировать</a>
                                <a class="small-btn danger" href="../api/delete-model.php?id=<?= (int)$model['id'] ?>" onclick="return confirm('Удалить модель?')">Удалить</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
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