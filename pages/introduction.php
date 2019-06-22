<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Juni 2019
 */
$intro=file_get_contents(__DIR__.'/../README.md');
echo substr($intro,strlen($this->getPackageId())+2);
?>
