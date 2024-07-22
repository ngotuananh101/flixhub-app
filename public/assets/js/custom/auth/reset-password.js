$(document).ready(function () {
    let form = document.getElementById('new_password_form');
    let btnSubmit = form.querySelector('#new_password_submit');
    let validator = FormValidation.formValidation(form, {
        fields: {
            password: {
                validators: {
                    notEmpty: {
                        message: t("validation", "required", { attribute: "Password" }),
                    },
                    stringLength: {
                        min: 8,
                        message: function () {
                            return t("validation", "size.string", { attribute: "Password", size: 8 });
                        },
                    },
                },
            },
            password_confirmation: {
                validators: {
                    notEmpty: {
                        message: t("required", "Password Confirmation"),
                    },
                    identical: {
                        compare: function () {
                            return form.querySelector('[name="password"]').value;
                        },
                        message: t("confirmed", "Password Confirmation"),
                    },
                },
            },
            toc: {
                validators: {
                    notEmpty: {
                        message: t("required", "Terms and Conditions"),
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
                                    window.location.href = response.redirect;
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
                    error: function (response) {
                        // Show error message
                        Swal.fire({
                            text: response.responseJSON.message,
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
    };

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        submit();
    });
    btnSubmit.addEventListener('click', function (e) {
        e.preventDefault();
        submit();
    });
});
