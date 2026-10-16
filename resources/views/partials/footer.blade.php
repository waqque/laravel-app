{{-- Футер сайта --}}
<footer>
    <div class="container">
        <p style="margin: 0;">
            Учебный проект по веб-разработке на <strong>Laravel</strong> &bull; Версия <strong>v1.0</strong>
        </p>
        <p style="margin: 5px 0 0; color: #888888; font-size: 12px;">
            Часовой пояс: {{ config('app.timezone') }} | Локаль: {{ config('app.locale') }} | Режим отладки: {{ config('app.debug') ? 'Вкл' : 'Выкл' }}
        </p>
    </div>
</footer>
