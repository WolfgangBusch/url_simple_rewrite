<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version April 2020
 */
#
echo '
<ul>
    <li>Dieses AddOn ist eine Erweiterung des Standard-Rewriters und
        nutzt den <code>Extension Point URL_REWRITE</code>.</li>
    <li>Es dient im Wesentlichen nur als exemplarische Einführung
        in die Funktionsweise des Rewriters. Der Artikel-URL wird
        hier in einer besonders einfachen Form aus Artikel-Id,
        Sprach-Code und Artikelname gebildet:
        <code>ID-CODE-NAME.html</code>. Seiten können aber auch
        über den Redaxo-Standard-URL aufgerufen werden.</li>
    <li>Es sind keine besonderen RewriteRules erforderlich.</li>
</ul>';
?>