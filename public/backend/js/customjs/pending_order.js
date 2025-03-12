var Pending_order = (function () {
    var list = function () {

        function filterSearch() {
            var sender_port = $('.sender_port').val();
            var receiver_port = $('.receiver_port').val();
            var dataArr = {sender_port: sender_port, receiver_port: receiver_port};
            var columnWidth = { width: "5%", targets: 0 };
            var arrList = {
                tableID: "#pending_order_list",
                ajaxURL: baseurl + "customer/order-management/pending-order-ajaxcall",
                ajaxAction: "getdatatable",
                postData: dataArr,
                hideColumnList: [],
                noSortingApply: [ 7],
                noSearchApply: [ 7],
                defaultSortColumn: [0],
                defaultSortOrder: "DESC",
                setColumnWidth: columnWidth,
            };
            getDataTable(arrList);
        }
        filterSearch();

        $("body").on("change", "#sender_port, #receiver_port", function () {
            filterSearch();
        });

        $("body").on("click", ".change-payment-alert", function () {
            var id = $(this).data("id");
            var payment_alert = $(this).data("payment-alert");
            var actionClass = "";

            actionClass = ".yes-sure-change-order";
           
            setTimeout(function () { $(actionClass + ":visible").attr("data-id", id); }, 300);
            setTimeout(function () { $(actionClass + ":visible").attr("data-payment-alert", payment_alert); }, 300);
        });

        $("body").on("click", ".yes-sure-change-order", function () {
            $(".submitbtn:visible").attr("data-kt-indicator", "on").attr("disabled", true);
            var id = $(this).attr("data-id");
            var payment_alert = $(this).attr("data-payment-alert");
            $(".yes-sure-change-order").removeAttr("data-id").removeAttr("data-payment-alert");

          
            var data = { id: id, payment_alert: payment_alert, _token: $("#_token").val() };
            if (id) {
                $.ajax({
                    type: "POST",
                    headers: { "X-CSRF-TOKEN": $('input[name="_token"]').val(), },
                    url: baseurl + "customer/order-management/pending-order-ajaxcall",
                    data: { action: "order-payment-alert", data: data },
                    success: function (data) {
                        handleAjaxResponse(data);
                    },
                });
            }
        });
    };

    function container_details_calculate(){

        var total_qty = 0;
        $(".my_order_qty ").each(function () {
            var my_order_qty = parseFloat($(this).val()) || 0;
            total_qty += my_order_qty;
        });
        $('.total_qty').val(total_qty);
        $('.total_qty').text(total_qty);

        var total_capacity = 0;
        $(".my_capacity ").each(function () {
            var my_capacity = parseFloat($(this).val()) || 0;
            total_capacity += my_capacity;
        });
        $('.total_capacity').val(total_capacity.toFixed(2));
        $('.total_capacity').text(total_capacity.toFixed(2));

        var total_price = 0;
        $(".sub_price").each(function () {
            var sub_price = parseFloat($(this).val()) || 0;
            total_price += sub_price;
        });
        $('.total_price').val(total_price.toFixed(2));
        $('.total_price').text(total_price.toFixed(2));
        
        charge_details_calculate();
    }

    var admin_view = function () {
        
        $("body").on("change", ".order_status", function () {
            var id = $(this).val();
            if (id == 3) {
                $("#reason_row").addClass("d-block").removeClass("d-none");
            } else {
                $("#reason_row").addClass("d-none").removeClass("d-block");
            }
        });

        $(".reason").maxlength({
            warningClass: "badge badge-primary",
            limitReachedClass: "badge badge-success",
        });

        $("#edit-save-order-status-form").validate({
            debug: true,
            errorElement: "span",
            errorClass: "help-block",

            rules: {
                order_status: {
                    required: true,
                },
                reason: {
                    required: function () {
                        return $(".order_status:checked").val() == "3"; // Required only if value is 2
                    },
                },
            },

            messages: {
                order_status: {
                    required: "Please select order status",
                },
                reason: {
                    required: "Please enter reason.",
                },
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
                        resetForm: false,
                        success: function (output) {
                            handleAjaxResponse(output);
                        }
                    };
                    $(form).ajaxSubmit(options);
                } else {
                    $(".submitbtn:visible").attr("data-kt-indicator", "off").attr("disabled", false);
                    $("#loader").hide();
                }
            },

            errorPlacement: function (error, element) {
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + elem.attr("id") + "-container").parent();
                    error.insertAfter(element);
                } else if (elem.is(":radio")) {
                    var radioGroup = elem.closest(".form-check-radio-custom");
                    error.insertAfter(radioGroup);
                } else {
                    error.insertAfter(element);
                }
            }
        });

        function customerInfoValid() {
            var customValid = true;

            return customValid;
        }
    };

    var view_customer = function () {
        $(".reason").maxlength({
            warningClass: "badge badge-primary",
            limitReachedClass: "badge badge-success",
        });

        $("#edit-save-order-payment-satus-form").validate({
            debug: true,
            errorElement: "span",
            errorClass: "help-block",

            rules: {
                payment_status: {
                    required: true,
                },
                payment_mode: {
                    required: true,
                },
            },

            messages: {
                payment_status: {
                    required: "Please select payment status.",
                },
                payment_mode: {
                    required: "Please select payment mode.",
                },
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
                        resetForm: false,
                        success: function (output) {
                            handleAjaxResponse(output);
                        }
                    };
                    $(form).ajaxSubmit(options);
                } else {
                    $(".submitbtn:visible").attr("data-kt-indicator", "off").attr("disabled", false);
                    $("#loader").hide();
                }
            },

            errorPlacement: function (error, element) {
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + elem.attr("id") + "-container").parent();
                    error.insertAfter(element);
                } else if (elem.is(":radio")) {
                    var radioGroup = elem.closest(".form-check-radio-custom");
                    error.insertAfter(radioGroup);
                } else {
                    error.insertAfter(element);
                }
            }
        });

        function customerInfoValid() {
            var customValid = true;

            

            return customValid;
        }
    };

    return {
        init: function () {
            list();
        },
        admin_view: function () {
            admin_view();
        },
        view: function () {
            view_customer();
        },

    };
})();
