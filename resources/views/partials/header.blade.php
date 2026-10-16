<header class="bg-dark text-white sticky-top shadow-sm border-bottom border-secondary">
    <nav class="navbar navbar-expand-lg navbar-dark container py-2">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-white text-decoration-none" href="{{ route('home') }}">
            <span class="bg-danger text-white rounded p-1 d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16.5 9.4 7.55 4.24a1.78 1.78 0 0 0-2.5 1.55v12.42a1.78 1.78 0 0 0 2.5 1.55L16.5 14.6a1.78 1.78 0 0 0 0-3.2z"/>
                    <path d="m21 16-4-2.3"/>
                    <path d="m21 8-4 2.3"/>
                    <path d="M3 12h1"/>
                </svg>
            </span>
            <span>Laravel<span class="text-danger">App</span></span>
            <span class="badge bg-secondary ms-1 fs-8">v1.0</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold text-white' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i> Главная
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('feedback.create') ? 'active fw-semibold text-white' : '' }}" href="{{ route('feedback.create') }}">
                        <i class="bi bi-pencil-square me-1"></i> Отправить форму
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('feedback.index') ? 'active fw-semibold text-white' : '' }}" href="{{ route('feedback.index') }}">
                        <i class="bi bi-table me-1"></i> Таблица данных
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-success-subtle text-success border border-success-subtle d-none d-md-inline-block">
                    <i class="bi bi-clock me-1"></i> {{ config('app.timezone') }}
                </span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                    <i class="bi bi-translate me-1"></i> {{ strtoupper(config('app.locale')) }}
                </span>
                @if(config('app.debug'))
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle" title="Режим отладки активен">
                        <i class="bi bi-bug me-1"></i> Debug
                    </span>
                @endif
            </div>
        </div>
    </nav>
</header>
