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
        $this->is_root_written=false;

        $pre = "<form prefix=\"";

        foreach($this->rdfController->namespaces as $key=>$namespace){
            $pre.=$key." ".$namespace. " ";
        }
        $pre=trim($pre); 

        $pre.="\">\n";        
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

    function getNamespaceType($uri)
    {
        $revUri=strrev($uri);
        $uri = explode("/",$revUri,2);
        $uri = strrev($uri[0]);
        return $uri;
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
        return $uri . "/";
    }

    function genClass($subject)
    {
        $html="<legend>".$subject->alias."</legend>\n";
        $html.="<div typeof=\"".$this->getNamespaceKey($subject->uri).":".$this->getNamespaceType($subject->uri)."\">\n";

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
        $html.="<input name=\"".$this->getNamespaceKey($property->uri).":".$this->getNamespaceType($property->uri)."\"";

        switch($property->type){
        case "STRING_PROPERTY":
        case "NUMBER_PROPERTY":
            $html.=" type=\"literal\" >\n";
            break;
        case "RELATION_PROPERTY":
            if ($property->linkTo != null) {
                $namespace=$this->getNamespaceKey($this->rdfController->rdfData[$property->linkTo]->uri);
                $html.=" type=\"resource\" value=\"".$namespace.":".$property->linkTo."\" subform=\"".$property->alias."\" >\n";
            } else {
                $namespace=$this->getNamespaceKey($property->uri);
                $html.=" type=\"resource\" value=\"".$namespace.":".$this->getNamespaceType($property->uri)."\" external subform=\"".$property->alias."\">\n";
            }


            break;
        case "DATE_PROPERTY":
            $html.=" type=\"literal\" placeholder=\"JJJJ-MM-DD\">\n";
            break;
        }
        return $html;
    }   
}
