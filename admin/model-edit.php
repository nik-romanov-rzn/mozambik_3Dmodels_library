<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin();

$error = '';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) {
    exit('Модель не найдена');
}

$stmt = $pdo->prepare("SELECT * FROM models WHERE id = ?");
$stmt->execute([$id]);
$model = $stmt->fetch();

if (!$model) {
    exit('Модель не найдена');
}

$title = $model['title'] ?? '';
$category = $model['category'] ?? '';
$short = $model['short_description'] ?? '';
$full = $model['full_description'] ?? '';
$isFeatured = !empty($model['is_featured']) ? 1 : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $short = trim($_POST['short_description'] ?? '');
    $full = trim($_POST['full_description'] ?? '');
    $isFeatured = !empty($_POST['is_featured']) ? 1 : 0;

    if ($title === '' || $category === '') {
        $error = 'Заполни обязательные поля';
    } else {
        $slug = slugify($title);

        $check = $pdo->prepare("SELECT COUNT(*) FROM models WHERE slug = ? AND id != ?");
        $check->execute([$slug, $id]);

        if ($check->fetchColumn() > 0) {
            $slug .= '-' . time();
        }

        $uploadDir = __DIR__ . '/../uploads/models/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            $error = 'Не удалось создать папку для загрузки файлов';
        } else {
            $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $allowedModelExtensions = [
                'file_fbx' => ['fbx'],
                'file_obj' => ['obj'],
                'file_blend' => ['blend'],
                'file_3ds' => ['3ds'],
                'file_glb' => ['glb']
            ];

            $imageMain = $model['image_main'];
            $file_fbx = $model['file_fbx'];
            $file_obj = $model['file_obj'];
            $file_blend = $model['file_blend'];
            $file_3ds = $model['file_3ds'];
            $file_glb = $model['file_glb'] ?? null;

            if (isset($_FILES['image_main']) && $_FILES['image_main']['error'] === 0 && !empty($_FILES['image_main']['name'])) {
                $imageExt = strtolower(pathinfo($_FILES['image_main']['name'], PATHINFO_EXTENSION));

                if (!in_array($imageExt, $allowedImageExtensions, true)) {
                    $error = 'Главное изображение должно быть в формате JPG, JPEG, PNG или WEBP';
                } else {
                    $imageName = time() . '-image.' . $imageExt;
                    $imagePath = $uploadDir . $imageName;

                    if (!move_uploaded_file($_FILES['image_main']['tmp_name'], $imagePath)) {
                        $error = 'Не удалось сохранить новое изображение';
                    } else {
                        $imageMain = 'uploads/models/' . $imageName;
                    }
                }
            }

            if ($error === '') {
                foreach ($allowedModelExtensions as $field => $extensions) {
                    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === 0 && !empty($_FILES[$field]['name'])) {
                        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));

                        if (!in_array($ext, $extensions, true)) {
                            $error = 'Неверный формат файла для поля ' . $field;
                            break;
                        }

                        $fileName = time() . '-' . $field . '.' . $ext;
                        $filePath = $uploadDir . $fileName;

                        if (!move_uploaded_file($_FILES[$field]['tmp_name'], $filePath)) {
                            $error = 'Не удалось загрузить файл: ' . htmlspecialchars($_FILES[$field]['name']);
                            break;
                        }

                        $$field = 'uploads/models/' . $fileName;
                    }
                }
            }

            if ($error === '') {
                $update = $pdo->prepare("
                    UPDATE models SET
                        title = ?,
                        slug = ?,
                        category = ?,
                        short_description = ?,
                        full_description = ?,
                        image_main = ?,
                        file_fbx = ?,
                        file_obj = ?,
                        file_blend = ?,
                        file_3ds = ?,
                        file_glb = ?,
                        is_featured = ?
                    WHERE id = ?
                ");

                $update->execute([
                    $title,
                    $slug,
                    $category,
                    $short,
                    $full,
                    $imageMain,
                    $file_fbx,
                    $file_obj,
                    $file_blend,
                    $file_3ds,
                    $file_glb,
                    $isFeatured,
                    $id
                ]);

                header('Location: models.php');
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Редактировать модель</title>
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
            <div class="admin-brand">Редактирование</div>
            <div class="admin-subtitle">Обновление карточки товара</div>
        </div>

        <div class="admin-actions">
            <a href="models.php" class="admin-link-btn">Назад к товарам</a>
        </div>
    </div>

    <div class="glass-card form-card">
        <h2 class="section-title">Редактировать модель</h2>

        <?php if ($error): ?>
            <div class="error-box"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="admin-form">
            <input type="hidden" name="id" value="<?= (int)$model['id'] ?>">

            <div class="form-grid">
                <div class="input-group">
                    <label>Название</label>
                    <input type="text" name="title" value="<?= e($title) ?>" required>
                </div>

                <div class="input-group">
                    <label>Категория</label>
                    <input type="text" name="category" value="<?= e($category) ?>" required>
                </div>

                <div class="input-group full">
                    <label>Краткое описание</label>
                    <textarea name="short_description"><?= e($short) ?></textarea>
                </div>

                <div class="input-group full">
                    <label>Полное описание</label>
                    <textarea name="full_description"><?= e($full) ?></textarea>
                </div>

                <div class="input-group">
                    <label>Текущее изображение</label>
                    <?php if (!empty($model['image_main'])): ?>
                        <img src="../<?= e($model['image_main']) ?>" alt="" class="preview-img">
                    <?php endif; ?>
                    <input type="file" name="image_main" accept=".jpg,.jpeg,.png,.webp">
                </div>

                <div class="input-group">
                    <label>FBX</label>
                    <?php if (!empty($model['file_fbx'])): ?>
                        <a class="file-note" href="../<?= e($model['file_fbx']) ?>" target="_blank">Текущий FBX</a>
                    <?php endif; ?>
                    <input type="file" name="file_fbx" accept=".fbx">
                </div>

                <div class="input-group">
                    <label>OBJ</label>
                    <?php if (!empty($model['file_obj'])): ?>
                        <a class="file-note" href="../<?= e($model['file_obj']) ?>" target="_blank">Текущий OBJ</a>
                    <?php endif; ?>
                    <input type="file" name="file_obj" accept=".obj">
                </div>

                <div class="input-group">
                    <label>BLEND</label>
                    <?php if (!empty($model['file_blend'])): ?>
                        <a class="file-note" href="../<?= e($model['file_blend']) ?>" target="_blank">Текущий BLEND</a>
                    <?php endif; ?>
                    <input type="file" name="file_blend" accept=".blend">
                </div>

                <div class="input-group">
                    <label>3DS</label>
                    <?php if (!empty($model['file_3ds'])): ?>
                        <a class="file-note" href="../<?= e($model['file_3ds']) ?>" target="_blank">Текущий 3DS</a>
                    <?php endif; ?>
                    <input type="file" name="file_3ds" accept=".3ds">
                </div>

                <div class="input-group">
                    <label>GLB для 3D просмотра</label>
                    <?php if (!empty($model['file_glb'])): ?>
                        <a class="file-note" href="../<?= e($model['file_glb']) ?>" target="_blank">Текущий GLB</a>
                    <?php endif; ?>
                    <input type="file" name="file_glb" accept=".glb">
                </div>

                <div class="input-group">
                    <label>Популярная модель</label>
                    <label class="checkbox-row">
                        <input type="checkbox" name="is_featured" value="1" <?= $isFeatured ? 'checked' : '' ?>>
                        Показывать как популярную
                    </label>
                </div>
            </div>

            <button type="submit" class="admin-btn">Сохранить изменения</button>
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