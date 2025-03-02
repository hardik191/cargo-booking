var Order_charge = function () {
    var list = function () {

        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#order_charge_list",
            ajaxURL: baseurl + "admin/master-management/order-charge-ajaxcall",
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

        $('body').on('click', '.add-order-charge', function () {

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/master-management/order-charge-ajaxcall",
                data: { 'action': 'add-order-charge' },
                success: function (data) {

                    $('#add_order_charge_modal').modal('show');
                    $('.append-order-charge-data-add').html(data);
                    $('.select3').select2();
                    add_save_order_charge();
                }
            });
        });

        $('body').on('click', '.edit-order-charge', function () {
            var order_charge_id = $(this).data('id');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/master-management/order-charge-ajaxcall",
                data: { 'action': 'edit-order-charge', order_charge_id: order_charge_id },
                success: function (data) {

                    $('#edit_order_charge_modal').modal('show');
                    $('.append-order-charge-data-edit').html(data);
                    $('.select3').select2();
                    edit_save_order_charge();
                }
            });
        });


        // 
        $("body").on("click", ".delete-order-charge, .inactive-order-charge, .active-order-charge", function () {
            var id = $(this).data("id");
            var actionClass = "";
            if ($(this).hasClass("delete-order-charge")) {
                actionClass = ".yes-sure-delete";
            } else if ($(this).hasClass("inactive-order-charge")) {
                actionClass = ".yes-sure-inactive";
            } else if ($(this).hasClass("active-order-charge")) {
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
                    url: baseurl + "admin/master-management/order-charge-ajaxcall",
                    data: { action: "common-order-charge", data: data },
                    success: function (data) {
                        handleAjaxResponse(data);
                    },
                });
            }
        });
    }

function add_save_order_charge() {

    $("#add-save-order-charge-form").validate({
        debug: true,
        errorElement: "span", //default input error message container
        errorClass: "help-block", // default input error message class

        rules: {
            charge_name: { required: true },
            charge_value: { required: true, number: true, min: 1 },
            charge_type: { required: true },
        },

        messages: {
            charge_name: { required: "Please enter charge name." },
            charge_value: { required: "Please enter charge value.", number: "Enter a valid number.", min: "Charge value must be at least 1." },
            charge_type: { required: "Please select charge type." },
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

function edit_save_order_charge() {

    $("#edit-save-order-charge-form").validate({
        debug: true,
        errorElement: "span", //default input error message container
        errorClass: "help-block", // default input error message class

        rules: {
            charge_name: { required: true },
            charge_value: { required: true, number: true, min: 1 },
            edit_charge_type: { required: true },
        },

        messages: {
            charge_name: { required: "Please enter charge name." },            
            charge_value: { required: "Please enter charge value.", number: "Enter a valid number.", min: "Charge value must be at least 1." },
            edit_charge_type: { required: "Please select charge type." },
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
