<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Мой сайт на Laravel')</title>
</head>
<body style="font-family: sans-serif; max-width: 800px; margin: 20px auto; padding: 0 10px;">

    {{-- Вставка хедера (с логотипом и меню) --}}
    @include('header')

    <hr>

    {{-- Область для контента страниц --}}
    <main>
        @yield('content')
    </main>

    <hr>

    {{-- Вставка футера --}}
    @include('footer')

</body>
</html>
