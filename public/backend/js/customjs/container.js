var Container = function () {
    var list = function () {

        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#container_list",
            ajaxURL: baseurl + "admin/master-management/container-ajaxcall",
            ajaxAction: "getdatatable",
            postData: dataArr,
            hideColumnList: [],
            noSortingApply: [ 5],
            noSearchApply: [0, 5],
            defaultSortColumn: [0],
            defaultSortOrder: "DESC",
            setColumnWidth: columnWidth,
        };
        getDataTable(arrList);

        $('body').on('click', '.add-container', function () {

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/master-management/container-ajaxcall",
                data: { 'action': 'add-container' },
                success: function (data) {

                    $('#add_container_modal').modal('show');
                    $('.append-container-data-add').html(data);

                    add_save_container();
                }
            });
        });

        $('body').on('click', '.edit-container', function () {
            var container_id = $(this).data('id');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/master-management/container-ajaxcall",
                data: { 'action': 'edit-container', container_id: container_id },
                success: function (data) {

                    $('#edit_container_modal').modal('show');
                    $('.append-container-data-edit').html(data);

                    edit_save_container();
                }
            });
        });


        // 
        $("body").on("click", ".delete-container, .inactive-container, .active-container", function () {
            var id = $(this).data("id");
            var actionClass = "";
            if ($(this).hasClass("delete-container")) {
                actionClass = ".yes-sure-delete";
            } else if ($(this).hasClass("inactive-container")) {
                actionClass = ".yes-sure-inactive";
            } else if ($(this).hasClass("active-container")) {
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
                    url: baseurl + "admin/master-management/container-ajaxcall",
                    data: { action: "common-container", data: data },
                    success: function (data) {
                        handleAjaxResponse(data);
                    },
                });
            }
        });
    }

function add_save_container() {

    $("#add-save-container-form").validate({
        debug: true,
        errorElement: "span", //default input error message container
        errorClass: "help-block", // default input error message class

        rules: {
            container_type: { required: true },
            // max_container: { required: true, digits: true, min: 1 },
            max_capacity: { required: true, digits: true, min: 1 },
            capacity_unit: { required: true },
            base_price: { required: true, number: true, min: 1 },
            status: { required: true }
        },

        messages: {
            container_type: { required: "Please enter container type." },
            // max_container: { required: "Please enter max container.", digits: "Only numbers allowed.", min: "Container must be at least 1." },
            max_capacity: { required: "Please enter max capacity.", digits: "Only numbers allowed.", min: "Capacity must be at least 1." },
            capacity_unit: { required: "Please select a capacity unit." },
            base_price: { required: "Please enter a base price.", number: "Enter a valid number.", min: "Base price must be at least 1." },
            status: { required: "Please select a status." }
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
            element = $("#select2-" + elem.attr("id") + "-container").parent();
                error.insertAfter(element);
            }
            // Handle Radio Buttons (Capacity Unit & Status)
            else if (elem.is(":radio")) {
                var radioGroup = elem.closest(".form-check-radio-custom");
                if (radioGroup.length) {
                    error.insertAfter(radioGroup);
                } else {
                    error.insertAfter(elem.closest("div")); // Fallback for radio buttons
                }
            }
            // Default error placement for other elements
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

function edit_save_container() {

    $("#edit-save-container-form").validate({
        debug: true,
        errorElement: "span", //default input error message container
        errorClass: "help-block", // default input error message class

        rules: {
            container_type: { required: true },
            // max_container: { required: true, digits: true, min: 1 },
            max_capacity: { required: true, digits: true, min: 1 },
            capacity_unit: { required: true },
            base_price: { required: true, number: true, min: 1 },
            status: { required: true }
        },

        messages: {
            container_type: { required: "Please enter container type." },
            // max_container: { required: "Please enter max container.", digits: "Only numbers allowed.", min: "Container must be at least 1." },
            max_capacity: { required: "Please enter max capacity.", digits: "Only numbers allowed.", min: "Capacity must be at least 1." },
            capacity_unit: { required: "Please select a capacity unit." },
            base_price: { required: "Please enter a base price.", number: "Enter a valid number.", min: "Base price must be at least 1." },
            status: { required: "Please select a status." }
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
            element = $("#select2-" + elem.attr("id") + "-container").parent();
                error.insertAfter(element);
            }
            // Handle Radio Buttons (Capacity Unit & Status)
            else if (elem.is(":radio")) {
                var radioGroup = elem.closest(".form-check-radio-custom");
                if (radioGroup.length) {
                    error.insertAfter(radioGroup);
                } else {
                    error.insertAfter(elem.closest("div")); // Fallback for radio buttons
                }
            }
            // Default error placement for other elements
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
