{{-- Хедер: логотип и меню навигации --}}
<header>
    <div class="container">
        <div class="header-content">
            <!-- Логотип приложения -->
            <a href="{{ route('home') }}" class="logo">
                Мой<span>Laravel</span>Сайт <small style="font-size: 12px; font-weight: normal; color: #bdc3c7;">(v1.0)</small>
            </a>

            <!-- Меню навигации -->
            <nav>
                <ul>
                    <li>
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            Главная
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('feedback.create') }}" class="{{ request()->routeIs('feedback.create') ? 'active' : '' }}">
                            Заполнить форму
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('feedback.index') }}" class="{{ request()->routeIs('feedback.index') ? 'active' : '' }}">
                            Таблица записей
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
