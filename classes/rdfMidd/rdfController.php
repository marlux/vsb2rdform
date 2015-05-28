<?php

require_once("classes/rdfMidd/rdfProperty.php");
require_once("classes/rdfMidd/rdfSubject.php");

class rdfController{

    public $rdfData;
    public $namespaces;
    public $rootClass;

    function rdfController(){
        $this->rdfData=array();
    }
 
    function readJson($json, $rdfController){
        $data = json_decode($json);
        $this->cullSubjects($data);
        $this->getNamespaces();
        $this->getRootClass($data);
    }


    function readJsonFromFile($file,$rdfController){
        if(!is_file($file)){
            die("Datei existiert nicht");
        }
        $json = file_get_contents($file);
        $this->readJson($json,$rdfController);
    }

    function cullSubjects($data)
    {
        foreach($data->SUBJECTS as $subject){
            $sub = new rdfSubject();
            $sub->alias=$subject->alias;
            $sub->uri=$subject->uri;
            $this->cullProperties($sub,$subject);
            $this->rdfData[$sub->alias]=$sub;
        }
    }

    function cullProperties($sub,$data)
    {
        foreach($data->properties as $property){
            $prop = new rdfProperty();
            $prop->type=$property->type;
            $prop->uri=$property->uri;
            $prop->linkTo=$property->linkTo;
            $prop->optional=$property->optional;
            $prop->alias=$property->alias;
            $sub->properties[]=$prop;
        }
    }

    function getNamespaces(){
        $this->namespaces = array();

        foreach($this->rdfData as $subject){
            $this->namespaces[]=$this->getNamespacefromUri($subject->uri);
            
            foreach($subject->properties as $property){
                $uri = $this->getNamespacefromUri($property->uri);
                if($uri != "")
                {
                    $this->namespaces[]=$this->getNamespacefromUri($property->uri);
                }
            }
        }

        $this->namespaces=array_unique($this->namespaces,$sort_flags = SORT_STRING);
    }

    function getNamespacefromUri($uri)
    {
        $revUri = strrev($uri);
        $uri    = explode("/",$revUri,2);
        $uri = strrev($uri[1]);
        return $uri;
    }

    function getRootClass($data){
        $this->rootClass=$data->START->linkTo;
    }
}
