<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Dezember 2017
*/
$string=
'
<ul>
    <li>Dieses AddOn ist eine Erweiterung des Standard-Rewriters und
        nutzt den <code>Extension Point URL_REWRITE</code>. Es soll im
        Wesentlichen nur als exemplarische Einführung in die Funktionsweise
        des Rewriters und als Gerüst für die Entwicklung komplexerer
        Rewriter dienen.</li>
    <li>Zur Manipulation des Frontend-Output wird eine Erweiterung
        des <code>Extension Point FE_OUTPUT</code> genutzt.</li>
    <li>Der Artikel-URL wird automatisch generiert in der exemplarischen
        Form <code>article_id-clang-name.html</code>.</li>
</ul>
';
echo utf8_encode($string);
?>
