<?php
$config = require __DIR__ . '/../config.php';
$dataFile = $config['data_file'];

// Якщо файлу немає — створюємо порожній масив
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([]));
}

// Якщо надіслана форма — додаємо користувача
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents($dataFile), true) ?? [];

    $new = [
        'id' => count($data) + 1,
        'name' => htmlspecialchars($_POST['name'] ?? ''),
        'email' => htmlspecialchars($_POST['email'] ?? '')
    ];

    $data[] = $new;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Отримуємо дані для таблиці
$data = json_decode(file_get_contents($dataFile), true) ?? [];
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
