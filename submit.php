<?php
// Перевіряємо, чи була форма надіслана методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Створюємо папки, якщо вони не існують
    $textDir = 'text';
    $locationDir = 'location';
    $photoDir = 'uploads';

    if (!is_dir($textDir)) {
        mkdir($textDir, 0777, true);
    }

    if (!is_dir($locationDir)) {
        mkdir($locationDir, 0777, true);
    }

    if (!is_dir($photoDir)) {
        mkdir($photoDir, 0777, true);
    }

    // Отримуємо опис ситуації
    $description = trim($_POST['description']);
    $latitude = trim($_POST['latitude']);
    $longitude = trim($_POST['longitude']);

    // Генеруємо унікальні імена для файлів
    $textFileName = $textDir . '/' . uniqid('description_', true) . '.txt';
    $locationFileName = $locationDir . '/' . uniqid('location_', true) . '.txt';

    // Зберігаємо опис ситуації у файл
    file_put_contents($textFileName, $description);

    // Форматуємо координати у вигляді рядка та зберігаємо у файл
    $locationData = "Latitude: $latitude\nLongitude: $longitude";
    file_put_contents($locationFileName, $locationData);

    // Якщо були завантажені фото
    if (!empty($_FILES['photos']['tmp_name'][0])) {
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
            if (!empty($tmpName)) {
                $photoFileName = $photoDir . '/' . uniqid('photo_', true) . '.' . pathinfo($_FILES['photos']['name'][$key], PATHINFO_EXTENSION);
                move_uploaded_file($tmpName, $photoFileName);
            }
        }
    }

    // Повертаємо успішний результат
    echo "Дані збережено успішно.";
} else {
    // Якщо форма не була надіслана методом POST
    echo "Неправильний метод запиту.";
}
?>

<!-- Додаємо JavaScript для перенаправлення -->
<script>
    setTimeout(() => {
        window.location.href = "menu.html";
    }, 1); // 500 мс
</script>
