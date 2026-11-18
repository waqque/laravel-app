<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Учебное приложение')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 850px;
            margin: 20px auto;
            padding: 0 15px;
            line-height: 1.5;
            color: #333;
        }
        nav a {
            text-decoration: none;
            color: #0066cc;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 15px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form p {
            margin-bottom: 12px;
        }
        input[type="text"], input[type="email"], select, textarea {
            width: 100%;
            max-width: 450px;
            padding: 6px;
            box-sizing: border-box;
            font-family: inherit;
        }
        button {
            padding: 6px 14px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    {{-- Вставка хедера (с логотипом и меню) --}}
    @include('partials.header')

    <hr>

    {{-- Основная часть страницы --}}
    <main>
        @yield('content')
    </main>

    <hr>

    {{-- Вставка футера --}}
    @include('partials.footer')

</body>
</html>
