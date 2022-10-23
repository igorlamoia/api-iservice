<?php

namespace Providers;

class Str{
    static function removeMascaras($string){

        $string = str_replace('.', '', $string);
        $string = str_replace('/', '', $string);
        $string = str_replace('-', '', $string);
        $string = str_replace('(', '', $string);
        $string = str_replace(')', '', $string);
        $string = str_replace('R$', '', $string);
        $string = str_replace(' ', '', $string);

        return $string;
     }

    static function moedaBD($string){

        $string = str_replace('R$', '', $string);
        $string = str_replace('.', '', $string);
        $string = str_replace(',', '.', $string);
        return $string;
    }




    static function arrumarPalavra($palavra){

        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/",
        "/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/", "/(ç|Ç)/"),
        explode(" ","a A e E i I o O u U n N c C"), $palavra);
    }














}
?>