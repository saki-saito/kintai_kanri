<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

class MenusController extends Controller
{
    /* --------------------------------------------- *
     * --------------------------------------------- */
    public function showTopMenu(){
        // トップメニューページを表示する
        return view('menus.top');
    }
    
    /* --------------------------------------------- *
     * --------------------------------------------- */
    public function showEmploymentMenu(){
        
        // 今月を取得
        $ym = Carbon::today()->format('Y-m');
        
        // 就業メニューページを表示する
        return view('menus.employment', ['ym' => $ym]);
    }

    
    
}
