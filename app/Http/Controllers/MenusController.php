<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenusController extends Controller
{
    /* --------------------------------------------- *
     * --------------------------------------------- */
    public function index(){
        
        // トップページを表示する
        return view('menus.index');
    }
}
