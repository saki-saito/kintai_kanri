<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // 就業メニューページを表示する
        return view('menus.employment');
    }

    
    
}
