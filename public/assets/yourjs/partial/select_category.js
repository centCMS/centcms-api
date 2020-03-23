$(document).ready(function () {
    var currCategoryCode = selectCategory.category.id;
    var currCategoryName = selectCategory.category.name;

    var onchange = function (valueId) {
        return function (e, oldValue, newValue) {
            if("redirectTo" in selectCategory) {
                if(oldValue.length > 0) {
                    window.location = selectCategory.redirectTo + '/' + newValue[0].code;
                }
            }
            console.log('=====onchange======', valueId, newValue);
            $('#' + valueId).val(JSON.stringify(newValue));
        };
    };
    var oninit = function (csdId, valueId) {
        return function () {
            $('#category-selecter').bsCascader('setValue', [{"code": currCategoryCode, "name": currCategoryName}]);
            console.log('=====oninit======', csdId);
            var value = $('#' + csdId).data('bsCascader').getValue();
            console.log("init", value);
            $('#' + valueId).val(JSON.stringify(value));

        };
    };
    var onselect = onclear = onreload = function (eventType, bsId) {
        return function () {
            console.log('====' + eventType + '====', bsId)
        }
    };
    var getListeners = function (csdId, valueId) {
        return {
            'bs.cascader.change': onchange(valueId), 'bs.cascader.inited': oninit(csdId, valueId),
            'bs.cascader.select': onselect('onselect', csdId), 'bs.cascader.reloaded': onreload('onreload', csdId),
            'bs.cascader.clear': onclear('onclear', csdId)
        }
    };
    var createMockData = function (openedItems, justLastLevelSelectable) {
        console.log(openedItems, justLastLevelSelectable);
        var level = openedItems.length + 1, data = [];
        var parentCode = currCategoryCode;
        if (openedItems.length > 0) {
            var parentItem = openedItems[openedItems.length - 1];
            parentCode = parentItem.code;
        }
        $.ajax({
            type: "GET",
            url: baseUrl + "/category/get-list",
            accepts: "application/json; charset=utf-8",
            async: false,
            data: {
                "categoryId" : parentCode
            },
            dataType: 'json',
            success: function(json) {
                $.each(json.data, function (idx, obj) {
                    var item = {code: idx, name: obj.name};
                    if(!obj.hasOwnProperty("children")) {
                        item.hasChild = false;
                    }else {
                        item.children = obj.children;
                    }
                    data.push(item);
                    item.selectable = !justLastLevelSelectable || level == 4;
                });
            },
            error:function(request, status, error) {
                console.log("ajax call went wrong:" + request.responseText);
            }
        });
        
        return data;
    };
    var mockLazyLoadFn = function (csdId, justLastLevelSelectable = false) {
        return function (openedItems, callback) {
          console.log('------mockLazyLoadFn------', csdId, openedItems);
          setTimeout(function () {
            callback(createMockData(openedItems, justLastLevelSelectable));
          }, 500);
        }
    };
    // category-selecter
    $('#category-selecter').on($.extend(getListeners('category-selecter', 'category-value'), {})).bsCascader({
        splitChar: ' / ',
        openOnHover: true,
        lazy: true,
        loadData: mockLazyLoadFn('category-selecter')
    });

    $('#reset-cascader').click(function () {
        $('#category-selecter').bsCascader('setValue', [{"code": currCategoryCode, "name": currCategoryName}]);
    });
});