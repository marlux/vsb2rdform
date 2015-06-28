<?php

# Überführt die Interne Datenstrucktur in RDForm 
class rdfToRdform{
    
    public $rdfController;
    public $html;
    
    # Konstruktor
    function rdfToRdform($data){
        $this->rdfController=$data;
        $this->html = array();
    }

    // Initiert die Formerstellung
    public function genForm()
    {
        $this->is_root_written=false;

        $pre = "<form prefix=\"";
        
        #Erstelle die Namespaces im form element
        foreach($this->rdfController->namespaces as $key=>$namespace){
            $pre.=$key." ".$namespace. " ";
        }
        $pre=trim($pre); 

        $pre.="\">\n";        
        $inner="";
        
        # Verarbeite alle Subjecte
        foreach($this->rdfController->rdfData as $subject)
        {
            $inner.=$this->genclass($subject);
        }
        $post= "</form>\n";
        $this->html=$pre . $inner . $post;
    }
    
    # Speichere das HTML in eine bestimmte Datei
    function saveForm($filename)
    {
        file_put_contents($filename,$this->html);
    }
    
    # Bekomme das Subject aus einer URI
    function getNamespaceType($uri)
    {
        return $this->splitnamespace($uri,0);
    }

    # Teilt eine URI auf und gibt das Subject oder den namespace zurück
    function splitnamespace($uri,$pos) {

        $revUri = strrev($uri);
        $seperator="";

        # Finde den richtigen Seperator
        for($i=0; $i<strlen($revUri); $i++) {
            if($revUri[$i] == "/") {
                $seperator="/";
                break;            
            }
            if($revUri[$i] == "#") {
                $seperator="#";
                break;
            }
        }
        $uri = explode($seperator,$revUri,2);
        # Return Namespace
        if($pos==1){
            $uri = strrev($uri[1]);
            return $uri . $seperator;
        }
        # Return Subject
        else {
            $uri = strrev($uri[0]);
            return $uri;
        }
    }

    # Bekomme kurzform prefix von einer URI
    function getNamespaceKey($uri)
    {
        $namespace=$this->getNamespacefromUri($uri);
        return array_search($namespace,$this->rdfController->namespaces);       
    }
    
    # Holt sich den Namespace aus einer URI
    function getNamespacefromUri($uri)
    {
        return $this->splitnamespace($uri,1);
    }

    # Erzeugt die Subjects
    function genClass($subject)
    {
        $html="<legend>".$subject->alias."</legend>\n";
        $html.="<div typeof=\"".$this->getNamespaceKey($subject->uri).":".$this->getNamespaceType($subject->uri)."\"  id=\"$subject->alias\">\n";
        
        # Erzeugt alle Properties die keine Relationen sind
        foreach($subject->properties as $property){
            if($property->type!="RELATION_PROPERTY"){
                $html.=$this->genProperty($property);
            }
        }

        # Erzeugt alle Properties die RElationen sind
        foreach($subject->properties as $property){
            if($property->type=="RELATION_PROPERTY"){
                $html.=$this->genProperty($property);
            }
        }

        $html.="</div>\n";
        return $html;
    }
    
    # Erzeugt eine Property
    function genProperty($property)
    {
        $html="<label>".$property->alias."</label>\n";
        $html.="<input name=\"".$this->getNamespaceKey($property->uri).":".$this->getNamespaceType($property->uri)."\"";

        # Prüft von welchen Typ die Property ist
        switch($property->type){
        case "STRING_PROPERTY":
        case "NUMBER_PROPERTY":
            $html.=" type=\"literal\" >\n";
            break;
        case "RELATION_PROPERTY":

            $html.=" type=\"resource\" ";

            if ($property->linkTo != null) {
                $namespace=$this->getNamespaceKey($this->rdfController->rdfData[$property->linkTo]->uri);
                $html.=" value=\"$property->linkTo\"  >\n";
            } else {
                $namespace=$this->getNamespaceKey($property->uri);
                $html.=" value=\"".$namespace.":".$this->getNamespaceType($property->uri)."\" external>\n";
            }


            break;
        case "DATE_PROPERTY":
            $html.=" type=\"literal\" placeholder=\"JJJJ-MM-DD\">\n";
            break;
        }
        return $html;
    }   
}
