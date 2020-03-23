$(document).ready(function () {
    $('#item-form').on("submit", function(){
        $('#result-form').submit();
        return false;
    });
});