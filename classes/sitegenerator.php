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

    function addCss($file)
    {
        $this->addHeadElement("<link href=\"$file\" rel=\"stylesheet\">");
    }

    function addHeadElement($element)
    {
        $this->head[]=$element;
    }

    function addBodyElement($element)
    {
        $this->body[]=$element;
    }

    function plotPage()
    {
        echo "<!DOCTYPE HTML>\n";
        echo "<html>\n";
        $this->plotHead();
        $this->plotBody();
        echo "</html>\n";
    }

    function plotHead()
    {
        echo "<head> \n";
        foreach($this->head as $headelement)
        {
            echo $headelement ."\n";
        }
        echo "</head> \n";
    }

    function plotBody()
    {
        echo "<body> \n";
        foreach($this->body as $bodyelement)
        {
            echo $bodyelement . "\n";
        }
        echo "</body> \n";
    }

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


