<?php

require_once("classes/rdfMidd/rdfProperty.php");
require_once("classes/rdfMidd/rdfSubject.php");

# Hält die RDF Daten in einer internen Datenstruktur
class rdfController{

    public $rdfData;
    public $namespaces;
    public $rootClass;
    public $namespacecounter=0;
    
    # Konstruktor
    function rdfController(){
        $this->rdfData=array();
    }
    
    # Ließ ein JSONobjekt ein
    function readJson($json){
        $data = json_decode($json);
        $this->cullSubjects($data);
        $this->getNamespaces();
        $this->getRootClass($data);
    }

    # Ließt eine JSON Datei ein
    function readJsonFromFile($file){
        if(!is_file($file)){
            die("Datei existiert nicht");
        }
        $json = file_get_contents($file);
        $this->readJson($json);
    }

    # Verarbeite alles Subjekte
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
    
    # Verarbeite alle Properties eines Subjects
    function getNamespaces(){
        
        $this->namespaces = array();

        foreach($this->rdfData as $subject){
            $this->namespaces["n" . $this->namespacecounter]=$this->getNamespacefromUri($subject->uri);
            $this->namespacecounter++;
            
            foreach($subject->properties as $property){
                $uri = $this->getNamespacefromUri($property->uri);
                if($uri != "")
                {
                    $this->namespaces["n" . $this->namespacecounter]=$this->getNamespacefromUri($property->uri);
                    $this->namespacecounter++;
                }
            }
        }
        $this->namespaces=array_unique($this->namespaces,$sort_flags = SORT_STRING);
    }

    # Holt sich den Namespace aus einer URI herraus
    function getNamespacefromUri($uri)
    {
        $revUri = strrev($uri);
        $seperator="";
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
 
        $uri    = explode($seperator,$revUri,2);
        $uri = strrev($uri[1]);
        return $uri . $seperator;
    }

    // Holt sich die Wurzelklasse
    function getRootClass($data){
        $this->rootClass=$data->START->linkTo;
    }
    }
