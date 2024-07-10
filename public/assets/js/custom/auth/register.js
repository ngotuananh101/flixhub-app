toastr.options = {
    "closeButton": true,
    "progressBar": true,
};

$(document).ready(function () {
    let t = (key, attribute) => {
        let string = validation_lang[key];
        if (attribute !== undefined) {
            string = string.replace(":attribute", attribute);
        }
        return string;
    };
    let form = document.getElementById('sign_up_form');
    let btnSubmit = form.querySelector('#sign_up_submit');
    let validator = FormValidation.formValidation(form, {
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: t("required", "Username"),
                    },
                },
            },
            email: {
                validators: {
                    notEmpty: {
                        message: t("required", "Email"),
                    },
                    emailAddress: {
                        message: t("email", "Email"),
                    },
                },
            },
            password: {
                validators: {
                    notEmpty: {
                        message: t("required", "Password"),
                    },
                }
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
    let submit = (e) => {
        e.preventDefault();
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
                            swal.fire({
                                text: response.message,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: auth_lang['ok'],
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    window.location.href = response.redirect;
                                }
                            });
                        } else {
                            swal.fire({
                                text: response.message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: auth_lang['ok'],
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    btnSubmit.removeAttribute('data-kt-indicator');
                                    btnSubmit.disabled = false;
                                }
                            });
                        }
                    }
                });
            }
        })
    }

    form.addEventListener('submit', submit);
    btnSubmit.addEventListener('click', submit);
});

