$(document).ready(function () {
    var editor = ace.edit("editor");
    editor.setReadOnly(true);
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/json");
    var obj = JSON.parse(code, function(key, val) {
        if(typeof val == "string") {
            if(val.startsWith("function")) {
                var tmpFunc = new Function('return ' + val)(); return tmpFunc;
            }
        }
        return val;
    })
    delete obj.schemaTemplateId;
    editor.session.setValue(JSON.stringify(obj, function(key, val) {
        if(typeof val == "function") {
            return val.toString();
        }
        return val;
    }, 2));

});