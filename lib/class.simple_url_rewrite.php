<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Juni 2019
 */
class url_rewrite {
#
public static function rewrite($ep) {
   #   Rueckgabe eines URLs im konfigurierten Format (Custom URL mit fuehrendem '/'):
   #   - im Backend-Fall wird der URL im Content-Kontext des Artikels (edit,
   #     metainfo, functions) bestimmt. Er erscheint im Browser-Adressfeld.
   #   - im Frontend-Fall liefert der URL den Rueckgabewert der function rex_getUrl().
   #   $ep                  Objekt vom Typ rex_extension_point
   #   benutzte functions:
   #      self::set_url($article)
   #      self::is_normurl()
   #      self::get_url($article)
   #
   $par=$ep->getParams();
   $art_id  =$par['id'];     // Artikel-Id, alternativ: $ep->getParam('id')
   $clang_id=$par['clang'];  // Sprach-Id,  alternativ: $ep->getParam('clang')
   #
   #   Aus Artikel-Id und Sprach-Id wird das Artikel-Objekt gewonnen.
   $article=rex_article::get($art_id,$clang_id);
   if($article==NULL) $article=rex_article::getNotfoundArticle($clang_id);
   #
   if(rex::isBackend()):
     # --- Backend: Definieren und ggf. Speichern des Wunsch-URLs
     $url='/'.self::set_url($article);
     else:
     # --- Frontend
     if(self::is_normurl()):
       #   Redaxo-Standard-URL
       if(count(rex_clang::getAll())>1):
         $str='&clang='.$article->getClang();
         else:
         $str='';
         endif;
       $url='/index.php?article_id='.$art_id.$str;
       else:
       #   konfigurierter URL
       $url='/'.self::get_url($article);
       endif;
     endif;
   return $url;
   }
public static function is_normurl() {
   #   Hat die aktuelle Seite einen Redaxo-Standard-URL ?
   #
   $arr=explode('?',substr($_SERVER['REQUEST_URI'],1));
   $url=$arr[0];
   $indphp=substr(rex_url::frontendController(),2);
   $urlend=substr($url,intval(strlen($url)-strlen($indphp)));
   $aid=rex_get('article_id');
   if($urlend==$indphp and !empty($aid)) return TRUE;
   return FALSE;
   }
public static function set_url($article) {
   #   Rueckgabe des URLs eines Artikels ohne fuehrenden '/' im Backend-Fall. Alle
   #   dafuer benoetigten Artikel-Parameter werden aus dem Artikel-Objekt genommen.
   #   $article           Artikel-Objekt
   #   [Der URL koennte hier als Artikel-Parameter in die Tabelle
   #   rex_article eingetragen werden.]
   #
   $art_id  =$article->getId();
   $clang_id=$article->getClang();
   $name    =$article->getName();
   $cl_code =rex_clang::get($clang_id)->getCode();
   return $art_id.'-'.$cl_code.'-'.$name.'.html';
   }
public static function get_url($article) {
   #   Rueckgabe des URLs eines Artikels ohne fuehrenden '/' im Frontend-Fall. Alle
   #   dafuer benoetigten Artikel-Parameter werden aus dem Artikel-Objekt genommen.
   #   $article           Artikel-Objekt
   #   [Der URL koennte hier als Artikel-Parameter aus der Tabelle
   #   rex_article ausgelesen werden.]
   #
   $art_id  =$article->getId();
   $clang_id=$article->getClang();
   $name    =$article->getName();
   $cl_code =rex_clang::get($clang_id)->getCode();
   return $art_id.'-'.$cl_code.'-'.$name.'.html';
   }
public static function set_current() {
   #   Setzen der Id des anzuzeigenden Artikels und der zugehoerigen Sprache.
   #   Die Daten werden aus $_SERVER['REQUEST_URI'] ermittelt.
   #   Wird kein zugehoeriger Artikel gefunden oder ist er offline, werden
   #   stattdessen die Daten des NotFound-Artikels gesetzt.
   #   benutzte functions:
   #      self::is_normurl()
   #      self::get_current_clangid($req_url)
   #      self::get_current_artid($req_url,$clang_id)
   #
   if(!self::is_normurl()):
     # --- $_SERVER['REQUEST_URI'] liefert Custom URL
     $arr=explode('?',substr($_SERVER['REQUEST_URI'],1));
     $req_url=$arr[0];
     $clang_id=self::get_current_clangid($req_url);
     $art_id  =self::get_current_artid($req_url,$clang_id);
     else:
     # --- $_SERVER['REQUEST_URI'] liefert Redaxo-Standard-URL
     $clang_id=intval(rex_get('clang'));
     if(!rex_clang::exists($clang_id)) $clang_id=rex_clang::getCurrentId();
     $art_id=intval(rex_get('article_id'));
     $article=rex_article::get($art_id,$clang_id);
     if($article==NULL):
       $art_id=rex_article::getNotfoundArticleId();
       else:
       if(!$article->isOnline()) $art_id=rex_article::getNotfoundArticleId();
       endif;
     endif;
   #
   # --- rex_article::getCurrentId() und rex_clang::getCurrentId() setzen
   rex_addon::get('structure')->setProperty('article_id',$art_id);
   rex_clang::setCurrentId($clang_id);
   }
public static function get_current_clangid($req_url) {
   #   Rueckgabe der Sprach-Id zum aufgerufenen URL ($_SERVER['REQUEST_URI']).
   #   Falls keine entsprechende Sprach-Id vorhanden ist, wird 1 zurueck gegeben.
   #   $req_url           aufgerufener URL ohne fuehrenden '/' und ohne Parameter
   #
   $brr=explode('-',$req_url);
   $clang_id=0;
   if(!empty($brr[1]))
     foreach(rex_clang::getAll() as $key=>$lang):
            $id=$lang->getId();
            if(rex_clang::get($id)->getCode()==$brr[1]):
              $clang_id=$id;
              break;
              endif;
            endforeach;
   if($clang_id<=0) return 1;
   return $clang_id;
   }
public static function get_current_artid($req_url,$clang_id) {
   #   Rueckgabe der Artikel-Id zum aufgerufenen URL ($_SERVER['REQUEST_URI']).
   #   Falls der Artikel offline ist oder nicht gefunden wird, wird stattdessen
   #   die Artikel-Id des Notfound-Artikels zurueck gegeben.
   #   $req_url           aufgerufener URL ohne fuehrenden '/' und ohne Parameter
   #   $clang_id          Sprach-Id des Artikels
   #
   $brr=explode('-',$req_url);
   $art_id=0;
   if(!empty($brr[0])) $art_id=$brr[0];
   $article=rex_article::get($art_id,$clang_id);
   if($article==NULL) return rex_article::getNotfoundArticleId();
   #
   $rest=substr($req_url,strlen($brr[0])+strlen($brr[1])+2);
   $brr=explode('.',$rest);
   if($article->getName()!=urldecode($brr[0])) return rex_article::getNotfoundArticleId();
   #
   if(!$article->isOnline()) return rex_article::getNotfoundArticleId();
   return $art_id;
   }
}
