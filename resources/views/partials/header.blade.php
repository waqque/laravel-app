<header>
    <h2>🌐 Мой сайт на Laravel <small style="font-size: 14px; font-weight: normal; color: #666;">(v2.0: БД Eloquent)</small></h2>
    <nav style="margin-top: 8px;">
        <a href="{{ route('home') }}">Главная</a> |
        <a href="{{ route('posts.index') }}">Статьи (БД)</a> |
        <a href="{{ route('posts.create') }}">+ Добавить статью</a> |
        <a href="{{ route('feedback.create') }}">Форма (JSON-файл)</a> |
        <a href="{{ route('feedback.index') }}">Таблица файлов</a> |
        <a href="{{ route('api.posts.index') }}" target="_blank">API (JSON)</a>
    </nav>
</header>
