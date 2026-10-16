<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Мой сайт') - Учебный проект Laravel</title>

    <style>
        /* Простые и понятные базовые стили */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f6f9;
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Контейнер для центрирования содержимого */
        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Хедер и меню */
        header {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #ffffff;
            text-decoration: none;
        }

        .logo span {
            color: #e74c3c;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
        }

        nav a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            transition: background 0.2s;
        }

        nav a:hover, nav a.active {
            background-color: #34495e;
            color: #ffffff;
            font-weight: bold;
        }

        /* Основной контент */
        main {
            flex: 1;
            padding: 30px 0;
        }

        .card {
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 6px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        h1, h2, h3 {
            margin-bottom: 15px;
            color: #2c3e50;
        }

        p {
            margin-bottom: 12px;
        }

        /* Формы и элементы ввода */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .required {
            color: #e74c3c;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
        }

        input.is-invalid, select.is-invalid, textarea.is-invalid {
            border-color: #e74c3c;
            background-color: #fdf7f7;
        }

        .field-error {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 4px;
        }

        /* Кнопки */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            border: none;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #3498db;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #2ecc71;
            color: #ffffff;
        }
        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: #ffffff;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        /* Уведомления */
        .alert {
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin-left: 20px;
            margin-top: 5px;
        }

        /* Простая таблица */
        table.simple-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
            background: #ffffff;
        }

        table.simple-table th, table.simple-table td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: left;
        }

        table.simple-table th {
            background-color: #f2f2f2;
            color: #333333;
        }

        table.simple-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        table.simple-table tr:hover {
            background-color: #f5f5f5;
        }

        /* Бейджи */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 12px;
            border-radius: 3px;
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        /* Футер */
        footer {
            background-color: #ffffff;
            border-top: 1px solid #e1e4e8;
            padding: 15px 0;
            text-align: center;
            font-size: 13px;
            color: #777777;
        }
    </style>
</head>
<body>

    {{-- 1. Вставка хедера с логотипом и навигацией --}}
    @include('partials.header')

    {{-- 2. Основная часть страницы --}}
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- 3. Вставка футера --}}
    @include('partials.footer')

</body>
</html>
