<?php

namespace App\Helpers;

class Whatsapp
{
    public static function make($params)
    {
        return substr($params, 0, 1) === '0' ? '62' . substr($params, 1) : (substr($params, 0, 1) === '8' ? '62' . $params : $params);
    }
}
