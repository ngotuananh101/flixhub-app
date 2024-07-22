<script>
    let hostUrl = "{{ asset('') }}";
</script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
<script>
    $(document).ready(function () {
        let themeMenuElement = document.getElementById('kt-change-theme-mode');
        if(themeMenuElement) {
            let themeMenu = KTMenu.getInstance(themeMenuElement);
            themeMenu.on('kt.menu.link.clicked', function (element) {
                let themeMode = element.getAttribute('data-kt-value');
                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }
                localStorage.setItem('data-bs-theme', themeMode);
                localStorage.setItem('data-bs-theme-mode', themeMode);
                KTThemeMode.setMode(themeMode);
            });
        }
    });
</script>
