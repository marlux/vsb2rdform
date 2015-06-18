


$(document).ready(function(){
    $(".rdform").RDForm({
        template: "templates/testform.html",
        submit: function() {

            $.ajax({
                url:'classes/ajax/json2turtle.php', 
                data:{json: JSON.stringify(this,null,'\t')},
                method:'POST',
                success: function(result){
                    alert(result);
                }
            });
        }
    });
});
