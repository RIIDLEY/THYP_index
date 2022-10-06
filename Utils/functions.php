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