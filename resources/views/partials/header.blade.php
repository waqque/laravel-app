<header>
    <h2>Мой сайт на Laravel</h2>
    <nav>
        <a href="{{ route('home') }}">Главная</a> |
        <a href="{{ route('feedback.create') }}">Форма обратной связи</a> |
        <a href="{{ route('feedback.index') }}">Таблица данных</a>
    </nav>
</header>
