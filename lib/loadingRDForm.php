<?php

require_once("classes/libloader.php");

class rdformLoader extends libloader{

    function load($site){
        $site->addJavascript("lib/RDForm/js/rdform.js");
    }
}
