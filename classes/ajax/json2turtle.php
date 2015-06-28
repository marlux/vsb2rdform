<?php

$turtle="";

$turtle.="@prefix rdf: &lt;http://www.w3.org/1999/02/22-rdf-syntax-ns#&gt; . \n\n";

if(isset($_POST["json"])) {
    $json = json_decode($_POST["json"]);
    
    $turtle=object2turtle($json,"","",$turtle);    

    print_r($turtle);
}
else {
    print_r(null);
}

// Überführt ein JSON-LD Objekt in die Turtle Syntax
function object2turtle($obj,$subject,$parent,$turtle){

require("../../config/rdf_config.inc.php");

    # Iteriere Über die Objecte
    foreach($obj as $object){
        
        # Hole dir alle Einträge des aktuellen Objects
        $object_array= (array) $object;
        $prefix="";
        # Iteriere über die Objecteinträge
        foreach($object_array as $key =>$elem){
            
            # Auswertung @id Field
            if($key=="@id"){
                if($parent != "" and $subject != "") {
                    $turtle.= "$parent &lt;$subject&gt; &lt;$elem&gt; .\n";
                }
    
                $prefix="&lt;". $baseURL . $elem ."&gt; ";
                continue;
            }
            
            # Auswertung @type Field
            if($key=="@type"){
                foreach($elem as $type){
                    $turtle.= "$prefix rdf:type &lt;$type&gt; .\n";
                }
                continue;
            }
            
            # Auswertung @value Field
            if($key=="@value") {
                $turtle.= "$parent rdf:value \"$elem\" .\n";
                continue;
            }

            # Falls ein Object ein Unterobjekt hat trage es ein
            if($parent!="" and $subject!="") {
               
                $turtle.= "$parent &lt;$subject&gt; $prefix .\n";
            }

            # Führe die Berechnung für das unterobject 
            $turtle=object2turtle($elem,$key,$prefix,$turtle);              
        }
    }

    return $turtle;
}
