var Permission = function(){
    var list = function(){
        // alert('HI');
        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#permissions",
            ajaxURL: baseurl + "admin/role-management/permission-ajaxcall",
            ajaxAction: "getdatatable",
            postData: dataArr,
            hideColumnList: [1],
            noSortingApply: [0, 3],
            noSearchApply: [0, 3],
            defaultSortColumn: [0],
            defaultSortOrder: "DESC",
            setColumnWidth: columnWidth,
        };
        getDataTablePermission(arrList);


        $('body').on('click', '.add-permission', function() {

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/role-management/permission-ajaxcall",
                data: { 'action': 'add-permission'},
                success: function(data) {

                    $('#add_permission_modal').modal('show');
                    $('.append-permission-data-add').html(data);

                    var form = $('#add-save-permission');
                    var rules = {
                        permission_name: {required: true},
                    };

                    var message = {
                        permission_name :{
                            required : "Please enter permission name",
                        },
                    }
                    handleFormValidateWithMsg(form, rules,message, function(form) {
                        handleAjaxFormSubmit(form,true);
                    });
                }
            });
        });

        $('body').on('click', '.edit-permission', function() {
            var permission_id = $(this).data('id');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/role-management/permission-ajaxcall",
                data: { 'action': 'edit-permission', permission_id:permission_id},
                success: function(data) {

                    $('#edit_permission_modal').modal('show');
                    $('.append-permission-data-edit').html(data);

                    var form = $('#edit-save-permission');
                    var rules = {
                        permission_name: {required: true},
                    };

                    var message = {
                        permission_name :{
                            required : "Please enter permission name",
                        },
                    }
                    handleFormValidateWithMsg(form, rules,message, function(form) {
                        handleAjaxFormSubmit(form,true);
                    });
                }
            });
        });

        $("body").on("click", ".delete-permission", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure-delete:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-delete', function() {
            var permission_id = $(this).data('id');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/role-management/delete-permission",
                data: { permission_id: permission_id,  _token: $('#_token').val() },
                success: function(data) {
                    // $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

    }



    return {
        init: function(){
            list();
        }
    }
}();
