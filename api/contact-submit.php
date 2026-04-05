<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

require_post();

session_start();

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');
$privacy = !empty($_POST['privacy_agree']);

if ($name === '' || $email === '' || $message === '') {
    exit('Заполни обязательные поля');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Некорректный email');
}

if (!$privacy) {
    exit('Необходимо согласие на обработку данных');
}

$stmt = $pdo->prepare("
    INSERT INTO contact_requests 
    (name, email, phone, subject, message) 
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([$name, $email, $phone, $subject, $message]);

$_SESSION['success'] = true;

header('Location: ../contacts.php');
exit;