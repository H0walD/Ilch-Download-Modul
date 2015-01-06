""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
Code and Design:
----------------
° von "H0walD & Balthazar3k"
° auf Basis von IlchClan 1.1 P
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Beschreibung:
-------------
° Diese Modul erweitert den Download Bereich.
° Ihr habt die Möglichkeit Download Kategorien zu erstellen und jeweils ein Bild direkt im Adminbereich hochzuladen.
° Ihr habt die Möglichkeit Screenshot oder Bilder für die Downloads im Adminbereich hochzuladen.
° Ihr habt die Möglichkeit das no Image Bild im Adminbereich hochzuladen.
° Ihr entscheidet ab welchem Recht ein Download zu Verfügung steht. Einstellbar bei jeder einzelnen Kategorie oder Download.
° Demolink-Button,  Screenshot-Button (als Popup Vorschau) und Download-Button werden Rot angezeigt wenn man keine Rechte dafür hat, oder nichts eingetragen wurde.
usw. testet es einfach =)
° Admin`s  sehen bei den Download noch einen Bearbeiten Button, damit sie direkt auf die Einzelnen Download`s zugreifen können.

 


Voraussetzungen:
----------------
° IlchClan 1.1 P
° Ilch bbcode 2.0P muss installiert sein http://www.ilch.de/downloads-show-1742.html
° php Version 5.5 oder höher


Installation:
-------------
° Backup der Ordner-Struktur und der DB anlegen!
° Alle Dateien im Ordner Upload in ihrer Ordnerstruktur hochladen
° install ausführen (www.DeineDomain.de/install.php)
° Im Normalfall können alle Dateien überschrieben werden. 


Tipps:
-------------
° Alle Bilder können im Backend Bereich (Admin) direkt hochgeladen werden.
° Die Kategorie Bilder sollten alle die gleiche Größe haben. 
° Die Kategorie Bilder sollten eine Breite von 220px haben.
° in der download-cate.css unter include/includes/css/download-cate.css könnt ihr in der Zeile 10 einstellen ob ihr zwei oder drei download nebeneinander haben möchtet.
° ( einfach den width: xx% wert auf 50 % bei zwei oder den Wert auf 33.33% bei drei Download`s bzw. Kategorien einstellen )


Ersetzt:
-------------
Backend:
° archiv.php
° downloads.htm
° upload.htm

Frontent:
° downloads.php
° downloads.htm
° downloads_show.htm

Und einige Dateien werden neu Installiert + drei neue Msql Einträge werden neu gemacht.


Bekannte Einschränkungen / Fehler:
----------------------------------
*keine

Haftungsausschluss:
-------------------
Ich übernehme keine Haftung für Schäden, die durch dieses Skript entstehen.
Benutzung ausschließlich AUF EIGENE GEFAHR.

Fehler bitte im Forum von howald-design.ch oder auf ilch.de posten!
