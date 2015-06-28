<?php

include("./config/config.inc.php");

if($debug)
{
    error_reporting(E_ALL | E_COMPILE_ERROR);
    ini_set('display_errors', 1);
}

require_once("classes/sitegenerator.php");

$sitegen = new sitegenerator();

$sitegen->addHeadElement("<meta charset='utf-8'>");

# JQuery
require_once("lib/jquery/loading.php");
$jqueryloader=new jQueryLoader();
$jqueryloader->load($sitegen);

# JQueryUI
require_once("lib/jquery_ui/loading.php");
$jqueryUIloader=new jQueryUILoader();
$jqueryUIloader->load($sitegen);

# Bootstrap
require_once("lib/Bootstrap/loading.php");
$bsloader=new bootstrapLoader();
$bsloader->load($sitegen);

# Es gibt eine JSON Eingabe
if(isset($_POST,$_POST["json"])){
    require_once("classes/rdfMidd/rdfController.php");
    $rdfController= new rdfController();
    $rdfController->readJson($_POST["json"]);

    # Json sollte nun eingelesen sein
    # Hier wird zurzeit das Ausgabeformat bestimmt 
    require_once("classes/rdfMidd/rdfToRdform.php"); 
    $rdfToRdform = new rdfToRdform($rdfController);
    $rdfToRdform->genForm();
    $rdfToRdform->saveForm($rdftemplate);
}

# RDForm
# sollte erst geladen werden wenn die Template Datei erstellt wurde

require_once("lib/loadingRDForm.php");
$rdformloader=new rdformLoader();
$rdformloader->load($sitegen);
$sitegen->loadTemplate("templates/rdform.html","body");
$sitegen->addJavascript("js/rdformInit.js");



$sitegen->plotPage();


?>
