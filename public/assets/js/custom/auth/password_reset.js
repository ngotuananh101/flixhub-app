$(document).ready(function () {
    let form = document.getElementById('password_reset_form');
    let btnSubmit = form.querySelector('#password_reset_submit');
    var validator = FormValidation.formValidation(form, {
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: t("validation", "required", { attribute: "Email" }),
                    },
                    emailAddress: {
                        message: t("validation", "email"),
                    },
                },
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: ".fv-row",
                eleInvalidClass: "",
                eleValidClass: "",
            }),
        },
    });

    btnSubmit.addEventListener('click', function (event) {
        event.preventDefault();
        submit();
    });
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        submit();
    });

    let submit = () => {
        validator.validate().then(function (status) {
            if (status === 'Valid') {
                btnSubmit.setAttribute('data-kt-indicator', 'on');
                btnSubmit.disabled = true;
                $.ajax({
                    url: form.getAttribute('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status === 'success') {
                            // Show success message
                            Swal.fire({
                                text: response.message,
                                icon: 'success',
                                buttonsStyling: false,
                                confirmButtonText: auth_lang['ok'],
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    // Reset form
                                    form.reset();
                                    btnSubmit.removeAttribute('data-kt-indicator');
                                    btnSubmit.disabled = false;
                                }
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                text: response.message,
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: auth_lang['ok'],
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    btnSubmit.removeAttribute('data-kt-indicator');
                                    btnSubmit.disabled = false;
                                }
                            });
                        }
                    },
                    error: function (data) {
                        // Show error message
                        Swal.fire({
                            text: data.responseJSON.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: auth_lang['ok'],
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            }
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                btnSubmit.removeAttribute('data-kt-indicator');
                                btnSubmit.disabled = false;
                            }
                        });
                    }
                });
            }
        });
    }
});
