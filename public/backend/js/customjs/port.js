var Port = function () {
    var list = function () {

        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#port_list",
            ajaxURL: baseurl + "admin/master-management/port-ajaxcall",
            ajaxAction: "getdatatable",
            postData: dataArr,
            hideColumnList: [],
            noSortingApply: [ 3],
            noSearchApply: [0, 3],
            defaultSortColumn: [0],
            defaultSortOrder: "DESC",
            setColumnWidth: columnWidth,
        };
        getDataTable(arrList);



        $('body').on('click', '.add-port', function () {

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/master-management/port-ajaxcall",
                data: { 'action': 'add-port' },
                success: function (data) {

                    $('#add_port_modal').modal('show');
                    $('.append-port-data-add').html(data);


                }
            });
        });

        $('body').on('click', '.edit-role', function () {
            var role_id = $(this).data('id');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/role-management/role-ajaxcall",
                data: { 'action': 'edit-role', role_id: role_id },
                success: function (data) {

                    $('#edit_role_modal').modal('show');
                    $('.append-role-data-edit').html(data);

                    var form = $('#edit-save-role');
                    var rules = {
                        role_name: { required: true },
                        // 'permission[]': {  required: true },
                    };

                    var message = {
                        role_name: {
                            required: "Please enter role name",
                        },
                        // 'permission[]': {
                        //     required: "Please select at least one permission"
                        // }
                    }
                    handleFormValidateWithMsg(form, rules, message, function (form) {
                        handleAjaxFormSubmit(form, true);
                    });
                }
            });
        });


    }



    return {
        init: function () {
            list();
        }
    }
}();
