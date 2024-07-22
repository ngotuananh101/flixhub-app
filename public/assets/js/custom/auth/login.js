toastr.options = {
    "closeButton": true,
    "progressBar": true,
};

$(document).ready(function () {
    let form = document.querySelector("#sign_in_form");
    let submitButton = document.querySelector("#kt_sign_in_submit");
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
            password: {
                validators: {
                    notEmpty: {
                        message: t("validation", "required", { attribute: "Password" }),
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

    submitButton.addEventListener("click", function (event) {
        // Prevent default button action
        event.preventDefault();
        // Validate form
        validator.validate().then(function (status) {
            if (status === "Valid") {
                // Show loading indication
                submitButton.setAttribute("data-kt-indicator", "on");
                submitButton.disabled = true;
                // Send ajax request
                $.ajax({
                    url: form.getAttribute("action"),
                    type: "POST",
                    data: $(form).serialize(),
                    success: function (response) {
                        // Form is validated, submit
                        if (response.status === "success") {
                            // Redirect to the next page
                            window.location.href = response.redirect;
                        } else {
                            // Show popup warning
                            Swal.fire({
                                text: response.message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            });
                        }
                        // Remove loading indication
                        submitButton.removeAttribute("data-kt-indicator");
                        submitButton.disabled = false;
                    },
                    error: function (response) {
                        // Show popup warning
                        Swal.fire({
                            text: response.responseJSON.message,
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
            } else {
                // Show popup warning
                Swal.fire({
                    text: "Sorry, looks like there are some errors detected, please try again.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                });
            }
        });
    });
});
