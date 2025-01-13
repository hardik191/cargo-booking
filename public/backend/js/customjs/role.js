var Role = function(){
    var list = function(){
        // alert('HI');
        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#roles",
            ajaxURL: baseurl + "admin/role-management/role-ajaxcall",
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

        $("body").on("change",'.permission-all',function(){
            var id = $(this).data('id');
            if($(this).prop('checked')) {
               $('.permission-'+id).prop('checked', true);

            } else {
                $('.permission-'+id).prop('checked', false);
            }
        });

        $('body').on('click', '.add-role', function() {

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/role-management/role-ajaxcall",
                data: { 'action': 'add-role'},
                success: function(data) {

                    $('#add_role_modal').modal('show');
                    $('.append-role-data-add').html(data);

                    var form = $('#add-save-role');
                    var rules = {
                        role_name: {required: true},
                        // 'permission[]': {  required: true },
                    };

                    var message = {
                        role_name :{
                            required : "Please enter role name",
                        },
                        // 'permission[]': {
                        //     required: "Please select at least one permission"
                        // }
                    }
                    handleFormValidateWithMsg(form, rules,message, function(form) {
                        handleAjaxFormSubmit(form,true);
                    });
                }
            });
        });

        $('body').on('click', '.edit-role', function() {
            var role_id = $(this).data('id');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/role-management/role-ajaxcall",
                data: { 'action': 'edit-role', role_id : role_id},
                success: function(data) {

                    $('#edit_role_modal').modal('show');
                    $('.append-role-data-edit').html(data);

                    var form = $('#edit-save-role');
                    var rules = {
                        role_name: {required: true},
                        // 'permission[]': {  required: true },
                    };

                    var message = {
                        role_name :{
                            required : "Please enter role name",
                        },
                        // 'permission[]': {
                        //     required: "Please select at least one permission"
                        // }
                    }
                    handleFormValidateWithMsg(form, rules,message, function(form) {
                        handleAjaxFormSubmit(form,true);
                    });
                }
            });
        });

        $("body").on("click", ".delete-role", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure-delete:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-delete', function() {
            var role_id = $(this).data('id');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/role-management/delete-role",
                data: { role_id: role_id,  _token: $('#_token').val() },
                success: function(data) {
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
