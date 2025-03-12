var Accepted_order = (function () {
    var list = function () {

        function filterSearch() {
            var sender_port = $('.sender_port').val();
            var receiver_port = $('.receiver_port').val();
            var dataArr = {sender_port: sender_port, receiver_port: receiver_port};
            var columnWidth = { width: "5%", targets: 0 };
            var arrList = {
                tableID: "#accepted_order_list",
                ajaxURL: baseurl + "customer/order-management/accepted-order-ajaxcall",
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

        $("body").on("click", ".change-order", function () {
            var id = $(this).data("id");
            var change_status = $(this).data("change-status");
            var actionClass = "";

            actionClass = ".yes-sure-change-order";
           
            setTimeout(function () { $(actionClass + ":visible").attr("data-id", id); }, 300);
            setTimeout(function () { $(actionClass + ":visible").attr("data-change-status", change_status); }, 300);
        });

        $("body").on("click", ".yes-sure-change-order", function () {
            $(".submitbtn:visible").attr("data-kt-indicator", "on").attr("disabled", true);
            var id = $(this).attr("data-id");
            var change_status = $(this).attr("data-change-status");
            $(".yes-sure-change-order").removeAttr("data-id").removeAttr("data-change-status");

          
            var data = { id: id, change_status: change_status, _token: $("#_token").val() };
            if (id) {
                $.ajax({
                    type: "POST",
                    headers: { "X-CSRF-TOKEN": $('input[name="_token"]').val(), },
                    url: baseurl + "customer/order-management/pending-order-ajaxcall",
                    data: { action: "common-change-order", data: data },
                    success: function (data) {
                        handleAjaxResponse(data);
                    },
                });
            }
        });
    };

    return {
        init: function () {
            list();
        },
    };
})();
