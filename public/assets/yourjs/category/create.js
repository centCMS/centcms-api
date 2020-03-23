$(document).ready(function () {
    $('#category-form').submit(function () {
        $('#loading-div').show();
        var list = $('#category-form').serializeObject();
        var token = $("meta[name='csrf-token']").attr("content").split(",");
        list[token[0]] = token[1];
        var categoryList = JSON.parse(list['category-value']);
        list.parentId = categoryList[categoryList.length - 1].code;
        $.ajax({
            url: baseUrl + '/category/create',
            dataType: "json",
            type: 'POST',
            data: list
        }).done(function (data) {
            $('#loading-div').hide();
            if(data.errorCode == 0) {
                bootsalert({
                    className: "success",
                    message: "提交成功！",
                    container: "alert-div",
                    closebtn: true
                });
            } else {
                bootsalert({
                    className: "danger",
                    message: data.errorMsg,
                    container: "alert-div",
                    closebtn: true
                });    
            }
            console.log(data);
        }).fail(function () {
            $('#loading-div').hide();
            bootsalert({
                className: "danger",
                message: "Ajax请求错误！",
                container: "alert-div",
                closebtn: true
            });
        });
        return false;
    });

});