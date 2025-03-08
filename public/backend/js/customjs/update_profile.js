var Update_profile = function()
{
    var list = function(){
        var form = $('#update-profile');
        var rules = {
            name : {required: true},
            // last_name : {required: true},
            email: {required: true,email:true},
        };

        var message = {
            name : {required: "Please enter your name"},
            // last_name : {required: "Please enter your last name"},
            email :{
                required : "Please enter your register email address",
                email: "Please enter valid email address"
            },

        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    var change_save_password = function () {
        var validateTrip = true;
        var customValid = true;

        $("#change-password-form").validate({
            debug: true,
            errorElement: "span", //default input error message container
            errorClass: "help-block", // default input error message class

            rules: {
                leval_one_status: {
                    required: function () {
                        return !$(".leval_one_status").is(":checked");
                    },
                },
            },

            messages: {
                leval_one_status: {
                    required: "Please select leval one status",
                },
            },

            invalidHandler: function (event, validator) {
                validateTrip = false;
                customValid = customerInfoValid();
            },

            submitHandler: function (form) {
                $(".submitbtn:visible")
                    .attr("data-kt-indicator", "on")
                    .attr("disabled", true);
                $("#loader").show();
                customValid = customerInfoValid();
                if (customValid) {
                    var options = {
                        resetForm: false, // reset the form after successful submit
                        success: function (output) {
                            handleAjaxResponse(output);
                        },
                    };
                    $(form).ajaxSubmit(options);
                } else {
                    $(".submitbtn:visible")
                        .attr("data-kt-indicator", "off")
                        .attr("disabled", false);
                    $("#loader").hide();
                }
            },

            errorPlacement: function (error, element) {
                customValid = customerInfoValid();
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    var parent = element.next(".select2-container");
                    error.insertAfter(parent);
                } else if (elem.is(":radio")) {
                    var radioGroup = elem.closest(".form-check-radio-custom");
                    error.insertAfter(radioGroup);
                } else {
                    error.insertAfter(element);
                }
            },
        });

        var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

        function customerInfoValid() {
            var customValid = true;

            var newPassword = $("#new_password").val();

            // Validate Old Password
            if (!$("#old_password").val()) {
                $(".old-password-error").text("Please enter old password");
                customValid = false;
            } else {
                $(".old-password-error").text("");
            }

            // Validate New Password (Required)
            if (!newPassword) {
                $(".new-password-error").text("Please enter new password");
                customValid = false;
            } 
                // Validate Password Strength (Check against validatePassword regex)

            if (!passwordPattern.test(newPassword)) {
                $(".new-password-error").text("Please enter valid password");
                customValid = false;
            } else {
                $(".new-password-error").text("");
            }

            // Validate Confirm Password
            if (!$("#confirm_password").val()) {
                $(".confirm-password-error").text("Please enter confirm password");
                customValid = false;
            } else if ($("#confirm_password").val() !== newPassword) {
                $(".confirm-password-error").text("Passwords do not match");
                customValid = false;
            } else {
                $(".confirm-password-error").text("");
            }


            return customValid;
        }
    };
    
    return {
        init: function(){
            list();
        },
        change_password: function () {
            change_save_password();
        },
    }
}
();
