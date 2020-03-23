$(document).ready(function(){
    var pre, curr;
    setInterval(function() {
        $("select[name='schemaTemplateId']").each(function(){
            curr = $(this).val();
            if(curr != pre) {
                pre = curr;
                console.log(curr);
                $('#check-detail').prop('href', '/schema-template/detail/'+curr);
            }
        })
    }, 200);
    
});