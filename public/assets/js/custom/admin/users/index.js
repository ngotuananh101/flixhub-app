$(document).ready(function () {
    // Setup var
    const baseToolbar = $('div[data-kt-users-table-toolbar="base"]');
    const selectedToolbar = $('div[data-kt-users-table-toolbar="selected"]');
    const selectedCount = $('span[data-kt-users-table-select="selected_count"]');
    const searchInputElement = $('input[data-kt-users-table-filter="search"]');
    const selectAllCheckbox = $('input[data-kt-users-table-select="select_all"]');
    const deleteUsersButton = $('button[data-kt-users-table-select="delete_selected"]');
    let selected = [];
    let searchInterval = null;
    // Set Datatable
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
            {data: 'username', name: 'username'},
            {data: 'roles', name: 'roles'},
            {data: 'is_active', name: 'is_active'},
            {data: 'last_login_at', name: 'last_login_at'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end'},
        ],
        order: [[2, 'asc']],
    }).on('draw', function () {
        selectAllCheckbox.prop('checked', false);
        selected = [];
        updateToolbar();
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
            deleteSelected(id);
        });

        $('a[data-kt-users-table-filter="block_row"]').on('click', function (event) {
            event.preventDefault();
            const id = $(this).data('id');
            blockSelected(id);
        });
    });
    $('#users-table_reload').on('click', ()=>{
        usersTable.ajax.reload();
    });
    const updateToolbar = () => {
        selectedCount.html(selected.length);
        if (selected.length === 0) {
            baseToolbar.removeClass('d-none');
            selectedToolbar.addClass('d-none');
        } else {
            baseToolbar.addClass('d-none');
            selectedToolbar.removeClass('d-none');
        }
        selectAllCheckbox.prop('checked', selected.length === usersTable.page.info().length);
    };
    searchInputElement.on('keyup', function () {
        if (searchInterval) clearTimeout(searchInterval);
        searchInterval = setTimeout(() => {
            usersTable.search(searchInputElement.val()).draw();
        }, 500);
    });
    selectAllCheckbox.on('change', function () {
        let rows = usersTable.rows({page: 'current'}).nodes();
        console.log(rows);
        let isChecked = selectAllCheckbox.is(':checked');
        $('input[type="checkbox"]', rows).each(function () {
            this.checked = isChecked;
            if (isChecked) {
                if (!selected.includes(this.value)) selected.push(this.value);
            } else {
                selected.splice(selected.indexOf(this.value), 1);
            }
        });
        updateToolbar();
    });
    deleteUsersButton.on('click', function () {
        deleteSelected();
    });
    const deleteSelected = (ids = selected) => {
        if (typeof ids === 'string' || typeof ids === 'number') ids = [ids];
        if (ids.length > 0) {
            swal.fire({
                text: translation.users.actions.delete_confirmation,
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: translation.users.actions.delete_confirm,
                cancelButtonText: translation.users.actions.cancel,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-active-light'
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: usersDeleteApi,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'DELETE',
                            ids: ids,
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            usersTable.ajax.reload();
                        },
                        error: function (response) {
                            toastr.error(response.responseJSON.message);
                        }
                    });
                }
            }); 
        } else {
            toastr.error(translation.users.actions.no_selected);
        }
    };
    const blockSelected = (id) => {
        swal.fire({
            text: translation.users.actions.block_confirmation,
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: translation.users.actions.block_confirm,
            cancelButtonText: translation.users.actions.cancel,
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-active-light'
            }
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: usersUpdateApi,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PUT',
                        action: 'block',
                        id: id,
                    },
                    success: function (response) {
                        toastr.success(response.message);
                        usersTable.ajax.reload();
                    },
                    error: function (response) {
                        toastr.error(response.responseJSON.message);
                    }
                });
            }
        });
    };
});
