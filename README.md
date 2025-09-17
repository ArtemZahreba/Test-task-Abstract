# Test-task-Abstract

---

# Тестове завдання PHP (Junior)

## 📌 Суть завдання

Цей проєкт реалізує простий веб-застосунок з **API** та **веб-інтерфейсом**, що дозволяє:

1. Переглядати список користувачів.
2. Додавати нового користувача.

### Технології

* PHP 8+
* JSON файл для збереження даних (`api/data.json`)
* HTML/CSS для фронтенду
* cURL (можна використовувати для роботи з API, але локально використовується пряме читання JSON)

---

## 📂 Структура проєкту

```
project/
│
├─ api/                  # API
│   ├─ index.php         # Обробка GET/POST
│   └─ data.json         # Файл для зберігання користувачів
│
├─ public/               # Публічна частина сайту
│   ├─ index.php         # Головна сторінка з таблицею та формою
│   └─ assets/           # Стилі та скрипти
│       ├─ css/
│       │   └─ style.css # Основні стилі
│       └─ js/
│           └─ script.js # JavaScript (поки порожній або для майбутніх фіч)
│
└─ config.php            # Конфігураційний файл (токен, шлях до data.json)
```

---

## ⚙️ Налаштування

1. Клонуйте репозиторій або розпакуйте архів.
2. Переконайтеся, що PHP 8+ встановлено на вашій системі.
3. Перевірте `config.php`:

```php
return [
    'api_token' => 'secret_key_value_123',
    'data_file' => __DIR__ . '/api/data.json'
];
```

---

## 🚀 Як запустити

В терміналі перейдіть у кореневу папку проєкту і запустіть PHP-сервер для папки `public`:

```bash
php -S localhost:8080 -t public
```

Відкрийте браузер і перейдіть за адресою:

```
http://localhost:8080
```

---

## 📝 Як тестувати

### 1. Через веб-інтерфейс

* Відкрийте головну сторінку.
* Додайте користувача через форму (ім’я + email).
* Після сабміту таблиця оновиться автоматично.

### 2. Через Postman (API)

**GET /api/info**

```
URL: http://localhost:8080/api/info
Headers: Authorization: Bearer secret_key_value_123
```

Відповідь:

```json
[
  {"id":1,"name":"Artem","email":"artem@example.com"}
]
```

**POST /api/info**

```
URL: http://localhost:8080/api/info
Headers:
  Authorization: Bearer secret_key_value_123
  Content-Type: application/json
Body:
{
  "name": "Ім'я",
  "email": "email@example.com"
}
```

---

## 🔑 Токен доступу

* Використовується токен з `config.php`.
* Для API запитів обов’язково додавати заголовок:

```
Authorization: Bearer secret_key_value_123
```

---

## ⚡ Особливості реалізації

* Дані зберігаються в `api/data.json`.
* HTML-екранування введених даних (`htmlspecialchars`) для безпеки.
* Легка структура проекту, готова до перенесення на SQLite/MySQL.

---

