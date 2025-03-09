var Rejected_order = (function () {
    var list = function () {

        function filterSearch() {
            var sender_port = $('.sender_port').val();
            var receiver_port = $('.receiver_port').val();
            var dataArr = {sender_port: sender_port, receiver_port: receiver_port};
            var columnWidth = { width: "5%", targets: 0 };
            var arrList = {
                tableID: "#rejected_order_list",
                ajaxURL: baseurl + "customer/order-management/rejected-order-ajaxcall",
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

    return {
        init: function () {
            list();
        },
    };
})();
