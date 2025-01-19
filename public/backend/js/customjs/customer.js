var Customer = function(){
    var list = function(){
        // alert('HI');
        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#customer_list",
            ajaxURL: baseurl + "admin/user-management/customer-ajaxcall",
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

        $("body").on("click", ".delete-user, .inactive-user, .active-user", function() {
            var id = $(this).data('id');
            var actionClass = '';

            if ($(this).hasClass('delete-user')) {
                actionClass = '.yes-sure-delete';
            } else if ($(this).hasClass('inactive-user')) {
                actionClass = '.yes-sure-inactive';
            } else if ($(this).hasClass('active-user')) {
                actionClass = '.yes-sure-active';
            }

            setTimeout(function() {
                $(actionClass + ':visible').attr('data-id', id);
            }, 500);
        });

        $('body').on('click', '.yes-sure-delete, .yes-sure-inactive, .yes-sure-active', function() {
            $(".submitbtn:visible").attr("data-kt-indicator", "on").attr("disabled", true);
            var id = $(this).attr('data-id');
            var type = '';
            $('.yes-sure-delete, .yes-sure-inactive, .yes-sure-active').removeAttr('data-id');

            if ($(this).hasClass('yes-sure-delete')) {
                type = '3';
            } else if ($(this).hasClass('yes-sure-inactive')) {
                type = '2';
            } else if ($(this).hasClass('yes-sure-active')) {
                type = '1';
            }
            var data = { id: id, type: type, _token: $('#_token').val() };
            if(id){
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/user-management/customer-ajaxcall",
                    data: { 'action': 'common-user', 'data': data },
                    success: function(data) {
                        handleAjaxResponse(data);
                    }
                });
            }
        });
    }



    return {
        init: function(){
            list();
        }
    }
}();
