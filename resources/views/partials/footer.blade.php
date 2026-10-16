<footer class="bg-light text-muted py-4 mt-auto border-top">
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-md-6 text-center text-md-start">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                    <span class="fw-semibold text-dark">Laravel Web App</span>
                    <span class="badge bg-secondary-subtle text-secondary border">v1.0</span>
                    <span class="text-secondary">&bull;</span>
                    <span class="small">Фреймворк Laravel {{ app()->version() }}</span>
                </div>
                <div class="small text-secondary mt-1">
                    Базовая конфигурация: шифрование AES-256-CBC, часовой пояс {{ config('app.timezone') }}, локаль {{ config('app.locale') }}.
                </div>
            </div>
            <div class="col-md-6 text-center text-md-end small">
                <div>Серверное время: <strong>{{ now()->format('d.m.Y H:i:s') }}</strong></div>
                <div class="text-secondary mt-1">Хранилище данных: <code>storage/app/submissions/*.json</code></div>
            </div>
        </div>
    </div>
</footer>
