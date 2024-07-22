$(document).ready(function () {
    const baseToolbar = $('div[data-kt-roles-table-toolbar="base"]');
    const selectedToolbar = $('div[data-kt-roles-table-toolbar="selected"]');
    const selectedCount = $('span[data-kt-roles-table-select="selected_count"]');
    const searchInputElement = $('input[data-kt-roles-table-filter="search"]');
    const selectAllCheckbox = $('input[data-kt-roles-table-select="select_all"]');
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

    const rolesTable = $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: rolesTableApi,
            type: 'POST',
            data: (d) => {
                d._token = $('meta[name="csrf-token"]').attr('content');
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'guard_name', name: 'guard_name'},
            {data: 'is_default', name: 'is_default'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end'},
        ],
        order: [[1, 'asc']],
    }).on('draw', function () {
        currentPageLength = rolesTable.page.info().recordsDisplay;
        selected = [];
        const rows = rolesTable.rows({page: 'current'}).nodes();
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
        })
    });

    $('#roles-table_reload').on('click', function () {
        rolesTable.ajax.reload();
    });

    searchInputElement.on('keyup', function () {
        if (searchInterval) clearTimeout(searchInterval);
        searchInterval = setTimeout(() => {
            rolesTable.search(searchInputElement.val()).draw();
        }, 500);
    });

    selectAllCheckbox.on('change', function () {
        const rows = rolesTable.rows({page: 'current'}).nodes();
        const isChecked = selectAllCheckbox.is(':checked');
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

    const deleteSelectedButton = $('button[data-kt-roles-table-select="delete_selected"]');
    deleteSelectedButton.on('click', function () {
        deleteSelected();
    });
    const deleteSelected = (ids = selected) => {
        if (typeof ids === 'string' || typeof ids === 'number') ids = [ids];
        if (ids.length > 0) {
            Swal.fire({
                text: t('admin', 'roles.actions.delete_confirmation'),
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: t('admin', 'roles.actions.delete_confirm'),
                cancelButtonText: t('admin', 'roles.actions.cancel'),
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                },
                backdrop: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise(function (resolve) {
                        $.ajax({
                            url: rolesTableDeleteApi,
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                _method: 'DELETE',
                                ids: ids
                            },
                            success: function (data) {
                                resolve(data);
                                rolesTable.ajax.reload();
                            },
                            error: function (data) {
                                Swal.fire({
                                    text: data.responseJSON.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        } else {
            Swal.fire({
                text: "Please select at least one row.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    };
});
