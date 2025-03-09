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

          $.validator.addMethod("differentPort", function (value, element) {
                return value !== $("#sender_port").val();
            }, "Sender and Receiver ports must be different.");

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

        $(document).ready(function() {
            var sender_phone_no = document.querySelector("#sender_phone_no");
            var iti = window.intlTelInput(sender_phone_no, {
                initialCountry: "in",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js" // for formatting/placeholders etc
            });

            // Listen for the country change event
            sender_phone_no.addEventListener('countrychange', function() {
                // Get the selected country data
                var countryData = iti.getSelectedCountryData();
                // Get the country code
                var countryCode = countryData.dialCode;
                $('#sender_country_code').val(countryCode);
            });

            var receiver_phone_no = document.querySelector("#receiver_phone_no");
            var iti_receiver = window.intlTelInput(receiver_phone_no, {
                initialCountry: "in",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js" // for formatting/placeholders etc
            });

            // Listen for the country change event
            receiver_phone_no.addEventListener('countrychange', function() {
                // Get the selected country data
                var countryDataReceiver = iti_receiver.getSelectedCountryData();
                // Get the country code
                var countryCodeReceiver = countryDataReceiver.dialCode;
                $('#receiver_country_code').val(countryCodeReceiver);
            });
        });

        $("#create-save-order-form").validate({
            debug: true,
            errorElement: "span",
            errorClass: "help-block",

            rules: {
                sender_name: { required: true, maxlength: 255 },
                sender_email: { required: true, email: true, maxlength: 255 },
                sender_phone_no: { 
                    required: true, 
                    // digits: true, 
                    minlength: 8, 
                    maxlength: 15 
                },
                sender_port: { required: true },
                receiver_name: { required: true, maxlength: 255 },
                receiver_email: { required: true, email: true, maxlength: 255 },
                receiver_phone_no: { 
                    required: true, 
                    // digits: true,
                    minlength: 8, 
                    maxlength: 15 
                },
                receiver_port: { required: true, differentPort: true }, // Ensure different ports
                total_qty: { number: true, min: 1, max: 5000 },
                total_price: { required: true, number: true, min: 0 },
                total_charge: { required: true, number: true, min: 0 },
                final_total: { required: true, number: true, min: 0 },
                // "my_order_qty[]": { required: true, number: true, min: 0 },
                // "my_capacity[]": { required: true, number: true, min: 0 },
                // "sub_price[]": { required: true, number: true, min: 0 },
                // "charge_type[]": { required: true, digits: true, min: 0, max: 5 },
                // "charge_value[]": { required: true, number: true, min: 0 }
            },

            messages: {
                sender_name: { required: "Please enter sender name." },
                sender_email: { required: "Please enter sender email.", email: "Enter a valid email." },
                sender_phone_no: { 
                    required: "Please enter sender phone number.", 
                    // digits: "Only numbers allowed." 
                },
                sender_port: { required: "Please select sender port." },
                receiver_name: { required: "Please enter receiver name." },
                receiver_email: { required: "Please enter receiver email.", email: "Enter a valid email." },
                receiver_phone_no: { 
                    required: "Please enter receiver phone number.", 
                    // digits: "Only numbers allowed." 
                },
                receiver_port: {
                    required: "Please select receiver port.",
                    differentPort: "Sender and Receiver ports must be different."
                },
                total_qty: { number: "Only numbers allowed.", min: "Must be at least 1.", max: "Must be at most 1000." },
                total_price: { required: "Total price is required.", number: "Only numbers allowed.", min: "Cannot be negative." },
                total_charge: { required: "Total charge is required.", number: "Only numbers allowed.", min: "Cannot be negative." },
                final_total: { required: "Final total is required.", number: "Only numbers allowed.", min: "Cannot be negative." },
                // "my_order_qty[]": { required: "Order quantity is required.", number: "Only numbers allowed.", min: "Must be at least 0." },
                // "my_capacity[]": { required: "Capacity is required.", number: "Only numbers allowed.", min: "Must be at least 0." },
                // "sub_price[]": { required: "Sub price is required.", number: "Only numbers allowed.", min: "Must be at least 0." },
                // "charge_type[]": { required: "Charge type is required.", digits: "Only numbers allowed.", min: "At least 0.", max: "Cannot exceed 5." },
                // "charge_value[]": { required: "Charge value is required.", number: "Only numbers allowed.", min: "Must be at least 0." }
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

            // Remove existing error class
            // $(".field-requireds").removeClass("field-requireds");
            $(".my_order_qty").each(function () {
                var orderQty = $(this);
                var index = $(".my_order_qty").index(orderQty); // Get index to find matching my_capacity
                var capacityField = $(".my_capacity").eq(index); // Get the corresponding my_capacity field

                if (orderQty.is(":visible")) {
                    if (orderQty.val() > 0) {
                        if (capacityField.val().trim() === "" || capacityField.val() <= 0) {
                            capacityField.addClass("field-requireds"); // Highlight my_capacity
                            customValid = false;
                        } else {
                            customValid = true;
                            capacityField.removeClass("field-requireds"); // Remove if valid
                        }
                    } else {
                        capacityField.removeClass("field-requireds"); // Ensure no error if qty is 0
                    }
                }
            });

            return customValid;
        }

    };
    
    var edit_order = function () {
        comman_order();
        $(document).ready(function() {
            var sender_phone_no = document.querySelector("#sender_phone_no");
            var receiver_phone_no = document.querySelector("#receiver_phone_no");

            // Get stored country codes from hidden input fields
            var senderStoredCode = $("#sender_country_code").val();
            var receiverStoredCode = $("#receiver_country_code").val();

            // Initialize intlTelInput for Sender Phone
            var iti = window.intlTelInput(sender_phone_no, {
                initialCountry: senderStoredCode ? getCountryByDialCode(senderStoredCode) : "in",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
            });

            // Set country code when country is changed
            sender_phone_no.addEventListener('countrychange', function() {
                var countryData = iti.getSelectedCountryData();
                $('#sender_country_code').val(countryData.dialCode);
            });

            // Initialize intlTelInput for Receiver Phone
            var iti_receiver = window.intlTelInput(receiver_phone_no, {
                initialCountry: receiverStoredCode ? getCountryByDialCode(receiverStoredCode) : "in",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
            });

            // Set country code when country is changed
            receiver_phone_no.addEventListener('countrychange', function() {
                var countryDataReceiver = iti_receiver.getSelectedCountryData();
                $('#receiver_country_code').val(countryDataReceiver.dialCode);
            });

            // Function to get country code from dial code
            function getCountryByDialCode(dialCode) {
                var countryData = window.intlTelInputGlobals.getCountryData();
                var country = countryData.find(country => country.dialCode === dialCode);
                return country ? country.iso2 : "in"; // Default to "in" (India) if not found
            }
        });

        $("#edit-save-order-form").validate({
            debug: true,
            errorElement: "span",
            errorClass: "help-block",

            rules: {
                sender_name: { required: true, maxlength: 255 },
                sender_email: { required: true, email: true, maxlength: 255 },
                sender_phone_no: { 
                    required: true, 
                    // digits: true, 
                    minlength: 8, 
                    maxlength: 15 
                },
                sender_port: { required: true },
                receiver_name: { required: true, maxlength: 255 },
                receiver_email: { required: true, email: true, maxlength: 255 },
                receiver_phone_no: { 
                    required: true, 
                    // digits: true,
                    minlength: 8, 
                    maxlength: 15 
                },
                 receiver_port: { required: true, differentPort: true }, // Ensure different ports
                total_qty: { number: true, min: 1, max: 5000 },
                total_price: { required: true, number: true, min: 0 },
                total_charge: { required: true, number: true, min: 0 },
                final_total: { required: true, number: true, min: 0 },
                // "my_order_qty[]": { required: true, number: true, min: 0 },
                // "my_capacity[]": { required: true, number: true, min: 0 },
                // "sub_price[]": { required: true, number: true, min: 0 },
                // "charge_type[]": { required: true, digits: true, min: 0, max: 5 },
                // "charge_value[]": { required: true, number: true, min: 0 }
            },

            messages: {
                sender_name: { required: "Please enter sender name." },
                sender_email: { required: "Please enter sender email.", email: "Enter a valid email." },
                sender_phone_no: { 
                    required: "Please enter sender phone number.", 
                    // digits: "Only numbers allowed." 
                },
                sender_port: { required: "Please select sender port." },
                receiver_name: { required: "Please enter receiver name." },
                receiver_email: { required: "Please enter receiver email.", email: "Enter a valid email." },
                receiver_phone_no: { 
                    required: "Please enter receiver phone number.", 
                    // digits: "Only numbers allowed." 
                },
                receiver_port: {
                    required: "Please select receiver port.",
                    differentPort: "Sender and Receiver ports must be different."
                },
                total_qty: { number: "Only numbers allowed.", min: "Must be at least 1.", max: "Must be at most 1000." },
                total_price: { required: "Total price is required.", number: "Only numbers allowed.", min: "Cannot be negative." },
                total_charge: { required: "Total charge is required.", number: "Only numbers allowed.", min: "Cannot be negative." },
                final_total: { required: "Final total is required.", number: "Only numbers allowed.", min: "Cannot be negative." },
                // "my_order_qty[]": { required: "Order quantity is required.", number: "Only numbers allowed.", min: "Must be at least 0." },
                // "my_capacity[]": { required: "Capacity is required.", number: "Only numbers allowed.", min: "Must be at least 0." },
                // "sub_price[]": { required: "Sub price is required.", number: "Only numbers allowed.", min: "Must be at least 0." },
                // "charge_type[]": { required: "Charge type is required.", digits: "Only numbers allowed.", min: "At least 0.", max: "Cannot exceed 5." },
                // "charge_value[]": { required: "Charge value is required.", number: "Only numbers allowed.", min: "Must be at least 0." }
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

            // Remove existing error class
            // $(".field-requireds").removeClass("field-requireds");
            $(".my_order_qty").each(function () {
                var orderQty = $(this);
                var index = $(".my_order_qty").index(orderQty); // Get index to find matching my_capacity
                var capacityField = $(".my_capacity").eq(index); // Get the corresponding my_capacity field

                if (orderQty.is(":visible")) {
                    if (orderQty.val() > 0) {
                        if (capacityField.val().trim() === "" || capacityField.val() <= 0) {
                            capacityField.addClass("field-requireds"); // Highlight my_capacity
                            customValid = false;
                        } else {
                            capacityField.removeClass("field-requireds"); // Remove if valid
                        }
                    } else {
                        capacityField.removeClass("field-requireds"); // Ensure no error if qty is 0
                    }
                }
            });

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
