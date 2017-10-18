<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Oktober 2017
 */
class url_rewrite {
#
function rewrite($params) {
   #   $params            URL_REWRITE-Parameter (Objekt)
   #   Es muss ein Wunsch-URL zurueck gegeben werden (mit fuehrendem "/"):
   #   - im Backend-Fall  wird der URL jeweils im Content-Kontext des Artikels
   #                      (edit, metainfo, functions) bestimmt.
   #                      Er erscheint im Browser-Adressfeld.
   #   - im Frontend-Fall wird der URL im Falle des Aufrufs von rex_getUrl()
   #                      bestimmt. Er ist der Rueckgabewerte von rex_getUrl(..).
   #   aufgerufene functions:
   #      self::set_url($article)
   #      self::get_url($article)
   #
   $par=$params->getParams();
   $art_id  =$par[id];
   $clang_id=$par[clang];
   $arrpar  =$par[params];
   $separ   =$par[separator];
   #
   #   Aus Artikel-Id und Sprach-Id wird das Artikel-Objekt gewonnen.
   $article=rex_article::get($art_id,$clang_id);
   if($article==NULL) $article=rex_article::getNotfoundArticle();
   #
   if(rex::isBackend()):
     # --- Backend: Definieren und ggf. Speichern des Wunsch-URLs
     $url="/".self::set_url($article);
     else:
     # --- Frontend
     $arr=explode("?",substr($_SERVER["REQUEST_URI"],1));
     if($arr[0]=="index.php" and
        (substr($arr[1],0,11)=="article_id=" or strpos($arr[1],"article_id=")>0)):
       #   Normalform-URL
       $art_id=$article->getId();
       $arr=rex_clang::getAll();
       if(count(rex_clang::getAll())>1):
         $str="&clang=".$clang_id=$article->getValue("clang_id");
         else:
         $str="";
         endif;
       $url="/index.php?article_id=".$art_id.$str;
       else:
       #   Wunsch-URL
       $url="/".self::get_url($article);
       endif;
     endif;
   #
   # --- Die URL-Parameter werden angehaengt.
   $parstr=rex_string::buildQuery($arrpar,$separ);
   if(!empty($parstr)):
     $sep="?";
     if(strpos($url,$sep)>0) $sep="&";
     $url=$url.$sep.$parstr;
     endif;
   return $url;
   }
function set_url($article) {
   #   Rueckgabe des Wunsch-URLs eines Artikels ohne fuehrenden "/"
   #   im Backend-Fall. Alle dafuer benoetigten Artikel-Parameter
   #   werden aus dem Artikel-Objekt genommen.
   #   $article           Artikel-Objekt
   #   Der URL koennte hier als Artikel-Parameter in der Tabelle
   #   rex_article abgelegt werden.
   #
   $art_id  =$article->getId();
   $clang_id=$article->getValue("clang_id");
   $name    =$article->getValue("name");
   $clang   =rex_clang::get($clang_id)->getCode();
   return $art_id."-".$clang."-".$name.".html";
   }
function get_url($article) {
   #   Rueckgabe des Wunsch-URLs eines Artikels ohne fuehrenden "/"
   #   im Frontend-Fall. Alle dafuer benoetigten Artikel-Parameter
   #   werden aus dem Artikel-Objekt genommen.
   #   $article           Artikel-Objekt
   #   Der URL koennte hier als Artikel-Parameter aus der Tabelle
   #   rex_article ausgelesen werden.
   #
   $art_id  =$article->getId();
   $clang_id=$article->getValue("clang_id");
   $name    =$article->getValue("name");
   $clang   =rex_clang::get($clang_id)->getCode();
   return $art_id."-".$clang."-".$name.".html";
   }
}
