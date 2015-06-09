<?php

if(isset($argv[1]) and is_file($argv[1])){
    require_once("classes/rdfMidd/rdfController.php");
    $rdfController= new rdfController();
    $rdfController->readJsonFromFile($argv[1],$rdfController);

    # Json sollte nun eingelesen sein
    require_once("classes/rdfMidd/rdfToRdform.php"); 
    $rdfToRdform = new rdfToRdform($rdfController);
    $rdfToRdform->genForm();
    print_r($rdfToRdform->html);
}
else
{
    echo("Fehler beim einlesen der JSON Datei");
}

