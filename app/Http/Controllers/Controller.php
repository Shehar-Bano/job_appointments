<?php

namespace App\Http\Controllers;

abstract class Controller
{
    const DEFAULT_LIMIT=10;

    public function getValue($value){
        $value = (int) $value;
        if($value == null || $value<=0 || !is_int($value)){
        return self::DEFAULT_LIMIT;
        }
        else{
            return $value;
        }

    }

}
