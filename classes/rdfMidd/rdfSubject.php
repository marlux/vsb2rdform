<?php

# Beschreibt ein RDF Subject
class rdfSubject{

    public $alias;
    public $uri;
    public $properties;

    function rdfSubject(){
        $this->properties=array();

    }
}
