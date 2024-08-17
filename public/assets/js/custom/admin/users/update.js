$(document).ready(function () {
    let table_users_login_session = $('#kt_table_users_login_session').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": userSession,
            "type": "POST",
            "data": {
                _token: $('meta[name="csrf-token"]').attr('content'),
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'browser', name: 'browser'},
            {data: 'platform', name: 'platform'},
            {data: 'ip', name: 'ip'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'status', name: 'status'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ],
    })
});

function checkLocation(id) {
    swal.fire({
        text: t('admin', 'users.actions.checking_location'),
        icon: 'warning',
        confirmButtonText: t('admin', 'users.actions.checking_location_confirm'),
        didOpen: function() {
            swal.showLoading();
            $.ajax({
                url: userSessionCheckLocation,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                },
                success: function (response) {
                    swal.close();
                    if (response.success) {
                        toastr.success(response.message);
                        $('#location').html(response.position);
                        $('#kt_modal_user_location').modal('show');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (response) {
                    toastr.error(response.responseJSON.message);
                }
            });
        }
    })
}
