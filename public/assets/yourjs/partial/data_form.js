// document.addEventListener('DOMContentLoaded', function() {
$(document).ready(function () {
    var schemaList = [];
    $.ajax({
        type: "GET",
        async: false,
        url: baseUrl + '/schema-template/get-list',
        data: {
            "ids": (typeof schemaIds == 'undefined') ? [] : schemaIds
        },
        accept: "application/json; charset=utf-8",
        dataType: 'json',
        success: function(obj) {
            schemaList = obj.data;
        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
    
    var generateForm = function (json, selected) {
        // Reset result pane
        $('#result').html('');
        // Parse entered content as JavaScript
        // (mostly JSON but functions are possible)
        var createdForm = null;
        try {
            // Most examples should be written in pure JSON,
            // but playground is helpful to check behaviors too!
            // eval('createdForm=' + json);
            var createdForm = JSON.parse(json, function(key, val) {
                if(typeof val == "string") {
                    if(val.startsWith("function")) {
                        return new Function('return ' + val)();
                    }
                }
                return val;
            })
        }
        catch (e) {
            $('#result').html('<pre>Entered content is not yet a valid' +
                ' JSON Form object.\n\nJavaScript parser returned:\n' +
                e + '</pre>');
            return;
        }
        createdForm.schema.properties = { 
            schemaTemplateId : {
                title: '选择模板',
                type: 'integer',
                enum: function(){
                    return schemaList.map(function(value) {
                        return value["id"];
                    });
                }()
            },
            ...createdForm.schema.properties
        };
        
        var selector = {
            key: 'schemaTemplateId',
            notitle: true,
            prepend: '选择模板',
            htmlClass: 'tryWith',
        }
        if(createdForm.form) {
            createdForm.form.unshift(selector);
        }

        // Render the resulting form, binding to onSubmitValid
        try {
            createdForm.prefix = 'centcms_tpl_'+selected;
            createdForm.onSubmitValid = function (values) {
                console.log('Values extracted from submitted form', values);
                var contents = $('#result-form').jsonFormValue();
        
                var list = $("#item-form").serializeObject();

                var token = $("meta[name='csrf-token']").attr("content").split(",");
                list[token[0]] = token[1];
                
                list.schemaTemplateId = contents.schemaTemplateId;
                list.content = JSON.stringify(contents);
                var categoryList = JSON.parse(list['category-value']);
                list.categoryId = categoryList[categoryList.length-1].code;

                console.log(list);
                $('#loading-div').show();
                $.ajax({
                    url: baseUrl + '/item/create',
                    dataType: "json",
                    type: 'POST',
                    data: list
                }).done(function (data) {
                    $('#loading-div').hide();
                    bootsalert({
                        className: "success",
                        message: "提交成功！",
                        container: "alert-div",
                        closebtn: true
                    });
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
            };
            createdForm.onSubmit = function (errors, values) {
                if (errors) {
                    $.each(errors, function(idex, err) {
                        $('.modal-body').append(err.schemaUri.split("#")[1] + ' ' + err.message);
                    });
                    // show modal
                    $('#view-modal').modal('show');
                    console.log('Validation errors', errors);
                    return false;
                }
                return true;
            };
            $('#result').html('<form id="result-form" class="form-vertical"></form>');
            $('#result-form').jsonForm(createdForm);
            $('select[name="schemaTemplateId"]').on("change", function(evt){
                var currSelected = $(evt.target).val();
                $.each(schemaList, function(_, item) {
                    console.log("#####", parseInt(currSelected), item.id, item);
                    if(parseInt(currSelected) === item.id) {
                        generateForm(item.content, currSelected);
                    }
                })
            });
            $('select[name="schemaTemplateId"]').val(parseInt(selected));
            $("select[name='schemaTemplateId'] > option").each(function(_, i) {
                $.each(schemaList, function(_, item) {
                    var tmpId = parseInt($(i).val());
                    if(item.id === tmpId) {
                        console.log(item.name);
                        $(i).text(item.name)
                    }
                })
            })
        }
        catch (e) {
            $('#result').html('<pre>Entered content is not yet a valid' +
                ' JSON Form object.\n\nThe JSON Form library returned:\n' +
                e + '</pre>');
            return;
        }
    };

    generateForm(schemaList[0].content, schemaList[0].id);
});