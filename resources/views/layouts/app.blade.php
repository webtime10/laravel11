<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', $title ?? 'Сайт')</title>
  @livewireStyles
</head>
<body class="antialiased">
  <header class="container mx-auto p-4 flex gap-6">
    <a href="{{ route('home') }}" wire:navigate>Главная</a>
    <a href="{{ route('blog.index') }}" wire:navigate>Блог</a>
  </header>

  <main class="container mx-auto p-4">
    {{ $slot }}
  </main>

  @livewireScripts
</body>
</html>

