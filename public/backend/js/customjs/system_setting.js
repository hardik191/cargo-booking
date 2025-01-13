var System_setting = function(){
    var list = function(){
        var form = $('#general-setting');
        var rules = {
            system_name : {required: true},
            sidebar_navbar_name : {required: true},
            header_navbar_name : {required: true},
            footer_text: {required: true},
        };

        var message = {
            system_name : {required: "Please enter system name"},
            sidebar_navbar_name : {required: "Please enter sidebar navbar name"},
            header_navbar_name : {required: "Please enter header navbar name"},
            footer_text :{
                required : "Please enter footer text"
            },

        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        var form = $('#branding-setting');
        var rules = {
        };

        var message = {
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        var form = $('#email-setting');
        var rules = {
            server_name : {required: true},
            user_name : {required: true},
            password : {required: true},
            port: {required: true},
            driver: {required: true},
            encryption: {required: true},
        };

        var message = {
            server_name : {required: "Please enter server (host) name"},
            user_name : {required: "Please enter user name"},
            password : {required: "Please enter password"},
            port :{
                required : "Please enter port"
            },
            driver :{
                required : "Please enter driver"
            },
            encryption :{
                required : "Please select encryption"
            },

        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    return {
        init: function(){
            list();
        }
    }
}
()
;
