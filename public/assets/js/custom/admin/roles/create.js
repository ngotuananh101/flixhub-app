$(document).ready(function () {
    let inputPermissionsElement = $('#inputPermissions');
    $('#permissions_of_role').on('changed.jstree', function (e, data) {
        let i, j;
        let listPermissions = [];
        for(i = 0, j = data.selected.length; i < j; i++) {
            listPermissions.push(data.instance.get_node(data.selected[i]).id);
        }
        inputPermissionsElement.val(listPermissions.join(','));
    }).jstree({
        'plugins': ["wholerow", "checkbox"],
        'core': {
            "themes": {
                "responsive": false
            },
            'data': groupPermission
        },
    });
})
