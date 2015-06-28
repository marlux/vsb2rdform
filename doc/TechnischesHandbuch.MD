### Technisches Handbuch

## Allgemein

Dieses Programm kann Daten vom VSB in RDForm kompatible Templates umwandeln. Das Programm ist 
in PHP und Javascript geschrieben.

## Ordnerstrucktur

Beschreibt welcher Ordner für was zuständig ist

# classes

Enthält alle PHP Klassen die benötigt werden um die Programmlogik auszuführen. Dabei gibt es zurzeit zwei Unterordner

  * Ajax: Enthält die Klassen zur Auswertung wenn die Form ausgefüllt wurde
  * rdfMidd: Enthält die Klassen zur Verarbeitung der JSON RDF Daten
    * rdftordform.php ist die Überführungsdatei in die Templateform

Zusätzlich enthält dieser Ordner zwei Dateien

  * libloader.php: Abstrakte Klasse zum laden von externen Bibliothen wie JQuery
  * sitegenerator.php: Einfache PHP HTML Engine

# Config

Enthält die Configurationsdaten

  * config.inc.php: Konfig zur Verwaltung des Programms
  * rdf_config.inc.php: Konfig zum Verwalten der RDF Daten

# CSS 

Enthält alle CSS Dateien

# DOC

Enthält die Dokumentation

# Input

Enthält Beispiel JSON Dateien

# JS 

Enthält alle Javascript Dateien

  * rdfformInit.js: Initiert rdfform hier kann das angezeigte Template unter Template geändert werden

# lib

Enthält alle externe Bibliotheken. Die in den Ordnern jeweils enthaltene Loading.php lädt die Bibliothek. Falls eine Bibliothek per Submodule hinzugefügt wurde, wird es empfohlen sie in die loading.php im root des lib-Ordners einzufügen.

Standardmässig sind folgende Bibliotheken enthalten

  * Bootstrap
  * JQuery + UI
  * RDForm

# templates

Enthält alle Templates + die erstellten RDF Tempaltes

## Erweiterbarkeit:

# Änderung der Ausgabeart

Falls irgendwann etwas anderes Ausgegeben werden soll muss folgendes gemacht werden:

  * in der Index.php oder CLi.php muss die rdf2Form.php entfernt und die neue ausgaberoutine eingefügt werden. 
  * Diese muss auch den rdfController übergeben werden
  * Dieser hält alle RDF Subjects in einen Array und alle Namespaces 
  * Diese können in der neuen Ausgaberoutine verarbeitet werden


