var Login = function(){
    var list = function(){
        var validateTrip = true;
        var customValid = true;

        $('#login-form').validate({
            debug: true,
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class

            rules : {
                email: {required: true,email:true},
                // password: { required: true },
            },

            messages : {

                email: {
                    required: "Please enter your register email address",
                    email: "Please enter valid email address"
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

                $(".submitbtn:visible").attr("disabled", "disabled");
                $("#loader").show();
                customValid = customerInfoValid();
                if (customValid)
                {
                    var options = {
                        resetForm: false, // reset the form after successful submit
                        success: function (output) {
                            handleAjaxResponse(output);
                        }
                    };
                    $(form).ajaxSubmit(options);
                }else{
                    $(".submitbtn:visible").prop("disabled",false);
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

        function customerInfoValid() {
            var customValid = true;


          var pass_val =  $('.password-required').val();
        //   alert(pass_val);

            if (pass_val == '' || pass_val == 0) {
                // alert('hi');
                $('.password-error').text('Please enter password');
                customValid = false;
            } else {
                $('.password-error').text('');
            }

            return customValid;
        }
    }

    return{
        init: function(){
            list();
        }
    }
}();
