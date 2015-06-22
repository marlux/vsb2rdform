<?php

$turtle="";

$turtle="@prefix rdf: \<http://www.w3.org/1999/02/22-rdf-syntax-ns#\> . \n\n";

if(isset($_POST["json"])) {
    $json = json_decode($_POST["json"]);
    
    $turtle=object2turtle($json,"","",$turtle);    

    print_r($turtle);
}
else {
    print_r(null);
}

function object2turtle($obj,$subject,$parent,$turtle){


    foreach($obj as $object){

        $object_array= (array) $object;
        $prefix="";
        $subject=$subject;
        foreach($object_array as $key =>$elem){

            if($key=="@id"){
                $prefix=$elem;
                continue;
            }

            if($key=="@type"){
                foreach($elem as $type){
                    $turtle.= "$prefix rdf:type $type ;\n";
                }
                continue;
            }

            if($key=="@value") {
                $turtle.= "$parent rdf:value $elem ;\n";
                continue;
            }

            if($parent!="" and $subject!="") {
                $turtle.= "$parent $subject $prefix ;\n";
            }
            
            $turtle=object2turtle($elem,$key,$prefix,$turtle);              
        }
    }

    return $turtle;
}
