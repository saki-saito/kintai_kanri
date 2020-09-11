<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use \Auth;
use App\Kinmu_komoku;

class EmploymentsController extends Controller
{
    /* --------------------------------------------- *
     * --------------------------------------------- */
    public function viewKanniKinmuInput(){
        
        // 初期化
        $data = [];
        
        // 認証済のとき
        if (Auth::check()){
            
            // 勤務項目から通常勤務を取得
            $data = [
                'kinmu_komoku' => Kinmu_komoku::findOrFail(1),
            ];
        
        }
        
        // 詳細勤務入力ページを表示する
        return view('employments.kanni_kinmu', $data);
    }
    
    /* --------------------------------------------- *
     * kanni_kinmu_torokusテーブルにinsert
     * --------------------------------------------- */
    public function storeKanniKinmuStart(Request $request){
        
        if ($request->ymd == '' || is_null($request->ymd)){
            // 日付の指定がないときは本日日付
            $request->ymd = Carbon::today()->format('Y-m-d');
        }
        $time = Carbon::now()->format('H:i:s');
        
        // kinmu_torokusテーブルにinsert
        // →insert失敗時はすでに勤務登録済みのとき
        $rs = $request->user()->insertKinmuTorokusTable($request->kinmu_komoku_id, $request->ymd);
        if ($rs){
            // kanni_kinmu_toroku_startsにinsert
            $kinmu_toroku_id = $request->user()->getKinmuToroku($request->ymd)->kinmu_komoku_id;
            $request->user()->insertKanniKinmuTorokuStartsTable($kinmu_toroku_id, $time);
        }
        
        // 元の画面に戻る
        return back();
    }
}
