# url_path_rewrite
<h3>path-basiertes URL-Rewrite für Redaxo 5</h3>
<ul>
    <li>Dieses AddOn ist eine Erweiterung des Standard-Rewriters und nutzt
        den <code>Extension Point URL_REWRITE</code>.</li>
    <li>Der Artikel-URL wird automatisch generiert in der Form
        <code>category1/category2/.../categoryN/article</code>
        und bildet so den Kategorien-Pfad eines Artikels ab.
        Die zugehörigen Bezeichnungen werden als zusätzliche Meta Infos
        eingerichtet. Daher sollte das AddOn <code>metainfo</code>
        installiert sein.</li>
    <li>Die Sprache einer Seite kann wahlweise im URL oder durch eine
        Session-Variable gekennzeichnet werden.</li>
    <li>URL und Sprachkennzeichnung identifizieren einen Artikel im Frontend
        eindeutig. Eine Erweiterung des <code>Extension Point FE_OUTPUT</code>
        ermöglicht seine Ausgabe ohne besondere RewriteRules.</li>
    <li>Seiten können auch über den Redaxo-Standard-URL
        <code>index.php?article_id=ID&clang=CID</code> aufgerufen werden.</li>
</ul>
<div><b>Elemente der URL-Darstellung:</b></div>
<div>Für die Darstellung eines URLs werden bei der Installation des
AddOns die folgenden Meta Infos angelegt (als Zeilen in der Tabelle
<code>rex_metainfo_field</code> und als Spalten in der Tabelle
<code>rex_article</code>). Sie werden bei der De-Installation nicht wieder
entfernt.
<ul>
    <li><code>cat_dirname</code> : &nbsp; &quot;Verzeichnisname&quot; für
        jede Kategorie, Default: Kategoriename (<code>catname</code>)</li>
    <li><code>art_basename</code> : &nbsp; &quot;Dateiname&quot; für jeden
        Artikel, Default: Artikelname mit Namenserweiterung
        (<code>name.html</code>),<br/>
        für Kategorie-Startartikel wird der Artikelname durch &quot;index&quot;
        ersetzt (&quot;Dateiname&quot;: <code>index.html</code>)</li>
    <li><code>art_custom_url</code> : &nbsp; aus den obigen Daten
        generierter Artikel-URL (Custom URL, ohne führenden &quot;/&quot;),
        ablesbar (<tt>readonly</tt>) in den Metadaten des Artikels,
        den Wert (mit führendem &quot;/&quot;) liefert die Standardfunktion
        <code>rex_getUrl(article_id), er ist sprach-unabhängig</code></li>
</ul>
Erlaubte Zeichen für die Meta Infos sind: Buchstaben, Ziffern, Punkt(.),
Minuszeichen(-), Unterstrich(_), nicht erlaubt sind Umlaute oder Leerzeichen.
Startartikelname und Namenserweiterung können auch anders konfiguriert
werden.
</div>
<br/>
<div><b>Kennzeichnung der Sprache:</b></div>
<div>Die Kennzeichnung der Sprache erfolgt mittels der definierten
Sprachcodes, wahlweise durch eine
<ul>
    <li>Erweiterung des URL um den Sprachcode in der Form
        <code>en/cat_dirname1/...</code> oder</li>
    <li>Erweiterung des URL um einen Parameter in der Form
        <code>.../art_basename?language=en</code> oder</li>
    <li>Session-Variable <code>$_SESSION['language']='en'</code>,
        ein Sprachwechsel erfolgt hier mittels URL-Parameter im
        entsprechenden Link (vergl. vorige Zeile).</li>
</ul>
Die Art der Kennzeichnung ist konfigurierbar. Bei der Standardsprache
und damit auch bei einsprachigen Installationen entfällt sie ganz.</div>