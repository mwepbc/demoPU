<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корочки.Есть</title>
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="shortcut icon" href="resources/media/image01.webp" type="image/x-icon">
</head>

<body>
    <?php require_once __DIR__.'/src/Include/header.php'; ?>
    <h1>Корочки.Есть — Запись на онлайн курсы дополнительного профессионального образования</h1>
    <div class="slider">
        <button onclick="prevSlider()">←</button>
        <div class="sliderInfo">
            <img src="resources/media/image08.webp" alt="sliderPhoto">
        </div>
        <button onclick="nextSlider()">→</button>
    </div>
    <div class="indexInfo">
        <p>
            Хотите узнать подробнее?
        </p>
        <a href="register.php">Зарегистрируйтесь </a>
        <p>или </p>
        <a href="auth.php"> войдите в аккаунт!</a>
    </div>
    <script src="resources/js/slider.js"></script>
</body>

</html>