function replaceAll(find, replace, str) {
      return str.replace(new RegExp(find, 'g'), replace);
}


$(document).ready(function(){
    $(".rdform").RDForm({
        template: "templates/testform.html",
        submit: function() {
                var json = JSON.stringify(this,null,'\t');
            $.ajax({
                url:'classes/ajax/json2turtle.php', 
                data:{json: json},
                method:'POST',
                success: function(result){
                    json=replaceAll("\n","<br>",json);
                    result=replaceAll("\n","<br>",result);
                    $("#json-ld").html("<h2>JSON-LD</h2>"+json);
                    $("#turtle").html("<h2>Turtle</h2>"+result);
                }
            });
        }
    });
});
