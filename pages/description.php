<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Juni 2019
 */
#
$string='
<div><b>Setzen eines Wunsch-URLs</b></div>
<div style="padding-left:20px;">Ein URL hat in Redaxo die Standardform
<code>index.php?article_id=ID&amp;clang=CID</code> mit Verweis auf
die Artikel-Id und die Sprach-Id. In der Regel soll stattdessen
jeder Artikel einen &quot;Wunsch-URL&quot; erhalten, der Hinweise
gibt auf Artikelinhalt, Themenkategorie, Site-Struktur o. Ä.
Zur Realisierung wird eine Funktion definiert, die den gewünschten
URL am <code>Extension Point URL_REWRITE</code> zurück gibt. Im
Backend wird diese Funktion nur im Content-Kontext eines Artikels
(edit, metainfo, functions) aufgerufen, im Frontend nur innerhalb
der Funktion <code>rex_getUrl($article_id,$clang_id)</code>.
Letztere liefert dem Redakteur (z. B. in Templates oder Modulen)
den URL eines Artikels und die Anzeige im Browser-Adressfeld.</div>
<br/>
<div><b>Rewrite-Mechanismus</b></div>
<div style="padding-left:20px;">Ein Link auf einen Artikel wird
durch eine Umleitungsregel
<div style="padding-left:20px;">
<tt>RewriteRule ^(.*)$ index.php?%{QUERY_STRING} [L]</tt>
&nbsp; &nbsp; &nbsp; (Datei <tt>.htaccess</tt>)</div>
an das Redaxo CMS übergeben und weist zunächst auf den
Site-Startartikel. Damit stattdessen der gewünschte Artikel
angezeigt wird, muss die aktuelle Artikel-Id
<code>rex_article::getCurrentId()</code> mit der Id des Artikels
überschrieben werden. Bei mehrsprachigen Installationen muss
auch die aktuelle Sprach-Id <code>rex_clang::getCurrentId()</code>
durch die Sprach-Id des Artikels ersetzt werden. Artikel-Id
und Sprach-Id sind aus dem URL des anzuzeigenden Artikels, d. h.
aus der Variablen <code>$_SERVER[\'REQUEST_URI\']</code>, zu
ermitteln.</div>
<br/>
<div><b>Ausblick auf reale Wunsch-URLs</b></div>
<div style="padding-left:20px;">Im Allgemeinen sind Artikel-Id
und Sprach-Id nicht so einfach wie hier zu ermitteln. Aber der
beschriebene Rahmen kann generell beibehalten werden.
Zu beachten ist:</div>
<ul>
    <li>Zu einem Link auf eine Seite im Frontend muss der
        zugehörige Artikel samt Sprachversion eindeutig zu
        ermitteln sein.</li>
    <li>Um den Aufwand für die Ermittlung des Artikels und
        damit die Belastung des Servers möglichst gering zu
        halten, kann der URL z. B. als zusätzlicher
        Artikelparameter (Meta Info) mitgeführt werden. Der
        Aufwand würde dadurch in Teilen auf die Arbeit des
        Redakteurs im Backend verlagert.</li>
    <li>Für die Konstruktion des Wunsch-URL bietet sich ein
        Rückgriff auf den <tt>path</tt>-Parameter des Artikels
        an.</li>
    <li>Die Kennzeichnung der Sprachversion im Frontend kann
        im URL mitgeführt werden, alternativ aber auch z. B.
        in einer Session-Variablen.</li>
</ul>
';
echo $string;
?>
