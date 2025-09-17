<?php
$config = require __DIR__ . '/../config.php';
$token = $config['api_token'];
$apiUrl = 'http://localhost:8080/api/info'; // URL до API

// Функція для отримання даних
function getData($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true) ?? [];
}

// Якщо надіслана форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_encode([
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? ''
    ]);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ]);
    curl_exec($ch);
    curl_close($ch);

    // Після додавання перезавантажуємо сторінку
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Отримуємо дані для таблиці
$data = getData($apiUrl, $token);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список користувачів</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <h3 style="text-align:center;">Додати користувача</h3>
    <form method="post" style="text-align:center;">
        <input type="text" name="name" placeholder="Ім’я" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Додати</button>
    </form>

    <h3 style="text-align:center;">Список користувачів</h3>

    <table border="1" cellpadding="8" cellspacing="0" style="margin: 0 auto;">
        <tr><th>ID</th><th>Ім’я</th><th>Email</th></tr>
        <?php foreach ($data as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
