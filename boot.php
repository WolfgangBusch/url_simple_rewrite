<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Oktober 2017
 */
require_once __DIR__.'/lib/class.url_simple_rewrite.php';
require_once __DIR__.'/lib/class.fe_simple_output.php';
rex_extension::register('URL_REWRITE',array('url_rewrite','rewrite'));
rex_extension::register('FE_OUTPUT',  array('fe_output','output'));
?>
