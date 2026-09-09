<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bulma Playground</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@14/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ manifest('resources/js/bulma-playground.js', 'css') }}">
    <script src="https://cdn.jsdelivr.net/npm/swiper@14/swiper-bundle.min.js"></script>
</head>
<body>
    <div id="app"></div>
    <script type="module" src="{{ manifest('resources/js/bulma-playground.js', 'js') }}"></script>
</body>
</html>
