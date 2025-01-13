var Audit = function(){
    var list = function(){
        // alert('HI');
        var dataArr = {};
        var columnWidth = { width: "5%", targets: 0 };
        var arrList = {
            tableID: "#audits",
            ajaxURL: baseurl + "admin/audit-ajaxcall",
            ajaxAction: "getdatatable",
            postData: dataArr,
            hideColumnList: [],
            noSortingApply: [0, ],
            noSearchApply: [0, ],
            defaultSortColumn: [0],
            defaultSortOrder: "DESC",
            setColumnWidth: columnWidth,
        };
        getDataTable(arrList);

    }

    return {
        init: function(){
            list();
        }
    }
}();
