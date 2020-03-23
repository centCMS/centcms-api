$(document).ready(function() {
    $('#schema-template-table').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Chinese.json"
        },
        "ajax": {
            "url": baseUrl+"/schema-template/get-list-pageable",
            "dataSrc": function(json) {
                var ret = json.data;
                ret.forEach(function (ele) {
                    ele.operator = "";
                    if (json.operator.view == 1) {
                        ele.operator += '<a class="btn-op" title="查看" data-url="'+baseUrl+'/schema-template/get-detail/' + ele.id + '"><i class="fa fa-eye"></i></a>';
                    }
                    if (json.operator.edit == 1) {
                        ele.operator += '<a class="btn-op" title="编辑" data-url="'+baseUrl+'/schema-template/edit/' + ele.id + '"><i class="fa fa-edit"></i></a>';
                    }
                    if (json.operator.delete == 1) {
                        ele.operator += '<a class="btn-op" title="删除" data-url="'+baseUrl+'/schema-template/delete/' + ele.id + '"><i class="fa fa-cut"></i></a>';
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
                    return '<a href="'+baseUrl+'/schema-template/detail/' + row["id"] + '">'+ data +'</a>';
                },
                "targets": 2
            }
        ]
    });
    $('#schema-template-table tbody').on( 'click', 'a', function () {
        var url = $(this).data("url");
        $.ajax({
            type: "GET",
            url: url,
            accepts: "application/json; charset=utf-8",
            dataType: 'json',
            success: function(data) {
                $('#view-modal').on('hidden.bs.modal', function(){
                    $('.modal-body').empty();
                });
                if(data.errorCode != 0) {
                    $('.modal-body').text(data.errorMsg);
                    $('#view-modal').modal('show');
                    return false;
                }
                var form = $('<form id="result-form"></form>');
                $('.modal-body').append(form);
                var tmp = JSON.parse(data.data.content);
                tmp.onSubmit = function (errors, values) {
                    alert(JSON.stringify(values, null, 4));
                };
                form.jsonForm(tmp);
                // show modal
                $('#view-modal').modal('show');
            },
            error:function(request, status, error) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });
        
    });
    $('#submit-result-form').click(function(){
        $('#result-form').submit();
    });
});