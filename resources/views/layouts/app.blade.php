<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Сайт')</title>
</head>
<body class="antialiased">
  <header class="container mx-auto p-4 flex gap-6">
  <div class="menu">
    <a href="{{ route('home') }}">Главная</a>
    <a href="{{ route('blog.index') }}">Блог</a>
  </div>
  <div class="langv">
        <ul class="navbar-nav mb-2 mb-lg-0 langs">
            @foreach(\App\Helper\Langs::LOCALES as $locale)
                @if($locale == app()->getLocale())
                    <li class="nav-item">
                        <a class="nav-link active">{{ $locale }}</a>
                    </li>
                @else
                   <li class="nav-item">
                        <a class="nav-link" href="{{ route('setlang', $locale) }}">
                            {{ $locale }}
                        </a>
                    </li>

                @endif
            @endforeach
        </ul>

  </div>
  </header>

  <main class="container mx-auto p-4">
    @yield('content')
  </main>
</body>
</html>

