<header>
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 24px;">🌐</span>
        <h2 style="margin: 0;">Мой сайт на Laravel</h2>
    </div>
    <nav style="margin-top: 10px;">
        <a href="{{ route('home') }}">Главная</a> |
        <a href="{{ route('form') }}">Форма</a> |
        <a href="{{ route('data') }}">Таблица данных</a>
    </nav>
</header>
