<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use \Auth;
use App\Kinmu_komoku;
use App\Kinmu_toroku;

class EmploymentsController extends Controller
{
    /* --------------------------------------------- *
     * --------------------------------------------- */
    public function viewKanniKinmuInput(){
        
        // 初期化
        $data = [];
        
        // 認証済のとき
        if (Auth::check()){
            
            // その日の日付の勤務登録、簡易勤務登録-出勤、簡易勤務登録-退勤情報を取得する
            $ymd = Carbon::today()->format('Y-m-d');
            // 簡易勤務登録-出勤
            // 済のときはtrue
            // checkInsertKinmuTorokusTable($ymd)はkinmu_torokus()->where('ymd', $ymd)->exists()だからうまくまとめたい
            if (Auth::user()->checkInsertKinmuTorokusTable($ymd)){
                // 済のときはtrue
                $kanni_kinmu_start = Auth::user()->kinmu_torokus()->where('ymd', $ymd)->get()[0]->pivot->checkInsertKanniKinmuTorokuStartsTable();
            }
            else {
                // まだ
                $kanni_kinmu_start = false;
            }
            
            // // 簡易勤務登録-退勤
            // // 済のときはtrue
            // // checkInsertKinmuTorokusTable($ymd)はkinmu_torokus()->where('ymd', $ymd)->exists()だからうまくまとめたい
            // if (Auth::user()->checkInsertKinmuTorokusTable($ymd)){
            //     // 済のときはtrue
            //     $kanni_kinmu_end = Auth::user()->kinmu_torokus()->where('ymd', $ymd)->get()[0]->pivot->checkInsertKanniKinmuTorokuStartsTable();
            // }
            // else {
            //     // まだ
            //     $kanni_kinmu_end = false;
            // }
            
            
            $data = [
                // 勤務項目から通常勤務を取得
                'kinmu_komoku_id' => Kinmu_komoku::findOrFail(1)->id,
                'kanni_kinmu_start' => $kanni_kinmu_start,
                // 'kanni_kinmu_end' => $kanni_kinmu_end,
            ];
            
        }
            
        // 詳細勤務入力ページを表示する
        return view('employments.kanni_kinmu', $data);
        
    }
    
    /* --------------------------------------------- *
     * kanni_kinmu_toroku_startsテーブルにinsert
     * --------------------------------------------- */
    public function storeKanniKinmuStart(Request $request){
        
        if ($request->ymd == '' || is_null($request->ymd)){
            // 日付の指定がないときは本日日付
            $request->ymd = Carbon::today()->format('Y-m-d');
        }
        $time = Carbon::now()->format('H:i:s');
        
        // kinmu_torokusテーブルにinsert
        // →insert失敗時はすでに勤務登録済みのとき
        // すでに勤務登録済のとき=詳細勤務入力済または簡易勤務登録-出勤済または簡易勤務登録-退勤済のとき
        $rs = $request->user()->insertKinmuTorokusTable($request->kinmu_komoku_id, $request->ymd);
        if ($rs){
            // kanni_kinmu_toroku_startsにinsert
            $kinmu_toroku_id = $request->user()->getKinmuToroku($request->ymd)->id;
            $kinmu_toroku = new Kinmu_toroku;
            $kinmu_toroku->insertKanniKinmuTorokuStartsTable($kinmu_toroku_id, $time);
        }
        
        // 元の画面に戻る
        return back();
    }
    
    // /* --------------------------------------------- *
    //  * kanni_kinmu_toroku_endsテーブルにinsert
    //  * --------------------------------------------- */
    // public function storeKanniKinmuEnd(Request $request){
        
    //     if ($request->ymd == '' || is_null($request->ymd)){
    //         // 日付の指定がないときは本日日付
    //         $request->ymd = Carbon::today()->format('Y-m-d');
    //     }
    //     $time = Carbon::now()->format('H:i:s');
        
    //     // kinmu_torokusテーブルにinsert
    //     // →insert失敗時はすでに勤務登録済みのとき
    //     $rs = $request->user()->insertKinmuTorokusTable($request->kinmu_komoku_id, $request->ymd);
    //     // 勤務登録できたとき
    //     if ($rs){
    //         // kanni_kinmu_toroku_startsにinsert
    //         $kinmu_toroku_id = $request->user()->getKinmuToroku($request->ymd)->id;
    //         $kinmu_toroku = new Kinmu_toroku;
    //         $kinmu_toroku->insertKanniKinmuTorokuStartsTable($kinmu_toroku_id, $time);
    //     }
    //     // 勤務登録できなかったとき
    //     else {
    //         // 簡易勤務登録-出勤済かつ簡易勤務登録-退勤がまだのとき
    //         if (){
                
    //         }
    //     }
        
    //     // 元の画面に戻る
    //     return back();
    // }
}
