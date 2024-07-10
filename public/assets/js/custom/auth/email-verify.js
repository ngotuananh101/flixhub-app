$(document).ready(function () {
    let form = $('#verify_form');
    let submitButton = document.querySelector("#verify_submit");
    form.submit(function (e) {
        e.preventDefault();
        // Show loading indication
        submitButton.setAttribute("data-kt-indicator", "on");
        submitButton.disabled = true;
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function (data) {
                if (data.status === 'success') {
                    form[0].reset();
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;
                } else {
                    // Show popup warning
                    Swal.fire({
                        text: data.message,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                    // Remove loading indication
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;
                }
            },
            error: function (data) {
                // Show popup warning
                Swal.fire({
                    text: data.responseJSON.message,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
                // Remove loading indication
                submitButton.removeAttribute("data-kt-indicator");
                submitButton.disabled = false;
            },
        });
    });
});
