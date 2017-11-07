<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version November 2017
 */
function param_normurl() {
   #   Rueckgabe des URL und der URL-Parameter bei einem URL in Normalform
   #   in Form eines assoziativen Arrays:
   #   $param             assoziatives Array der URL-Parameter
   #      [url]           URL ohne Parameter
   #      [article_id]    Artikel-Id
   #      [clang]         Sprach-Id
   #   Falls keine URL-Normalform vorliegt wird nur der URL ohne Parameter
   #   zurueck gegeben (Array-Count = 1).
   #
   $var0="url";
   $var1="article_id";
   $var2="clang";
   $arr=explode("?",substr($_SERVER["REQUEST_URI"],1));
   $url=$arr[0];
   $aid=rex_get($var1);
   $cid=rex_get($var2);
   if(!empty($aid)):
     if(!empty($cid)):
       $param=array($var0=>$url, $var1=>$aid, $var2=>$cid);
       else:
       $param=array($var0=>$url, $var1=>$aid);
       endif;
     else:
     $param=array($var0=>$url);
     endif;
   return $param;
   }
function article_from_normurl($param) {
   #   Rueckgabe des Artikel-Objekts zu einem URL in Normalform.
   #   Falls der Artikel nicht existiert, wird der NotFound-Artikel
   #   zurueck gegeben.
   #   $param             assoziatives Array der URL-Parameter
   #      [url]           URL ohne Parameter
   #      [article_id]    Artikel-Id
   #      [clang]         Sprach-Id
   #   Falls keine URL-Normalform vorliegt wird nur der URL ohne Parameter
   #   zurueck gegeben (Array-Count = 1)
   #
   if(count($param)>=2):
     $key=array_keys($param);
     $art_id  =$param[$key[1]];
     $clang_id=$param[$key[2]];
     $article=rex_article::get($art_id,$clang_id);
     else:
     $article=NULL;
     endif;
   if($article==NULL) $article=rex_article::getNotfoundArticle();
   return $article;
   }
?>
