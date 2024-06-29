$(document).ready(function() {
    let t = (key, attribute) => {
        let string = validation_lang[key];
        if (attribute !== undefined) {
            string = string.replace(":attribute", attribute);
        }
        return string;
    };
    let form = document.getElementById('password_reset_form');
    let btnSubmit = form.querySelector('#password_reset_submit');
    var validator = FormValidation.formValidation(form, {
        fields: {
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

    btnSubmit.addEventListener('click', function(event) {
        event.preventDefault();
        validator.validate().then(function(status) {
            if (status === 'Valid') {
                btnSubmit.setAttribute('data-kt-indicator', 'on');
                btnSubmit.disabled = true;
                $.ajax({
                    url: form.getAttribute('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            // Show success message
                            Swal.fire({
                                text: response.message || 'All is cool! Now you submit this form',
                                icon: 'success',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, got it!',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            }).then(function(result) {
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
                                confirmButtonText: 'Ok, got it!',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    btnSubmit.removeAttribute('data-kt-indicator');
                                    btnSubmit.disabled = false;
                                }
                            });
                        }
                    }
                });
            } else {
                // Show error message
                Swal.fire({
                    text: auth_lang['general_error'],
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok, got it!',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }
        });
    });
});