$(document).ready(function() {
    $('#item-table').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Chinese.json"
        },
        "ajax": {
            "url": baseUrl+"/item/get-list-pageable",
            "data": {
                "categoryId": cateId
            },
            "dataSrc": function(json) {
                var ret = json.data;
                ret.forEach(function (ele) {
                    ele.operator = "";
                    if (json.operator.view == 1) {
                        ele.operator += '<a class="btn-op" title="查看" data-url="'+baseUrl+'/item/get-detail/' + ele.id + '"><i class="fa fa-eye"></i></a>';
                    }
                    if (json.operator.edit == 1) {
                        ele.operator += '<a class="btn-op" title="编辑" data-url="'+baseUrl+'/item/edit/' + ele.id + '"><i class="fa fa-edit"></i></a>';
                    }
                    if (json.operator.delete == 1) {
                        ele.operator += '<a class="btn-op" title="删除" data-url="'+baseUrl+'/item/delete/' + ele.id + '"><i class="fa fa-cut"></i></a>';
                    }
                });
                return ret;
             }
        },
        "processing": true,
        "serverSide": true,
        "columns": [
            { "data": "id" },
            { "data": "identity" },
            { "data": "name" },
            { "data": "status" },
            { "data": "desc" },
            { "data": "ctime" },
            { "data": "operator"}
        ],
        "columnDefs": [
            {
                "render": function ( data, type, row ) {
                    return '<a href="'+baseUrl+'/item/detail/' + row["id"] + '">'+ data +'</a>';
                },
                "targets": 2
            }
        ]
    });
    $('#item-table tbody').on( 'click', 'a', function () {
        var url = $(this).data("url");
        $.ajax({
            type: "GET",
            url: url,
            accepts: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(data) {
                table = $("<table/>").addClass("table table-striped table-bordered table-hover");
                var rowHead = $('<tr/>');
                rowHead.append($('<th/>').text("字段"));
                rowHead.append($('<th/>').text("值"));
                table.append(rowHead);
                $.each(data.data, function(name, value) {
                    var row = $('<tr/>');
                    row.append($('<td/>').text(name));
                    row.append($('<td/>').text(value));
                    table.append(row);
                })
                $('.modal-body').html(table.prop("outerHTML"));
                // show modal
                $('#view-modal').modal('show');
                $('#view-modal').on('hidden.bs.modal', function(){
                    
                });
            },
            error:function(request, status, error) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });
        
    });
});