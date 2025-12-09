<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Сайт')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
  <main class="container mx-auto p-4">
    @yield('content')
  </main>
</body>
</html>

