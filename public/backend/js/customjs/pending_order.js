var Pending_order = (function () {
    var list = function () {
        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#holiday-list",
            ajaxURL: baseurl + "admin/holiday-ajaxcall",
            ajaxAction: "getdatatable",
            postData: dataArr,
            hideColumnList: [],
            noSortingApply: [0, 6],
            noSearchApply: [0, 6],
            defaultSortColumn: [0],
            defaultSortOrder: "DESC",
            setColumnWidth: columnWidth,
        };
        getDataTable(arrList);

        $("body").on("click", ".delete-holiday, .inactive-holiday, .active-holiday", function () {
            var id = $(this).data("id");
            var actionClass = "";

            if ($(this).hasClass("delete-holiday")) {
                actionClass = ".yes-sure-delete";
            } else if ($(this).hasClass("inactive-holiday")) {
                actionClass = ".yes-sure-inactive";
            } else if ($(this).hasClass("active-holiday")) {
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
            if (id) {
                $.ajax({
                    type: "POST",
                    headers: { "X-CSRF-TOKEN": $('input[name="_token"]').val(), },
                    url: baseurl + "admin/holiday-ajaxcall",
                    data: { action: "common-holiday", data: data },
                    success: function (data) {
                        handleAjaxResponse(data);
                    },
                });
            }
        });
    };

    function comman_holiday() {
        $(".only_date").flatpickr({
            dateFormat: "d-m-Y",
        });

        $(".description").maxlength({
            warningClass: "badge badge-primary",
            limitReachedClass: "badge badge-success",
        });
    }

    var create_order = function () {
         comman_holiday();
         var validateTrip = true;
         var customValid = true;

         $("#add-holiday-form").validate({
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
        add: function () {
            create_order();
        },
        edit: function () {
            edit_order();
        },
    };
})();
