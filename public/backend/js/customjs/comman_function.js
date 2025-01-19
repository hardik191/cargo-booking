
function ajaxcall(url, data, callback) {
    //  App.startPageLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: false,
        success: function (result) {
            //   App.stopPageLoading();
            callback(result);
        },
        error: function(xhr, status, error) {
            // Parse the error response
            var errorMessage = "An error occurred while processing your request.";
            var errorField = Object.keys(xhr.responseJSON.errors)[0]; // Get the first error field dynamically
            if (errorField) {
                errorMessage = xhr.responseJSON.errors[errorField][0];
            }
            $("#" + errorField + "-error").html(errorMessage);
            $(".submitbtn:visible").attr("data-kt-indicator", "false");
            $(".submitbtn:visible").removeAttr("disabled");
            }
    })
}


function handleAjaxFormSubmit(form, type) {
    $(".submitbtn:visible").attr("data-kt-indicator", "on");
    $(".submitbtn:visible").attr("disabled", "disabled");
    $("#loader").show();
    if (typeof type === 'undefined') {
        ajaxcall($(form).attr('action'), $(form).serialize(), function (output) {
            handleAjaxResponse(output);
        });
    } else if (type === true) {
        // App.startPageLoading();
        var options = {
            resetForm: false, // reset the form after successful submit
            success: function (output) {

                handleAjaxResponse(output);
            }
        };
        $(form).ajaxSubmit(options);
    }
    return false;
}


function showToster(status, message) {

    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 1500
    };
    if (status == 'success') {
        toastr.success(message, 'Success');
    }
    if (status == 'error') {
        toastr.error(message, 'Fail');

    }
    if (status == 'warning') {
        toastr.warning(message, 'Warning');

    }
    setTimeout(function () {
        $(".submitbtn:visible").attr("data-kt-indicator", "false");
        $(".submitbtn:visible").removeAttr("disabled");
    }, 3000);
}



function handleAjaxResponse(output) {
    $(".submitbtn:visible").attr("data-kt-indicator", "on");
    $(".submitbtn:visible").attr("disabled", "disabled");
    $("#loader").show();
    output = JSON.parse(output);
    if (output.message != '') {
        showToster(output.status, output.message, '');
    }
    if (typeof output.redirect !== 'undefined' && output.redirect != '') {
        setTimeout(function () {
            window.location.href = output.redirect;
        }, 2000);
    }
    if (typeof output.reload !== 'undefined' && output.reload != '') {
        window.location.href = location.reload();
    }
    if (typeof output.jscode !== 'undefined' && output.jscode != '') {
        eval(output.jscode);
    }
    if (typeof output.ajaxcall !== 'undefined' && output.ajaxcall != '') {
        setTimeout(function () {
            eval(output.ajaxcall);
        }, 1000);
    }
}

function _fn_getQueryStringValue(name) {
    var regex = new RegExp("[\\?&]" + name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]") + "=([^&#]*)"),
        results = regex.exec(window.location.search);
    return results ? decodeURIComponent(results[1].replace(/\+/g, " ")) : '';
}



function handleFormValidateWithMsg(form, rules, messages, submitCallback, showToaster) {
    var error = $('.alert-danger', form);
    var success = $('.alert-success', form);
    form.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: true, // do not focus the last invalid input
        ignore: ":hidden",
        rules: rules,
        invalidHandler: function (event, validator) { //display error alert on form submit
            success.hide();
            error.show();
            if (typeof showToaster !== 'undefined' && showToaster) {
                Toastr.init('warning', 'Some fields are missing!.', '');
            }
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-control').addClass('has-error'); // set error class to the control group
            $(element).parent().find('.select2').addClass('has-error');
        },
        unhighlight: function (element) { // revert the change done by hightlight
            $(element).parent().find('.select2').removeClass('has-error');
            $(element)
                .closest('.form-control').removeClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label.closest('.form-control').removeClass('has-error'); // set success class to the control group
            label.parent().find('.select2').removeClass('has-error');
        },
        messages: messages,

        submitHandler: function(form) {
            $(".submitbtn:visible").attr("disabled", "disabled");
            $("#loader").show();
            if (typeof submitCallback !== 'undefined' && typeof submitCallback == 'function') {
                submitCallback(form);
            } else {
                handleAjaxFormSubmit(form);
            }
            return false;
        },

        errorPlacement: function (error, element) {
            var elem = $(element);
            if (elem.hasClass("select2-hidden-accessible")) {
                element = $("#select2-" + elem.attr("id") + "-container").parent();
                error.insertAfter(element);
            } else {
                if (elem.hasClass("radio-btn")) {
                    element = elem.parent().parent();
                    error.insertAfter(element);
                } else {
                    error.insertAfter(element);
                }
            }
        },
    });

    $('.select2me', form).change(function () {
        form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
    });
    $('.date-picker .form-control').change(function () {
        form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
    })
}

$(".onlyNumber").keypress(function (e) {
    //if the letter is not digit then display error and don't type anything
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        //    $("#errmsg").html("Digits Only").show().fadeOut("slow");
        return false;
    }
});
$('body').on("keydown", ".onlyDigit", function (event) {

    if (event.shiftKey == true) {
        event.preventDefault();
    }

    if ((event.keyCode >= 48 && event.keyCode <= 57) ||
        (event.keyCode >= 96 && event.keyCode <= 105) ||
        event.keyCode == 8 || event.keyCode == 110 || event.keyCode == 9 || event.keyCode == 37 ||
        event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

    } else {
        event.preventDefault();
    }

    if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
        event.preventDefault();
});


function validateEmail(mail) {
    if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail)) {
        return true;
    } else {

        return false;
    }

}

function validateEmailUrl(mail) {
    if (/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/.test(mail)) {
        return true;
    } else {

        return false;
    }

}


function convert_float(number) {
    return (parseFloat(number).toFixed(decimal_point));
}

function numberformate(value) {
    return parseFloat(value).toFixed(2);
}

function getDataTable(arr) {


    if ($.fn.DataTable.isDataTable(arr.tableID)) {
        $(arr.tableID).DataTable().destroy();
    }

    var pageLength = 0
    if (arr.pageLength) {
        pageLength = arr.pageLength;
    } else {
        pageLength = 10;
    }
    var dataTable = $(arr.tableID).DataTable({
        "scrollX": true,
        "processing": true,
        "responsive": false,
        "lengthMenu": [5, 10, 25, 50, 100],
        "pageLength": pageLength,
        "serverSide": true,
        "bAutoWidth": false,
        "searching": true,
        "bLengthChange": true,
        "bInfo": true,
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search..."
        },
        "order": [
            [(arr.defaultSortColumn) ? arr.defaultSortColumn : '0', (arr.defaultSortOrder) ? arr.defaultSortOrder : 'desc']
        ],
        "columnDefs": [{
                "targets": arr.hideColumnList,
                "visible": false
            },
            {
                "targets": arr.noSortingApply,
                "orderable": false
            },
            {
                "targets": arr.noSearchApply,
                "searchable": false
            },
            (arr.setColumnWidth) ? arr.setColumnWidth : ''
        ],

        // "bStateSave": true,
        // "fnStateSave": function (oSettings, oData) {
        //     localStorage.setItem('offersDataTables', JSON.stringify(oData));
        // },
        // "fnStateLoad": function (oSettings) {
        //     return JSON.parse(localStorage.getItem('offersDataTables'));
        // },


        "ajax": {
            url: arr.ajaxURL,
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: { 'action': arr.ajaxAction, 'data': arr.postData },
            error: function() { // error handling

                $(".row-list-error").html("");
                $(arr.tableID).append('<tbody class="row-list-error"><tr><td colspan="4" style="text-align: center;"><p style="color:red;">Sorry, No Record Found</p></td></tr></tbody>');
                $(arr.tableID + "processing").css("display", "none");
            }
        }
    });
}

function getDataTablePermission(arr) {
    if ($.fn.DataTable.isDataTable(arr.tableID)) {
        $(arr.tableID).DataTable().destroy();
    }

    var pageLength = 0
    if (arr.pageLength) {
        pageLength = arr.pageLength;
    } else {
        pageLength = 10;
    }
    var dataTable = $(arr.tableID).DataTable({
        "scrollX": true,
        "processing": true,
        "responsive": false,
        "lengthMenu": [5, 10, 25, 50, 100],
        "pageLength": pageLength,
        "serverSide": true,
        "bAutoWidth": false,
        "searching": true,
        "bLengthChange": true,
        "bInfo": true,
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search..."
        },
        "order": [
            [(arr.defaultSortColumn) ? arr.defaultSortColumn : '0', (arr.defaultSortOrder) ? arr.defaultSortOrder : 'desc']
        ],
        "columnDefs": [{
                "targets": arr.hideColumnList,
                "visible": false
            },
            {
                "targets": arr.noSortingApply,
                "orderable": false
            },
            {
                "targets": arr.noSearchApply,
                "searchable": false
            },
            (arr.setColumnWidth) ? arr.setColumnWidth : ''
        ],


        "rowGroup": {
            "dataSrc": [1]
        },


        "ajax": {
            url: arr.ajaxURL,
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            data: { 'action': arr.ajaxAction, 'data': arr.postData },
            error: function() { // error handling

                $(".row-list-error").html("");
                $(arr.tableID).append('<tbody class="row-list-error"><tr><td colspan="4" style="text-align: center;"><p style="color:red;">Sorry, No Record Found</p></td></tr></tbody>');
                $(arr.tableID + "processing").css("display", "none");
            }
        }
    });


}

function getDataTableRowGroupColumn(arr) {
    if ($.fn.DataTable.isDataTable(arr.tableID)) {
        $(arr.tableID).DataTable().destroy();
    }

    var pageLength = 0;
    if (arr.pageLength) {
        pageLength = arr.pageLength;
    } else {
        pageLength = 10;
    }
    var dataTable = $(arr.tableID).DataTable({
        scrollX: true,
        processing: true,
        responsive: false,
        lengthMenu: [5, 10, 25, 50, 100],
        pageLength: pageLength,
        serverSide: true,
        bAutoWidth: false,
        searching: true,
        bLengthChange: true,
        bInfo: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
        },
        order: [
            [
                arr.defaultSortColumn ? arr.defaultSortColumn : "0",
                arr.defaultSortOrder ? arr.defaultSortOrder : "desc",
            ],
        ],
        columnDefs: [
            {
                targets: arr.hideColumnList,
                visible: false,
            },
            {
                targets: arr.noSortingApply,
                orderable: false,
            },
            {
                targets: arr.noSearchApply,
                searchable: false,
            },
            arr.setColumnWidth ? arr.setColumnWidth : "",
        ],

        rowGroup: {
            dataSrc: arr.rowGroupColumnList,
        },

        ajax: {
            url: arr.ajaxURL,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').val(),
            },
            data: { action: arr.ajaxAction, data: arr.postData },
            error: function () {
                // error handling

                $(".row-list-error").html("");
                $(arr.tableID).append(
                    '<tbody class="row-list-error"><tr><td colspan="4" style="text-align: center;"><p style="color:red;">Sorry, No Record Found</p></td></tr></tbody>'
                );
                $(arr.tableID + "processing").css("display", "none");
            },
        },
    });
}

// image show in modal usein-FsLightbox
function getDataTableFsLightbox(arr) {
    const table = $(arr.tableID);

    // Destroy existing DataTable instance
    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().destroy();
    }

    // DataTable configuration
    table.DataTable({
        scrollX: true,
        processing: true,
        responsive: false, // Set to true for responsive design
        lengthMenu: [5, 10, 25, 50, 100],
        pageLength: arr.pageLength || 10,
        serverSide: true,
        bAutoWidth: false,
        searching: true,
        bLengthChange: true,
        bInfo: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search...",
        },
        order: [[arr.defaultSortColumn || 0, arr.defaultSortOrder || "desc"]],
        columnDefs: [
            { targets: arr.hideColumnList, visible: false },
            { targets: arr.noSortingApply, orderable: false },
            { targets: arr.noSearchApply, searchable: false },
            arr.setColumnWidth || {}, // Apply column width if defined
        ],
        ajax: {
            url: arr.ajaxURL,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').val(),
            },
            data: {
                action: arr.ajaxAction,
                data: arr.postData,
            },
            error: function () {
                // Clear previous rows and show error message
                $(".row-list-error").html("");
                table.append(
                    '<tbody class="row-list-error"><tr><td colspan="4" style="text-align: center;"><p style="color:red;">Sorry, No Record Found</p></td></tr></tbody>'
                );
                $(arr.tableID + "processing").css("display", "none");
            },
        },
        drawCallback: function () {
            // Reinitialize plugins like FsLightbox here if needed
            if (typeof refreshFsLightbox === "function") {
                refreshFsLightbox();
            }
        },
    });
}

