""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
Code and Design:
----------------
� von "H0walD & Balthazar3k"
� auf Basis von IlchClan 1.1 P
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

Beschreibung:
-------------
� Diese Modul erweitert den Download Bereich.
� Ihr habt die M�glichkeit Download Kategorien zu erstellen und jeweils ein Bild direkt im Adminbereich hochzuladen.
� Ihr habt die M�glichkeit Screenshot oder Bilder f�r die Downloads im Adminbereich hochzuladen.
� Ihr habt die M�glichkeit das no Image Bild im Adminbereich hochzuladen.
� Ihr entscheidet ab welchem Recht ein Download zu Verf�gung steht. Einstellbar bei jeder einzelnen Kategorie oder Download.
� Demolink-Button,  Screenshot-Button (als Popup Vorschau) und Download-Button werden Rot angezeigt wenn man keine Rechte daf�r hat, oder nichts eingetragen wurde.
usw. testet es einfach =)
� Admin`s  sehen bei den Download noch einen Bearbeiten Button, damit sie direkt auf die Einzelnen Download`s zugreifen k�nnen.

 


Voraussetzungen:
----------------
� IlchClan 1.1 P
� Ilch bbcode 2.0P muss installiert sein http://www.ilch.de/downloads-show-1742.html


Installation:
-------------
� Backup der Ordner-Struktur und der DB anlegen!
� Alle Dateien im Ordner Upload in ihrer Ordnerstruktur hochladen
� Im Normalfall k�nnen alle Dateien �berschrieben werden. 


Tipps:
-------------
� Alle Bilder k�nnen im Backend Bereich (Admin) direkt hochgeladen werden.
� Die Kategorie Bilder sollten alle die gleiche Gr��e haben. 
� Die Kategorie Bilder sollten eine Breite von 220px haben.
� in der download-cate.css unter include/includes/css/download-cate.css k�nnt ihr in der Zeile 10 einstellen ob ihr zwei oder drei download nebeneinander haben m�chtet.
� ( einfach den width: xx% wert auf 50 % bei zwei oder den Wert auf 33.33% bei drei Download`s bzw. Kategorien einstellen )


Ersetzt:
-------------
Backend:
� archiv.php
� downloads.htm
� upload.htm

Frontent:
� downloads.php
� downloads.htm
� downloads_show.htm

Und einige Dateien werden neu Installiert + drei neue Msql Eintr�ge werden neu gemacht.


Bekannte Einschr�nkungen / Fehler:
----------------------------------
*keine

Haftungsausschluss:
-------------------
Ich �bernehme keine Haftung f�r Sch�den, die durch dieses Skript entstehen.
Benutzung ausschlie�lich AUF EIGENE GEFAHR.

Fehler bitte im Forum von howald-design.ch oder auf ilch.de posten!