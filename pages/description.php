<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version November 2017
 */
#
$string='
<div>Ein URL hat in Redaxo die Normalform
<code>index.php?article_id=ID&amp;clang=CID</code>
mit Verweis auf die Artikel-Id <tt>ID</tt> und die Sprach-Id <tt>CID</tt>.
In der Regel soll stattdessen jeder Artikel einen &quot;Wunsch-URL&quot;
erhalten, z. B. mit Hinweisen auf Themenkategorien, Artikelinhalt,
Site-Struktur usw. In diesem AddOn werden dazu die Id, der Sprach-Code
und der Name des Artikels herangezogen. - Dieses AddOn lässt auch die
Nutzung von Links in Normalform zu.</div>
<br/>
<div style="font-weight:bold;">RewriteRule in der .htaccess-Datei</div>
<div style="padding-left:20px;">Links auf Artikel werden üblicherweise
in der Form &nbsp; <span style="white-space:nowrap;"><tt>
RewriteRule ^(.*)$ index.php?%{QUERY_STRING} [L]</tt></span> &nbsp;
umgeleitet. Da Redaxo keinen entsprechenden Artikel hat, landet die
Umleitung auf dem Site-Startartikel.</div>
<br/>
<div style="font-weight:bold;">Setzen des Wunsch-URLs</div>
<div style="padding-left:20px;">Dazu ist eine Erweiterung des
<code>Extension Point URL_REWRITE</code> erforderlich. Die am Extension
Point aufgerufene Funktion gibt den Wunsch-URL zurück. Im Backend wird
sie nur im Content-Kontext eines Artikels (edit, metainfo, functions)
aufgerufen und liefert für dessen Anzeige den Wert der Variablen
<code>$_SERVER[\'REQUEST_URI\']</code>. Im Frontend wird sie nur
innerhalb der Funktion <code>rex_getUrl($article_id,$clang_id)</code>
aufgerufen und liefert (z. B. in Templates oder Modulen) den URL
eines Artikels.</div>
<br/>
<div style="font-weight:bold;">Manipulation des Frontend-Outputs</div>
<div style="padding-left:20px;">Sie erfolgt durch eine Erweiterung
des <code>Extension Point FE_OUTPUT</code>. Die am Extension Point
aufgerufene Funktion zeigt den aktuellen Artikel im Frontend an.
Letzterer ist gemäß RewriteRule zunächst der Site-Startartikel. Am
Extension Point werden hier stattdessen Inhalt und Sprachversion des
Artikels ermittelt und dargestellt, der dem angezeigten Link entspricht.
Auch die Ergebnisse der Funktionen <tt>rex_article::getCurrentId()</tt>
und <tt>rex_clang::getCurrentId()</tt> werden entsprechend korrigiert.
</div>
<br/>
<div style="font-weight:bold;">Ausblick auf komplexere Wunsch-URLs</div>
<div style="padding-left:20px;">Der hier beschriebene Rahmen kann
beibehalten werden. Die folgenden Aufgaben sind aber anders als hier
zu lösen.
<ul style="padding-left:20px;">
    <li>Für die Konstruktion des Wunsch-URL aus Artikel-Id und
        Sprach-Id im Backend bietet sich ein Rückgriff auf den
        <tt>path</tt>-Parameter des Artikels sowie auf den
        Artikel-Cache an.</li>
    <li>Zu einem Link auf eine Seite im Frontend ist der zugehörige
        Artikel samt Sprachversion zu ermitteln. Das Ergebnis muss
        eindeutig und der Ermittlungsaufwand möglichst gering sein.
        Wird der URL z. B. als zusätzlicher Artikelparameter (Meta
        Info) mitgeführt, liefert ein SQL-Select auf die Tabelle
        <tt>rex_article</tt> den Artikelinhalt. Die Sprachversion
        kann im URL, aber auch z. B. in einer Session-Variablen
        mitgeführt werden.</li>
</ul>
</div>
';
echo utf8_encode($string);
?>
