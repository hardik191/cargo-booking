var Sign_up = function () {

    var add_customer = function () {

        $(document).ready(function () {
            var input = document.querySelector("#phone_no");
            var iti = window.intlTelInput(input, {
                initialCountry: "in",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js" // for formatting/placeholders etc
            });

            // Listen for the country change event
            input.addEventListener('countrychange', function () {
                // Get the selected country data
                var countryData = iti.getSelectedCountryData();
                // Get the country code
                var countryCode = countryData.dialCode;
                $('#country_code').val(countryCode);
            });
        });

        var validateTrip = true;
        var customValid = true;
        $('#sign-up-form').validate({
            debug: true,
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class

            rules: {
                name: { required: true },
                email: {
                    required: true,
                    email: true
                },
                phone_no: {
                    required: true,
                    digits: true
                },

            },

            messages: {
                name: { required: "Please enter a name" },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                phone_no: { required: "Please enter phone number", digits: "Please enter only digits for the mobile number" },
            },

            invalidHandler: function (event, validator) {
                validateTrip = false;
                customValid = customerInfoValid(); // Ensure custom validation is run
            },

            submitHandler: function (form) {

                $(".submitbtn:visible").attr("data-kt-indicator", "on").attr("disabled", true);
                $("#loader").show();
                customValid = customerInfoValid();
                if (customValid) {
                    var options = {
                        resetForm: false, // reset the form after successful submit
                        success: function (output) {
                            handleAjaxResponse(output);
                        },
                        error: function (xhr, status, error) {
                            serverSideErrorMsg(xhr, status, error);
                        }
                    };
                    $(form).ajaxSubmit(options);
                } else {
                    $(".submitbtn:visible").attr("data-kt-indicator", "off").attr("disabled", false);
                    $("#loader").hide();
                }
            },

            errorPlacement: function (error, element) {
                customValid = customerInfoValid();
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + elem.attr("id") + "-container").parent();
                    error.insertAfter(element);
                } else {
                    if (elem.hasClass("radio-btn")) {
                        element = elem.parent().parent();
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            },
        });

        $.validator.addMethod("validatePassword", function (value, element) {
            // Ensure 'this' refers to the validator
            var validator = this;
            return validator.optional(element) || /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(value);
        }, "Please enter a valid password (at least one uppercase letter, one lowercase letter, and one number).");

        function customerInfoValid() {
            var customValid = true;

            var pass_val = $('#password').val();
            var confirm_pass_val = $('#confirm_password').val();

            // Validate password using the validatePassword method
            if (pass_val === '' || pass_val === 0 || !$.validator.methods.validatePassword.call($('#sign-up-form').validate(), pass_val, $('#password')[0])) {
                if (pass_val === '' || pass_val === 0) {
                    $('.password-error').text('Please enter password');
                } else {
                    $('.password-error').text('Please enter a valid password (at least one letter, one number, and one special character)');
                }
                customValid = false;
            } else {
                $('.password-error').text('');
            }

            // Validate confirm password
            if (confirm_pass_val === '' || confirm_pass_val !== pass_val) {
                if (confirm_pass_val === '') {
                    $('.confirm-password-error').text('Please confirm your password');
                } else {
                    $('.confirm-password-error').text('Confirm password does not match');
                }
                customValid = false;
            } else {
                $('.confirm-password-error').text('');
            }


            return customValid;
        }

    }

    var login = function () {
        var validateTrip = true;
        var customValid = true;

        $('#sign-in-form').validate({
            debug: true,
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class

            rules: {
                login: { required: true },
                // password: { required: true },
            },

            messages: {

                login: {
                    required: "Please enter your valid email or mobile no ",

                },

                // password: {
                //     required: "Please enter employee password",
                // },
            },

            invalidHandler: function (event, validator) {
                validateTrip = false;
                customValid = customerInfoValid();

            },

            submitHandler: function (form) {

                $(".submitbtn:visible").attr("data-kt-indicator", "on").attr("disabled", true);

                $("#loader").show();
                customValid = customerInfoValid();
                if (customValid) {
                    var options = {
                        resetForm: false, // reset the form after successful submit
                        success: function (output) {
                            handleAjaxResponse(output);
                        }
                    };
                    $(form).ajaxSubmit(options);
                } else {
                    $(".submitbtn:visible").prop("disabled", false);
                    $("#loader").hide();
                }
            },

            errorPlacement: function (error, element) {
                customValid = customerInfoValid();
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + elem.attr("id") + "-container").parent();
                    error.insertAfter(element);
                } else {
                    if (elem.hasClass("radio-btn")) {
                        element = elem.parent().parent();
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            },
        });

        function customerInfoValid() {
            var customValid = true;

            var pass_val = $('#password').val();

            if (pass_val == '' || pass_val == 0) {
                $('.password-error').text('Please enter password');
                customValid = false;
            } else {
                $('.password-error').text('');
            }

            return customValid;
        }
    }

    return {
        add: function () {
            add_customer();
        },
        login: function () {
            login();
        }
    }
}();
