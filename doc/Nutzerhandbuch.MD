### NUTZERHANDBUCH

# Allgemein

Dieses Programm verarbeitet die Anfragen des Visual SPARQL Builders und erstellt daraus RDForms.

Die Anfragen vom Visual SPARQL Builder werden als JSON exportiert und an die Oberfläche übergeben.

# Erstellung eines passenden JSON Datei 

Nachdem man sich lokal den Visual SPARQL Builder (VSB) eingerichtet hat oder die Online Version nutzt erstellt man sich eine gewünschte Query. 
Dabei werden die Properties, welche ausgewält wurden als Felder in der Form später angezeigt. 
Andere Objekte können auch in die Form überführt werden und die Relationen zu ihnen. 

Anmerkung die Verkettungstiefe kann zurzeit nur eine Tiefe von zwei erreichen. Das heißt, dass von dem Wurzelelement nur eine Ebene Tiefer gegangen werden kann.

Constraints werden auch noch nicht überführt nur die Relationen.

Wenn die Query komplett ist benutzt man in der linken Leiste den Button RunQuery und dann Save as JSON. Wichtig ist, dass die davor angezeigte JSON Code nicht benutzt wird.
Dieser unterscheidet sich mit dem gedownloadeten minimal jedoch sind diese Unterschiede für die Verarbeitung relevant.

# Ausführung des Programms

  * Füge den Inhalt der JSON Datei in die Textbox unter JSON INPUT
  * Drücke auf den Knopf "Submit Query"
  * Es wird nun das Ergebnis der Form RDF Form Output angeziegt.
  * Zusätzlich wird im Template Verzeichnis die Form gespeichert
  * Standardmässig => Testform.html --> in der rdf_Config.inc.php im Configverzeichnis anpassbar
  * Wenn der Pfad in der Config geändert wird und diese auch in der Vorschau angezeigt werden soll, muss zusätzlich in js/rdformInit.js der Parameter template angepasst werden

# Ausführung des Programms als Terminalsoftware

  * Es muss die Datei cli.php mithilfe von PHP aufgerufen werden
  * Der erste Parameter ist ein Verweis auf die JSON Datei welche verarbeitet werden soll
  * Ausgegeben wird der ein rdform compatibles RDF Template
  * BSP. php cli.php ./input/input.json

# Testausgabe

  * Die Testform kann ausgefüllt werden und abgeschickt werden
  * wird dies gemacht wird in dem Abschnitt Ausgabe die Eingabe in JSON-LD und in Turtle angezeigt.
  * Damit kann überprüft werden, ob die Form korrekt arbeitet

# Einschränkungen

  * Viele Feldarten können noch nicht erzeugt werden
    * Constraints, Option, Multiple etc.
  * Es können nur Daten der Tiefe zwei angezeigt werden
