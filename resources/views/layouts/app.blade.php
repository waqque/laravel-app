<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Веб-приложение на Laravel') - {{ config('app.name', 'LaravelApp') }}</title>

    <!-- Bootstrap 5 CSS & Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bs-primary: #0d6efd;
            --brand-color: #ff2d20;
        }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .card {
            border-radius: 0.75rem;
            border: 1px solid rgba(0,0,0,0.08);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
        }
        .btn-brand {
            background-color: #ff2d20;
            color: #ffffff;
            border: none;
        }
        .btn-brand:hover {
            background-color: #e02418;
            color: #ffffff;
        }
    </style>
    @yield('styles')
</head>
<body class="d-flex flex-column h-100">

    {{-- Вставка хедера с логотипом и меню --}}
    @include('partials.header')

    {{-- Основная область контента --}}
    <main class="flex-shrink-0 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    {{-- Вставка футера --}}
    @include('partials.footer')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @yield('scripts')
</body>
</html>
