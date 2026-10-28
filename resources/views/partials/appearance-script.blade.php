<!-- Apply saved appearance from cookie immediately to avoid a theme flash -->
<script>
    (function () {
        var key = 'appearance';
        var root = document.documentElement;

        var getCookie = function (name) {
            var match = document.cookie.match('(?:^|;\\s*)' + name + '=([^;]*)');
            return match ? decodeURIComponent(match[1]) : null;
        };

        var appearance = getCookie(key) || 'system';

        if (appearance === 'dark') {
            root.classList.add('dark');
        } else if (appearance === 'light') {
            root.classList.remove('dark');
        } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            root.classList.add('dark');
        }
    })();
</script>
