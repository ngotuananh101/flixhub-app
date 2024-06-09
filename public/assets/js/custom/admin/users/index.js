$(document).ready(function () {
    const baseToolbar = $('div[data-kt-users-table-toolbar="base"]');
    const selectedToolbar = $('div[data-kt-users-table-toolbar="selected"]');
    const selectedCount = $('span[data-kt-users-table-select="selected_count"]');
    const searchInputElement = $('input[data-kt-users-table-filter="search"]');
    const selectAllCheckbox = $('input[data-kt-users-table-select="select_all"]');
    let selected = [];
    let currentPageLength = 0;
    let searchInterval = null;

    const updateToolbar = () => {
        selectedCount.html(selected.length);
        if (selected.length === 0) {
            baseToolbar.removeClass('d-none');
            selectedToolbar.addClass('d-none');
        } else {
            baseToolbar.addClass('d-none');
            selectedToolbar.removeClass('d-none');
        }
        selectAllCheckbox.prop('checked', selected.length === currentPageLength);
    };

    const usersTable = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: usersTableApi,
            type: 'POST',
            data: (d) => {
                d._token = $('meta[name="csrf-token"]').attr('content');
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'roles', name: 'roles'},
            {data: 'is_active', name: 'is_active'},
            {data: 'last_login_at', name: 'last_login_at'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end'},
        ],
        order: [[1, 'asc']],
    }).on('draw', function () {
        currentPageLength = usersTable.page.info().recordsDisplay;
        selected = [];
        const rows = usersTable.rows({page: 'current'}).nodes();
        $('input[type="checkbox"]', rows).on('change', function () {
            if (this.checked) {
                selected.push(this.value);
            } else {
                selected.splice(selected.indexOf(this.value), 1);
            }
            updateToolbar();
        });
        KTMenu.createInstances();
        $('a[data-kt-users-table-filter="delete_row"]').on('click', function (event) {
            event.preventDefault();
            const id = $(this).data('id');
            console.log(id)
            deleteSelected(id);
        })
    });
});
