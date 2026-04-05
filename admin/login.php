<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Вход в админку</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="grid-overlay"></div>
<div class="bg-glow glow-1"></div>
<div class="bg-glow glow-2"></div>

<div class="login-page">
    <div class="glass-card login-card">
        <h1 class="login-title">Админка</h1>
        <p class="login-text">Войдите в панель управления каталогом и заявками.</p>

        <?php if ($error): ?>
            <div class="error-box"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="admin-form">
            <div class="input-group">
                <label for="username">Логин</label>
                <input id="username" type="text" name="username" placeholder="Введите логин" required>
            </div>

            <div class="input-group">
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" placeholder="Введите пароль" required>
            </div>

            <button type="submit" class="admin-btn">Войти</button>
        </form>
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