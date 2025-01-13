var Forgot_password = function(){
    var list = function(){
        var form = $('#forgot-password');
        var rules = {
            email: {
                required: true,
                email: true
            }
        };

        var message = {
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address" // Custom message for invalid email format
            }
        };
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    var reset = function(){

        $('#reset-password').validate({
            debug: true,
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class

            rules : {
                email: {required: true,email:true},
                // password: { required: true },
            },

            messages : {

                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
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
                if (customValid)
                {
                    var options = {
                        resetForm: false, // reset the form after successful submit
                        success: function (output) {
                            handleAjaxResponse(output);
                        },
                        error: function(xhr, status, error) {
                            serverSideErrorMsg(xhr, status, error);
                        }
                    };
                    $(form).ajaxSubmit(options);
                }else{
                    $(".submitbtn:visible").attr("data-kt-indicator", "off").attr("disabled", false);
                    $("#loader").hide();
                }
            },

            errorPlacement: function(error, element) {
                customValid = customerInfoValid();
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + elem.attr("id") + "-container").parent();
                    error.insertAfter(element);
                }else {
                    if (elem.hasClass("radio-btn")) {
                        element = elem.parent().parent();
                        error.insertAfter(element);
                    }else{
                        error.insertAfter(element);
                    }
                }
            },
        });

        $.validator.addMethod("validatePassword", function(value, element) {
            // Ensure 'this' refers to the validator
            var validator = this;
            return validator.optional(element) || /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(value);
        }, "Please enter a valid password (at least one uppercase letter, one lowercase letter, and one number).");

        function customerInfoValid() {
            var customValid = true;

            var pass_val = $('#password').val();
            var confirm_pass_val = $('#confirm_password').val();

            // Validate using the validatePassword method
            if (pass_val == '' || pass_val == 0 || !$.validator.methods.validatePassword.call($('#reset-password').validate(), pass_val, $('#password')[0])) {
                if (pass_val == '' || pass_val == 0) {
                    $('.password-error').text('Please enter password');
                } else {
                    $('.password-error').text('Please enter valid password');
                }
                customValid = false;
            } else {
                $('.password-error').text('');
            }

            if (confirm_pass_val == '' || confirm_pass_val !== pass_val) {
                if (confirm_pass_val == '') {
                    $('.confirm-password-error').text('Please confirm your password');
                } else {
                    $('.confirm-password-error').text('Confirm password do not match');
                }
                customValid = false;
            } else {
                $('.confirm-password-error').text('');
            }

            return customValid;
        }
    }

    return{
        init: function(){
            list();
        },
        reset: function(){
            reset();
        }
    }
}();
