<script>
    let sidebar_minimize_state = Cookies.get('sidebar_minimize_state');
    if (sidebar_minimize_state === 'on') {
        $('body').attr('data-kt-app-sidebar-minimize', 'on');
    } else {
        $('body').attr('data-kt-app-sidebar-minimize', 'off');
    }

    let sidebar_toggle = $('#kt_app_sidebar_toggle');
    sidebar_toggle.on('click', function () {
        let sidebar_minimize_state = Cookies.get('sidebar_minimize_state');
        if (sidebar_minimize_state === 'on') {
            Cookies.set('sidebar_minimize_state', 'off');
        } else {
            Cookies.set('sidebar_minimize_state', 'on');
        }
    });
</script>
