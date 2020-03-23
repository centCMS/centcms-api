$(document).ready(function () {

    var editor = ace.edit("editor");
    editor.setReadOnly(true);
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/json");
    var obj = JSON.parse(code);
    delete obj.schemaTemplateId;
    editor.session.setValue(JSON.stringify(obj, null, 2));

});