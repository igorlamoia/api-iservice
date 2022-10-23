<?php

namespace Providers;

class Data
{
    static function exempleUtil($data)
    {
        if (strlen($data) == 10) {
            $vtdt = explode('/', $data);
            $datafinal = $vtdt[2] . '-' . $vtdt[1] . '-' . $vtdt[0];
            return $datafinal;
        } else {
            return "";
        }
    }
}
