<?php

/**
 * Generiert die HTML Seiten 
 *
 */ 

class sitegenerator{

    # enthält alle definintionen vom HEADER
    public $head=array();

    # enthält alle definitionen vom Body
    public $body=array();


    #Fügt ein Javascript in den Head ein
    function addJavascript($file)
    {
        $this->addHeadElement("<script type=\"text/javascript\" src=\"$file\"></script>");
    }

    # Fügt eine CSS File in den HEAD hinzu
    function addCss($file)
    {
        $this->addHeadElement("<link href=\"$file\" rel=\"stylesheet\">");
    }
    
    # Fügt ein allgemeines Element in den HEAD hinzu
    function addHeadElement($element)
    {
        $this->head[]=$element;
    }
    
    # Fügt ein allgemeines Element in den Body hinzu
    function addBodyElement($element)
    {
        $this->body[]=$element;
    }
    
    # Gibt die aktuelle generierte Seite aus
    function plotPage()
    {
        echo "<!DOCTYPE HTML>\n";
        echo "<html>\n";
        $this->plotHead();
        $this->plotBody();
        echo "</html>\n";
    }

    # Gibt den Head aus
    function plotHead()
    {
        echo "<head> \n";
        foreach($this->head as $headelement)
        {
            echo $headelement ."\n";
        }
        echo "</head> \n";
    }

    # Gibt den Body aus
    function plotBody()
    {
        echo "<body> \n";
        foreach($this->body as $bodyelement)
        {
            echo $bodyelement . "\n";
        }
        echo "</body> \n";
    }

    # Lädt ein Templateteil aus einer File und fügt es in den HEAD oder BODY ein
    function loadTemplate($file,$pos="body")
    {
        $template = file_get_contents($file);
        
        if($pos=="head"){
            $this->addHeadElement($template);
        }
        
        if($pos=="body"){
            $this->addBodyElement($template);
        }
    }
}


