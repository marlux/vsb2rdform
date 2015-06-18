<?php

require_once("classes/libloader.php");

class jQueryUILoader extends libloader{

    function load($site){
        $site->addJavascript("lib/jquery_ui/jquery-ui.min.js");
        $site->addCss("lib/jquery_ui/jquery-ui.min.css");
    }
}

