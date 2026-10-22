<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Учебное приложение')</title>
</head>
<body style="font-family: sans-serif; max-width: 800px; margin: 20px auto; padding: 0 10px; line-height: 1.5;">

    {{-- Хедер с логотипом и меню --}}
    @include('partials.header')

    <hr>

    {{-- Основной контент страницы --}}
    <main>
        @yield('content')
    </main>

    <hr>

    {{-- Футер сайта --}}
    @include('partials.footer')

</body>
</html>
