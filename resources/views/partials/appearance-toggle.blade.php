<button
    id="appearance-toggle"
    type="button"
    class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-800 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600 transition"
    aria-label="สลับโหมดสี"
>
    <span id="appearance-icon">🌙</span>
    <span id="appearance-label">โหมดมืด</span>
</button>
<script>
    (function () {
        var key = 'appearance';
        var maxAge = 365 * 24 * 60 * 60;
        var root = document.documentElement;
        var btn = document.getElementById('appearance-toggle');
        var icon = document.getElementById('appearance-icon');
        var label = document.getElementById('appearance-label');

        var labels = { light: 'โหมดสว่าง', dark: 'โหมดมืด', system: 'ตามระบบ' };
        var icons = { light: '🌙', dark: '☀️', system: '🖥️' };

        var getCookie = function (name) {
            var match = document.cookie.match('(?:^|;\\s*)' + name + '=([^;]*)');
            return match ? decodeURIComponent(match[1]) : null;
        };

        var setCookie = function (value) {
            document.cookie = key + '=' + encodeURIComponent(value) + '; path=/; max-age=' + maxAge + '; SameSite=Lax';
        };

        var apply = function (value) {
            var dark = value === 'dark' ? true : value === 'light' ? false : window.matchMedia('(prefers-color-scheme: dark)').matches;

            root.classList.toggle('dark', dark);
            icon.textContent = icons[value];
            label.textContent = labels[value];
        };

        var current = getCookie(key) || 'system';
        apply(current);

        btn.addEventListener('click', function () {
            current = current === 'light' ? 'dark' : current === 'dark' ? 'system' : 'light';
            setCookie(current);
            apply(current);
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
            if (current === 'system') {
                apply('system');
            }
        });
    })();
</script>
