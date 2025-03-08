var Pending_order = (function () {
    var list = function () {
        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#pending_order_list",
            ajaxURL: baseurl + "customer/order-management/pending-order-ajaxcall",
            ajaxAction: "getdatatable",
            postData: dataArr,
            hideColumnList: [],
            noSortingApply: [0, 2],
            noSearchApply: [0, 2],
            defaultSortColumn: [0],
            defaultSortOrder: "DESC",
            setColumnWidth: columnWidth,
        };
        getDataTable(arrList);

        // $("body").on("click", ".delete-holiday, .inactive-holiday, .active-holiday", function () {
        //     var id = $(this).data("id");
        //     var actionClass = "";

        //     if ($(this).hasClass("delete-holiday")) {
        //         actionClass = ".yes-sure-delete";
        //     } else if ($(this).hasClass("inactive-holiday")) {
        //         actionClass = ".yes-sure-inactive";
        //     } else if ($(this).hasClass("active-holiday")) {
        //         actionClass = ".yes-sure-active";
        //     }
        //     setTimeout(function () { $(actionClass + ":visible").attr("data-id", id); }, 500);
        // });

        // $("body").on("click", ".yes-sure-delete, .yes-sure-inactive, .yes-sure-active", function () {
        //     $(".submitbtn:visible").attr("data-kt-indicator", "on").attr("disabled", true);
        //     var id = $(this).attr("data-id");
        //     var type = "";
        //     $(".yes-sure-delete, .yes-sure-inactive, .yes-sure-active").removeAttr("data-id");

        //     if ($(this).hasClass("yes-sure-delete")) {
        //         type = "3";
        //     } else if ($(this).hasClass("yes-sure-inactive")) {
        //         type = "2";
        //     } else if ($(this).hasClass("yes-sure-active")) {
        //         type = "1";
        //     }
        //     var data = { id: id, type: type, _token: $("#_token").val() };
        //     if (id) {
        //         $.ajax({
        //             type: "POST",
        //             headers: { "X-CSRF-TOKEN": $('input[name="_token"]').val(), },
        //             url: baseurl + "admin/holiday-ajaxcall",
        //             data: { action: "common-holiday", data: data },
        //             success: function (data) {
        //                 handleAjaxResponse(data);
        //             },
        //         });
        //     }
        // });
    };

    function container_details_calculate(){

        var total_qty = 0;
        $(".my_order_qty ").each(function () {
            var my_order_qty = parseFloat($(this).val()) || 0;
            total_qty += my_order_qty;
        });
        $('.total_qty').val(total_qty);
        $('.total_qty').text(total_qty);

        var total_price = 0;
        $(".sub_price").each(function () {
            var sub_price = parseFloat($(this).val()) || 0;
            total_price += sub_price;
        });
        $('.total_price').val(total_price);
        $('.total_price').text(total_price);
        
        charge_details_calculate();
    }

    function charge_details_calculate() {

        var total_price = parseFloat($('.total_price').val()) || 0;
        var final_price = total_price; // Start with the total price from container details
        var total_charge = 0;

        console.log('Total Price:', total_price);

        $("#charge-details-table tbody tr").each(function () {
            var chargeType = parseInt($(this).find(".charge_type").val()) || 0;
            var chargeValue = parseFloat($(this).find(".charge_value").val()) || 0;
            var chargeAmount = 0; // Variable to store calculated charge

            switch (chargeType) {
                case 1: // Addition (+)
                    chargeAmount = chargeValue;
                    break;
                case 2: // Subtraction (-)
                    chargeAmount = -chargeValue;
                    break;
                case 3: // Multiplication (*) Addition (percentage)
                    chargeAmount = (total_price * (chargeValue / 100));
                    break;
                case 4: // Multiplication (*) Subtraction (percentage)
                    chargeAmount = -(total_price * (chargeValue / 100));
                    break;
                case 5: // Division (/) Addition
                    if (chargeValue !== 0) {
                        chargeAmount = (total_price / chargeValue);
                    }
                    break;
                case 6: // Division (/) Subtraction
                    if (chargeValue !== 0) {
                        chargeAmount = -(total_price / chargeValue);
                    }
                    break;
                case 7: // Modulus (%) Addition (Remainder Addition)
                    if (chargeValue !== 0) {
                        chargeAmount = (total_price % chargeValue);
                    }
                    break;
                case 8: // Modulus (%) Subtraction (Remainder Subtraction)
                    if (chargeValue !== 0) {
                        chargeAmount = -(total_price % chargeValue);
                    }
                    break;
                default:
                    chargeAmount = 0;
            }

            total_charge += chargeAmount;
            console.log(`Charge Type: ${chargeType}, Charge Value: ${chargeValue}, Applied Charge: ${chargeAmount}, Total Charge: ${total_charge}`);
        });

        // Calculate the final total
        final_price = total_price + total_charge;

        // Update UI fields
        $(".total_charge").val(total_charge.toFixed(2));
        $(".total_charge").text(total_charge.toFixed(2));

        $(".final_total").val(final_price.toFixed(2));
        $(".final_total").text(final_price.toFixed(2));
    }

    function comman_order() {

        $("#container-details-table").on("focusout", ".form-control", function () {
            var row = $(this).closest("tr");

            var basePrice = parseFloat(row.find(".base_price").val()) || 0;
            var orderQty = parseFloat(row.find(".my_order_qty").val()) || 0;

            // Calculate total for this row
            var rowTotal = basePrice * orderQty;
            console.log(rowTotal);
            // Set the calculated total in the row's total field
            row.find(".sub_price").val(rowTotal.toFixed(2)); // Update the row total, assuming it's a <span> or similar element

            container_details_calculate();
        });
    }

    var create_order = function () {
         comman_order();
         var validateTrip = true;
         var customValid = true;

         $("#create-save-order-form").validate({
             debug: true,
             errorElement: "span", //default input error message container
             errorClass: "help-block", // default input error message class

             rules: {
                //  holiday_name: { required: true },
                //  start_date: { required: true },
                //  end_date: {
                //      required: true,
                //      greaterThanOrEqualToStartDateTime: true,
                //  },
             },

             messages: {
                //  holiday_name: { required: "Please enter holiday name." },
                //  start_date: { required: "Please enter start date." },
                //  end_date: {
                //      required: "Please enter end date.",
                //      greaterThanOrEqualToStartDateTime:
                //          "End date must be greater than or equal to the start date.",
                //  },
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
    };
    
    var edit_holiday = function () {
        comman_holiday();
        var validateTrip = true;
        var customValid = true;

        $("#edit-holiday-form").validate({
            debug: true,
            errorElement: "span", //default input error message container
            errorClass: "help-block", // default input error message class

            rules: {
                holiday_name: { required: true },
                start_date: { required: true },
                end_date: {
                    required: true,
                    greaterThanOrEqualToStartDateTime: true,
                },
            },

            messages: {
                holiday_name: { required: "Please enter holiday name." },
                start_date: { required: "Please enter start date." },
                end_date: {
                    required: "Please enter end date.",
                    greaterThanOrEqualToStartDateTime:
                        "End date must be greater than or equal to the start date.",
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
    };

   

    return {
        init: function () {
            list();
        },
        create: function () {
            create_order();
        },
        edit: function () {
            edit_order();
        },
    };
})();
