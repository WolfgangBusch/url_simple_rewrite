# url_simple_rewrite
<h4>Version 1.2.4</h4>
<ul>
    <li>An etlichen Stellen werden jetzt anstelle der Methode getValue("value")
        die Redaxo 5-spezifischen Methoden getClang(), getTemplateId(), getName(),
        IsOnline() eingesetzt.</li>
</ul>
<h4>Version 1.2.3</h4>
<ul>
    <li>Neue Behandlung der Normalform-URLs</li>
</ul>
<h4>Version 1.2.2</h4>
<ul>
    <li>�berarbeitung der Beschreibung</li>
</ul>
<h4>Version 1.2.1</h4>
<ul>
    <li>F�r den Normalform-URL wird jetzt der Redirect auf den NotFound-Artikel sauberer
        durchgef�hrt.</li>
    <li>Au�erdem ist der Quellcode etwas gestrafft.</li>
</ul>
<h4>Version 1.2.0</h4>
<ul>
    <li>Die Werte der Funktionen rex_article::getCurrentId() und rex_clang::getCurrentId
        werden jetzt entsprechend dem angezeigten Artikel angepasst.</li>
</ul>
<h4>Version 1.1.0</h4>
<ul>
    <li>Ersatz f�r die nicht mehr "funktionierenden" Funktionen rex_article::getCurrentId()
        und rex_clang::getCurrentId()</li>
    <li>Verlegung der function get_article() von der class url_rewrite in die
        class fe_output</li>
    <li>Offline-Artikel werden nicht mehr angezeigt; stattdessen der Notfound-Artikel.</li>
</ul>