var Port = function () {
    var list = function () {

        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#port_list",
            ajaxURL: baseurl + "admin/master-management/port-ajaxcall",
            ajaxAction: "getdatatable",
            postData: dataArr,
            hideColumnList: [],
            noSortingApply: [ 4],
            noSearchApply: [0, 4],
            defaultSortColumn: [0],
            defaultSortOrder: "DESC",
            setColumnWidth: columnWidth,
        };
        getDataTable(arrList);

        $('body').on('click', '.add-port', function () {

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/master-management/port-ajaxcall",
                data: { 'action': 'add-port' },
                success: function (data) {

                    $('#add_port_modal').modal('show');
                    $('.append-port-data-add').html(data);

                    add_save_port();
                }
            });
        });

        $('body').on('click', '.edit-port', function () {
            var port_id = $(this).data('id');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/master-management/port-ajaxcall",
                data: { 'action': 'edit-port', port_id: port_id },
                success: function (data) {

                    $('#edit_port_modal').modal('show');
                    $('.append-port-data-edit').html(data);

                    edit_save_port();
                }
            });
        });


        // 
        $("body").on("click", ".delete-port, .inactive-port, .active-port", function () {
            var id = $(this).data("id");
            var actionClass = "";
            if ($(this).hasClass("delete-port")) {
                actionClass = ".yes-sure-delete";
            } else if ($(this).hasClass("inactive-port")) {
                actionClass = ".yes-sure-inactive";
            } else if ($(this).hasClass("active-port")) {
                actionClass = ".yes-sure-active";
            }
            setTimeout(function () { $(actionClass + ":visible").attr("data-id", id); }, 500);
        });

        $("body").on("click", ".yes-sure-delete, .yes-sure-inactive, .yes-sure-active", function () {
            $(".submitbtn:visible").attr("data-kt-indicator", "on").attr("disabled", true);
            var id = $(this).attr("data-id");
            var type = "";
            $(".yes-sure-delete, .yes-sure-inactive, .yes-sure-active").removeAttr("data-id");

            if ($(this).hasClass("yes-sure-delete")) {
                type = "3";
            } else if ($(this).hasClass("yes-sure-inactive")) {
                type = "2";
            } else if ($(this).hasClass("yes-sure-active")) {
                type = "1";
            }
            var data = { id: id, type: type, _token: $("#_token").val() };
            console.log(data);
            if (id) {
                $.ajax({
                    type: "POST",
                    headers: { "X-CSRF-TOKEN": $('input[name="_token"]').val(), },
                    url: baseurl + "admin/master-management/port-ajaxcall",
                    data: { action: "common-port", data: data },
                    success: function (data) {
                        handleAjaxResponse(data);
                    },
                });
            }
        });
    }

function add_save_port() {

    $("#add-save-port-form").validate({
        debug: true,
        errorElement: "span", //default input error message container
        errorClass: "help-block", // default input error message class

        rules: {
            port_name: { required: true },
            // start_date: { required: true },
        },

        messages: {
            port_name: { required: "Please enter port name." },
            // start_date: { required: "Please enter start date." },
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
                element = $(
                    "#select2-" + elem.attr("id") + "-container"
                ).parent();
                error.insertAfter(element);
            }
            // Handle radio buttons (e.g., pass_to_inspection)
            else if (elem.is(":radio")) {
                // If the element is a radio button, find the closest .form-check-custom container
                var radioGroup = elem.closest(".form-check-radio-custom");

                // Insert the error message after the radio group container
                error.insertAfter(radioGroup);
            }
            // Handle other elements (e.g., text inputs)
            else {
                error.insertAfter(element);
            }
        },
    });

    function customerInfoValid() {
        var customValid = true;

        return customValid;
    }
}

function edit_save_port() {

    $("#edit-save-port-form").validate({
        debug: true,
        errorElement: "span", //default input error message container
        errorClass: "help-block", // default input error message class

        rules: {
            port_name: { required: true },
            // start_date: { required: true },
        },

        messages: {
            port_name: { required: "Please enter port name." },
            // start_date: { required: "Please enter start date." },
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
                element = $(
                    "#select2-" + elem.attr("id") + "-container"
                ).parent();
                error.insertAfter(element);
            }
            // Handle radio buttons (e.g., pass_to_inspection)
            else if (elem.is(":radio")) {
                // If the element is a radio button, find the closest .form-check-custom container
                var radioGroup = elem.closest(".form-check-radio-custom");

                // Insert the error message after the radio group container
                error.insertAfter(radioGroup);
            }
            // Handle other elements (e.g., text inputs)
            else {
                error.insertAfter(element);
            }
        },
    });

    function customerInfoValid() {
        var customValid = true;

        return customValid;
    }
}
    return {
        init: function () {
            list();
        }
    }
}();
