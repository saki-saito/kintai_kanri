<?php

namespace App\Lib;

use Carbon\Carbon;

class My_func
{
    
    
    public static function fromHisToHi($his){
        
        $date = new Carbon($his);
        return $date->format('H:i');
        
    }
}