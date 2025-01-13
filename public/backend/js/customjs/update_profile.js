var Update_profile = function()
{
    var list = function(){
        var form = $('#update-profile');
        var rules = {
            name : {required: true},
            // last_name : {required: true},
            email: {required: true,email:true},
        };

        var message = {
            name : {required: "Please enter your name"},
            // last_name : {required: "Please enter your last name"},
            email :{
                required : "Please enter your register email address",
                email: "Please enter valid email address"
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
();
