$(document).ready(function() {
    $('#blog-sidebar').remove();
    $('#blog-main').addClass('col-sm-12').removeClass('col-sm-8');

    $('#item-table').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Chinese.json"
        },
        "ajax": {
            "url": baseUrl+"/item/get-list-pageable",
            "data": {
                "categoryId": cateId
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
            { "data": "ctime" }
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
});