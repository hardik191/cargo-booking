var Admin = function(){
    var list = function(){
        // alert('HI');
        function fillterSearch(){
            var role_id = $('#role_id').val();
            var dataArr = {  role_id : role_id};
            var columnWidth = { width: "5%", targets: 0 };
            var arrList = {
                tableID: "#admin_list",
                ajaxURL: baseurl + "admin/user-management/admin-ajaxcall",
                ajaxAction: "getdatatable",
                postData: dataArr,
                hideColumnList: [],
                noSortingApply: [0, 7],
                noSearchApply: [0, 7],
                defaultSortColumn: [0],
                defaultSortOrder: "DESC",
                setColumnWidth: columnWidth,
            };
            getDataTable(arrList);
        }

        fillterSearch();

        $("body").on("change", "#role_id", function () {
            fillterSearch();
        });

        $("body").on("click", ".delete-user, .inactive-user, .active-user", function() {
            var id = $(this).data('id');
            var actionClass = '';

            if ($(this).hasClass('delete-user')) {
                actionClass = '.yes-sure-delete';
            } else if ($(this).hasClass('inactive-user')) {
                actionClass = '.yes-sure-inactive';
            } else if ($(this).hasClass('active-user')) {
                actionClass = '.yes-sure-active';
            }

            setTimeout(function() {
                $(actionClass + ':visible').attr('data-id', id);
            }, 500);
        });

        $('body').on('click', '.yes-sure-delete, .yes-sure-inactive, .yes-sure-active', function() {
            $(".submitbtn:visible").attr("data-kt-indicator", "on").attr("disabled", true);
            var id = $(this).attr('data-id');
            var type = '';
            $('.yes-sure-delete, .yes-sure-inactive, .yes-sure-active').removeAttr('data-id');

            if ($(this).hasClass('yes-sure-delete')) {
                type = '3';
            } else if ($(this).hasClass('yes-sure-inactive')) {
                type = '2';
            } else if ($(this).hasClass('yes-sure-active')) {
                type = '1';
            }
            var data = { id: id, type: type, _token: $('#_token').val() };
            if(id){
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/user-management/admin-ajaxcall",
                    data: { 'action': 'common-user', 'data': data },
                    success: function(data) {
                        handleAjaxResponse(data);
                    }
                });
            }
        });
    }

    var add_admin = function(){

        $(document).ready(function() {
            var input = document.querySelector("#phone_no");
            var iti = window.intlTelInput(input, {
                initialCountry: "in",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js" // for formatting/placeholders etc
            });

            // Listen for the country change event
            input.addEventListener('countrychange', function() {
                // Get the selected country data
                var countryData = iti.getSelectedCountryData();
                // Get the country code
                var countryCode = countryData.dialCode;
                $('#country_code').val(countryCode);
            });
        });

        var validateTrip = true;
        var customValid = true;
        $('#add_admin_user_form').validate({
            debug: true,
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class

            rules : {
                email: {required: true,email:true},
                name: { required: true },
                phone_no: { required: true, digits: true },
                role: { required: true },
                department: { required: true },
            },

            messages : {
                name: { required: "Please enter a name" },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                phone_no: { required: "Please enter phone number", digits: "Please enter only digits for the mobile number" },
                role: { required: "Please select a role" },
                department: { required: "Please select a department" },
            },

            invalidHandler: function (event, validator) {
                validateTrip = false;
                customValid = customerInfoValid(); // Ensure custom validation is run
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

            // Validate password using the validatePassword method
            if (pass_val === '' || pass_val === 0 || !$.validator.methods.validatePassword.call($('#add_admin_user_form').validate(), pass_val, $('#password')[0])) {
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

    var edit_admin = function(){

        $(document).ready(function() {
            var input = document.querySelector("#phone_no");
            var iti = window.intlTelInput(input, {
                initialCountry: "in",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js" // for formatting/placeholders etc
            });

            // Listen for the country change event
            input.addEventListener('countrychange', function() {
                // Get the selected country data
                var countryData = iti.getSelectedCountryData();
                // Get the country code
                var countryCode = countryData.dialCode;
                $('#country_code').val(countryCode);
            });
        });

        var validateTrip = true;
        var customValid = true;
        $('#edit_admin_user_form').validate({
            debug: true,
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class

            rules : {
                email: {required: true,email:true},
                name: { required: true },
                phone_no: { required: true, digits: true },
                role: { required: true },
                department: { required: true },
            },

            messages : {
                name: { required: "Please enter a name" },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                phone_no: { required: "Please enter phone number", digits: "Please enter only digits for the mobile number" },
                role: { required: "Please select a role" },
                department: { required: "Please select a department" },
            },

            invalidHandler: function (event, validator) {
                validateTrip = false;
                customValid = customerInfoValid(); // Ensure custom validation is run
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
           
            if (pass_val !== '' || confirm_pass_val !== '') {
                // Validate password
                if (pass_val === '' || !$.validator.methods.validatePassword.call($('#edit_admin_user_form').validate(), pass_val, $('#password')[0])) {
                    if (pass_val === '') {
                        $('.password-error').text('Please enter a password');
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
            } else {
                // If both fields are empty, clear any previous error messages
                $('.password-error').text('');
                $('.confirm-password-error').text('');
            }


            return customValid;
        }

    }

    return {
        init: function(){
            list();
        },
        add: function(){
            add_admin();
        },
        edit: function(){
            edit_admin();
        }
    }
}();
