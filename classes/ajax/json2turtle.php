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

function object2turtle($obj,$subject,$parent,$turtle){

require("../../config/rdf_config.inc.php");

    foreach($obj as $object){

        $object_array= (array) $object;
        $prefix="";
        foreach($object_array as $key =>$elem){

            if($key=="@id"){
                if($parent != "" and $subject != "") {
                    $turtle.= "$parent &lt;$subject&gt; &lt;$elem&gt; .\n";
                }
    
                $prefix="&lt;". $baseURL . $elem ."&gt; ";
                continue;
            }

            if($key=="@type"){
                foreach($elem as $type){
                    $turtle.= "$prefix rdf:type &lt;$type&gt; .\n";
                }
                continue;
            }

            if($key=="@value") {
                $turtle.= "$parent rdf:value \"$elem\" .\n";
                continue;
            }

            if($parent!="" and $subject!="") {
               
                $turtle.= "$parent &lt;$subject&gt; $prefix .\n";
            }
            
            $turtle=object2turtle($elem,$key,$prefix,$turtle);              
        }
    }

    return $turtle;
}
