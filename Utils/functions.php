<?php


/**
 * Fonction échappant les caractères html dans $message
 * @param  string $message chaîne à échapper
 * @return string          chaîne échappée
 */
function e($message)
{
    return htmlspecialchars($message, ENT_QUOTES);
}

function stripAccents($str) {
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function getSizeTags($minOccu,$maxOccu,$OccuCourant){
    $rectif = 1;
    if ($maxOccu-$minOccu<=0){
        $a = ((50-15)/1);
    }else{
        $a = ((50-15)/($maxOccu-$minOccu));
    }
    $b = 15-$a;
    if ($minOccu>=4){
        $rectif = 2;
    }
    return ($a*$OccuCourant+$b)/$rectif;
}


function get_title($url){
    $str = file_get_contents_utf8($url);
    if(strlen($str)>0){
      $str = trim(preg_replace('/\s+/', ' ', $str));
      preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title);
      return $title[1];
    }
  }
  
  function get_description($url){#DO TO, if pas de description, prend les 30 premiers caracteres
    $meta = get_meta_tags($url);
    if(!empty($meta['description'])){
        return $meta['description'];
    }else{
        return substr(stripAccents(file_get_contents_utf8($url)), 0, 50);
    }
  }

  function get_keywords($url){
    $meta = get_meta_tags($url);
    if(!empty($meta['keywords'])){
        return $meta['keywords'];
    }else{
        return null;
    }
  }

  function file_get_contents_utf8($fn) {
    $content = file_get_contents($fn);
     return mb_convert_encoding($content, 'UTF-8',
         mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
}

 function getRandomColor(){
    $background_colors = array('#88e904', 'red', '#4bc5c5', 'pink','orange','yellow','green','blue','grey','brown');
    return $background_colors[array_rand($background_colors)];
 }