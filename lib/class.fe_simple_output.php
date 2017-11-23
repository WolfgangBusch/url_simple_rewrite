<?php
/**
 * URL-Rewrite Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version November 2017
 */
#
class fe_output {
#
function output() {
   #   Frontend-Ausgabe des Artikels.
   #   Die Extension gibt den tatsaechlich gewuenschten Artikel aus.
   #   Wird dieser nicht gefunden oder ist offline, wird stattdessen
   #   der NotFound-Artikel ausgegeben.
   #   aufgerufene functions:
   #      param_normurl()
   #      article_from_normurl($param)
   #      self::get_article($req_url)
   #
   # --- anzuzeigender Artikel
   #   Aus $_SERVER["REQUEST_URI"] wird der auszugebende Artikel
   #   ermittelt. Ggf. alternativ der Notfound-Artikel.
   $param=param_normurl();
   if(count($param)>=2):
     # --- aus der Normalform-URL
     $article=article_from_normurl($param);
     else:
     # --- aus dem Wunsch-URL
     $article=self::get_article($param[url]);
     endif;
   $art_id  =$article->getId();
   $clang_id=$article->getClang();
   $temp_id=$article->getTemplateId();
   #
   # --- neuer Artikel-Inhalt mit den Parametern des gefundenen Artikels
   $content=new rex_article_content;
   $content->setArticleId($art_id);
   $content->setTemplateId($temp_id);
   $content->setClang($clang_id);
   #
   # --- aktuelle Artikel-Id uns Sprach-Id setzen
   #     (Werte von rex_article::getCurrentId(), rex_clang::getCurrentId())
   rex_addon::get('structure')->setProperty("article_id",$art_id);
   rex_clang::setCurrentId($clang_id);
   #
   # --- neuen Artikel-Inhalt ausgeben
   rex_response::sendPage($content->getArticleTemplate());
   }
function get_article($req_url) {
   #   Rueckgabe des Artikel-Objekts zum aufgerufenen URL.
   #   Falls der Artikel offline ist oder nicht gefunden wird,
   #   wird stattdessen der Notfound-Artikel zurueck gegeben.
   #   $req_url           aufgerufener relativer URL
   #
   $brr=explode("-",$req_url);
   $art_id=intval($brr[0]);
   foreach(rex_clang::getAll() as $key=>$lang):
          $id=$lang->getId();
          if(rex_clang::get($id)->getCode()==$brr[1]):
            $clang_id=$id;
            break;
            endif;
          endforeach;
   $article=rex_article::get($art_id,$clang_id);
   #
   # --- Artikel nicht gefunden oder Offline
   if($article==NULL) $article=rex_article::getNotfoundArticle();
   $brr=explode(".",$brr[2]);
   if($article->getName()!=$brr[0]) $article=rex_article::getNotfoundArticle();
   if(!$article->isOnline()) $article=rex_article::getNotfoundArticle();
   return $article;
   }
}
