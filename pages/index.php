<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version April 2020
 */
echo rex_view::title(rex_i18n::msg('url_simple_rewrite'));
rex_be_controller::includeCurrentPageSubPath();
?>
