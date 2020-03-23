var bootsalert = function(val){
    if(!val.className)
    {
        console.error("className must be filled");
    }
    else if(!val.message)
    {
        console.error("message must be filled");
    }
    else if(!val.container)
    {
        console.error("container must be filled");
    }
    else
    {
        /**
         * className    : set bootstrap alert class, like success, info, ..., or developer can use their own custom class
         * message      : message that will displayed to user
         * container    : alert will be inserted to this component. Selected component must have id attributes
         * closebtn     : if true, alert will have close button with fade effect
         * append       : bootsalert can be appended with several alert elements in one container
         */
        className   = val.className;
        message     = val.message;
        container   = val.container;
        closebtn    = val.closebtn;
        append      = val.append;

        closeclass  = "";
        closealert  = "";
        
        if(val.closebtn == true)
        {
            closeclass = " alert-dismissible";
            closealert = "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        }
        createHTML =
        "<div class='alert alert-"+ className +" "+ closeclass +"'>"+
            closealert +
            message +
        "</div>";
        if(append == true)
        {
            document.getElementById(container).innerHTML += createHTML;
        }
        else
        {
            document.getElementById(container).innerHTML = createHTML;
        }
    }
};