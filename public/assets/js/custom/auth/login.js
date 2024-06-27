$(document).ready(function () {
    let form = document.querySelector("#sign_in_form");
    let submitButton = document.querySelector("#kt_sign_in_submit");
    var validator = FormValidation.formValidation(form, {
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: "Email is required",
                    },
                    emailAddress: {
                        message: "The value is not a valid email address",
                    },
                },
            },
            password: {
                validators: {
                    notEmpty: {
                        message: "Password is required",
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
                // Simulate form submission
                setTimeout(function () {
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;
                    // Show popup confirmation
                    Swal.fire({
                        text: "You have successfully logged in!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            // Reset form
                            form.reset();
                            // Hide modal
                            $("#kt_modal_sign_in").modal("hide");
                        }
                    });
                }, 2000);
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