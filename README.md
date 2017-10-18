# url_simple_rewrite
<h3>Einfaches URL-Rewrite für Redaxo</h3>
<ul>
    <li>Dieses AddOn ist eine Erweiterung des Standard-Rewriters und
        nutzt den <b>Extension Point</b> <tt>URL_REWRITE</tt>. Es soll im
        Wesentlichen nur als exemplarische Einführung in die Funktionsweise
        des Rewriters und als Gerüst für die Entwicklung komplexerer
        Rewriter dienen.</li>
    <li>Zur Manipulation des Frontend-Output wird eine Erweiterung
        des <b>Extension Point</b> <tt>FE_OUTPUT</tt> genutzt.</li>
    <li>Der Artikel-URL wird automatisch generiert in der exemplarischen
        Form <tt>article_id-clang-name.html</tt>.</li>
</ul>

<div>Ein URL hat in Redaxo die Normalform
<tt>index.php?article_id=ID&amp;clang=CID</tt>
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
<b>Extension Point</b> <tt>URL_REWRITE</tt> erforderlich. Die am Extension
Point aufgerufene Funktion gibt den Wunsch-URL zurück. Im Backend wird
sie nur im Content-Kontext eines Artikels (edit, metainfo, functions)
aufgerufen und liefert für dessen Anzeige den Wert der Variablen
<tt>$_SERVER[\'REQUEST_URI\']</tt>. Im Frontend wird sie nur
innerhalb der Funktion <tt>rex_getUrl($article_id,$clang_id)</tt>
aufgerufen und liefert (z. B. in Templates oder Modulen) den URL
eines Artikels.</div>
<br/>
<div style="font-weight:bold;">Manipulation des Frontend-Outputs</div>
<div style="padding-left:20px;">Sie erfolgt durch eine Erweiterung
des <b>Extension Point</b> <tt>FE_OUTPUT</tt>. Die am Extension Point
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
