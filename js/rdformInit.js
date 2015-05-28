$(document).ready(function(){
    $(".rdform").RDForm({
        template: "templates/testform.html",
        submit: function() {
            console.log( JSON.stringify(this, null, '\t') );
        }
    });
});
