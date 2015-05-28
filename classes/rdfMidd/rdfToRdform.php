<?php

class rdfToRdform{
    
    public $rdfController;
    public $html;

    function rdfToRdform($data){
        $this->rdfController=$data;
        $this->html = array();
    }

    public function genForm()
    {
        $pre = "<form prefix=\"";

        foreach($this->rdfController->namespaces as $key=>$namespace){
            $pre.=$key." ".$namespace. " ";
        }
        $pre=trim($pre); 

        $pre.="\">";        
        $inner="";

        foreach($this->rdfController->rdfData as $subject)
        {
            $inner.=$this->genclass($subject);
        }
        
        $post= "</form>\n";
        $this->html=$pre . $inner . $post;
    }

    function saveForm($filename)
    {
        file_put_contents($filename,$this->html);
    }

    function getNamespaceKey($uri)
    {
        $namespace=$this->getNamespacefromUri($uri);
        return array_search($namespace,$this->rdfController->namespaces);       
    }
   
    function getNamespacefromUri($uri)
    {
        $revUri = strrev($uri);
        $uri    = explode("/",$revUri,2);
        $uri = strrev($uri[1]);
        return $uri;
    }

    function genClass($subject)
    {
        $html="<legend>".$subject->alias."</legend>\n";
        $html.="<div typeof=\"".$this->getNamespaceKey($subject->uri).":".$subject->alias."\">\n";

        foreach($subject->properties as $property){
            if($property->type!="RELATION_PROPERTY"){
                $html.=$this->genProperty($property);
            }
        }
        
        foreach($subject->properties as $property){
            if($property->type=="RELATION_PROPERTY"){
                $html.=$this->genProperty($property);
            }
        }

        $html.="</div>\n";
        return $html;
    }

    function genProperty($property)
    {
        $html="<label>".$property->alias."</label>\n";
        $html.="<input name=\"".$this->getNamespaceKey($property->uri).":".$property->alias."\"";

        switch($property->type){
        case "STRING_PROPERTY":
        case "NUMBER_PROPERTY":
            $html.=" type=\"literal\" >\n";
            break;
        case "RELATION_PROPERTY":
            $namespace=$this->getNamespaceKey($this->rdfController->rdfData[$property->linkTo]->uri);
            $html.=" type=\"resource\" value=\"".$namespace.":".$property->linkTo."\" >\n";
            break;
        case "DATE_PROPERTY":
            $html.=" type=\"literal\" placeholder=\"JJJJ-MM-DD\">\n";
            break;
        }
        return $html;
    }   
}
