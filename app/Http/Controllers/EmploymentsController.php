<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use \Auth;
use App\User;
use App\Kinmu_komoku;
use App\Kinmu_toroku;
use App\Kanni_kinmu_toroku_starts;
use App\Kanni_kinmu_toroku_ends;

class EmploymentsController extends Controller
{
    /* --------------------------------------------- *
     * 簡易勤務登録を表示する
     * --------------------------------------------- */
    public function viewKanniKinmuInput(){
        
        // 初期化
        $data = [];
        
        // 認証済のとき
        if (Auth::check()){
            
            // その日の日付の勤務登録、簡易勤務登録-出勤、簡易勤務登録-退勤情報を取得する
            Carbon::setLocale('ja');
            $ymd = Carbon::today();
            $ymd_fmt = $ymd->format('Y/m/d');
            $dayofweek = $ymd->isoFormat('(ddd)');
            $ymd = $ymd->format('Y-m-d');
            
            // 初期化
            $kanni_kinmu_start['check'] = false;
            $kanni_kinmu_end['check'] = false;
            
            // TODO 退勤の後に出勤を押させない制御が必要
            
            // 簡易勤務登録-出勤
            // 済のときはtrue
            // checkInsertKinmuTorokusTable($ymd)はkinmu_torokus()->where('ymd', $ymd)->exists()だからうまくまとめたい
            if (Auth::user()->checkInsertKinmuTorokusTable($ymd)){
                // 済のときはtrue
                $kanni_kinmu_start['check'] = Auth::user()->getKinmuToroku($ymd)->checkInsertKanniKinmuTorokuStartsTable();
                if ($kanni_kinmu_start['check']){
                    $kanni_kinmu_start['ymd'] = $ymd_fmt;
                    $kanni_kinmu_start['dayofweek'] = $dayofweek;
                    $kanni_kinmu_start['time'] = Auth::user()->getKinmuToroku($ymd)->kanni_kinmu_toroku_start->kanni_kinmu_start_time;
                }
            }
            
            // 簡易勤務登録-退勤
            // 済のときはtrue
            // checkInsertKinmuTorokusTable($ymd)はkinmu_torokus()->where('ymd', $ymd)->exists()だからうまくまとめたい
            if (Auth::user()->checkInsertKinmuTorokusTable($ymd)){
                // 済のときはtrue
                $kanni_kinmu_end['check'] = Auth::user()->getKinmuToroku($ymd)->checkInsertKanniKinmuTorokuEndsTable();
                if ($kanni_kinmu_end['check']){
                    $kanni_kinmu_end['ymd'] = $ymd_fmt;
                    $kanni_kinmu_end['dayofweek'] = $dayofweek;
                    $kanni_kinmu_end['time'] = Auth::user()->getKinmuToroku($ymd)->kanni_kinmu_toroku_end->kanni_kinmu_end_time;
                }
            }
            
            $data = [
                // 勤務項目から通常勤務を取得
                'kinmu_komoku' => Kinmu_komoku::findOrFail(1),
                'kanni_kinmu_start' => $kanni_kinmu_start,
                'kanni_kinmu_end' => $kanni_kinmu_end,
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
        // すでに勤務登録済のとき=詳細勤務入力済または簡易勤務登録-出勤済または簡易勤務登録-退勤済のとき
        if (!$request->user()->checkInsertKinmuTorokusTable($request->ymd)){
            $request->user()->insertKinmuTorokusTable($request->kinmu_komoku_id, $request->ymd);
        }
        
        // kanni_kinmu_toroku_startsにinsert
        if (!$request->user()->getKinmuToroku($request->ymd)->checkInsertKanniKinmuTorokuStartsTable()){
            $kinmu_toroku_id = $request->user()->getKinmuToroku($request->ymd)->id;
            $kinmu_toroku = new Kinmu_toroku;
            $kinmu_toroku->insertKanniKinmuTorokuStartsTable($kinmu_toroku_id, $time);
        }
        
        // 元の画面に戻る
        return back();
    }
    
    /* --------------------------------------------- *
     * kanni_kinmu_toroku_endsテーブルにinsert
     * --------------------------------------------- */
    public function storeKanniKinmuEnd(Request $request){
        
        if ($request->ymd == '' || is_null($request->ymd)){
            // 日付の指定がないときは本日日付
            $request->ymd = Carbon::today()->format('Y-m-d');
        }
        $time = Carbon::now()->format('H:i:s');
        
        // kinmu_torokusテーブルにinsert
        // すでに勤務登録済のとき=詳細勤務入力済または簡易勤務登録-出勤済または簡易勤務登録-退勤済のとき
        if (!$request->user()->checkInsertKinmuTorokusTable($request->ymd)){
            $request->user()->insertKinmuTorokusTable($request->kinmu_komoku_id, $request->ymd);
        }
        
        // kanni_kinmu_toroku_startsにinsert
        if (!$request->user()->getKinmuToroku($request->ymd)->checkInsertKanniKinmuTorokuEndsTable()){
            $kinmu_toroku_id = $request->user()->getKinmuToroku($request->ymd)->id;
            $kinmu_toroku = new Kinmu_toroku;
            $kinmu_toroku->insertKanniKinmuTorokuEndsTable($kinmu_toroku_id, $time);
        }
        
        // 元の画面に戻る
        return back();
    }
    
    /* ------------------------------------------------------------ *
     * $user_idで指定されたユーザーの$ymの勤務カレンダーを表示する
     * ------------------------------------------------------------ */
    public function viewKinmuCalender($user_id, $ym){
        
        // $ymがないときは今月
        if (is_null($ym) || $ym == ""){
            $ym = Carbon::today();
        }
        
        // yyyy-mm-dd hh:ii:ss の形にする
        $ym = new Carbon($ym);
        
        // 1か月分ループ
        $firstOfMonth = $ym->firstOfMonth();
        $endOfMonth = $firstOfMonth->copy()->endOfMonth();
        
        for ($i = 0; true; $i++) {
            
            $date = $firstOfMonth->copy()->addDays($i);
            if ($date > $endOfMonth) {
                break;
            }
            $ymd = $date->format('Y-m-d');
            
            // 勤務登録情報の取得
            $user = User::findOrFail($user_id);
                
            // 勤務登録（日付とか所定時間）の取得
            $kinmu_komoku = $user->getKinmuKomoku($ymd);
            $kinmu_toroku = $user->getKinmuToroku($ymd);
            // 簡易勤務登録-出勤の取得
            if (!is_null($kinmu_toroku) && $kinmu_toroku->checkInsertKanniKinmuTorokuStartsTable()){
                $kanni_kinmu_start = $kinmu_toroku->kanni_kinmu_toroku_start;
            }
            else {
                $kanni_kinmu_start = NULL;
            }
            // 簡易勤務登録-退勤の取得
            if (!is_null($kinmu_toroku) && $kinmu_toroku->checkInsertKanniKinmuTorokuEndsTable()){
                $kanni_kinmu_end = $kinmu_toroku->kanni_kinmu_toroku_end;
            }
            else {
                $kanni_kinmu_end = NULL;
            }
            
            // 日付加工
            Carbon::setLocale('ja');
            $date = new Carbon($ymd);
            $d = $date->day;
            $dayofweek = $date->isoFormat('(ddd)');
            if ($date->isWeekend()){
                $day_kubun = 1;
            }
            else {
                $day_kubun = 2;
            }
            
            
            $kinmus[] = [
                'd' => $d,
                'dayofweek' => $dayofweek,
                'day_kubun' => $day_kubun,
                'kinmu_komoku' => $kinmu_komoku,
                'kanni_kinmu_start' => $kanni_kinmu_start,
                'kanni_kinmu_end' => $kanni_kinmu_end,
            ];
        }
        
        // 詳細勤務入力ページを表示する
        return view('employments.kinmu_calender', [
            'kinmus' => $kinmus, 
            'ym' => $ym->format('Y年 m月'), 
            'ym_bk' => $ym->copy()->subMonth()->format('Y-m'), 
            'ym_nxt' => $ym->copy()->addMonth()->format('Y-m')
        ]);
    }
    
    
    /* --------------------------------------------- *
     * 詳細勤務入力画面を表示する
     * --------------------------------------------- */
    public function viewSyosaiKinmuInput($user_id, $ymd){
        
        // 認証済のとき
        if (Auth::check()){
            
            $user = User::find($user_id);
            
            // 日付の取得とフォーマット
            Carbon::setLocale('ja');
            $ymd = new Carbon($ymd);
            $ymd_fmt = $ymd->format('Y年m月d日');
            $dayofweek = $ymd->isoFormat('（ddd）');
            
            // 勤務内容
            $kinmu_komokus = Kinmu_komoku::orderBy('id', 'asc')->get();
            
            // 勤務登録
            $kinmu_toroku = $user->getKinmuToroku($ymd->format('Y-m-d'));
            
            // 簡易勤務登録と時間外登録
            if (!is_null($kinmu_toroku)){
                $kanni_kinmu_start = $kinmu_toroku->kanni_kinmu_toroku_start;
                $kanni_kinmu_end = $kinmu_toroku->kanni_kinmu_toroku_end;
                $jikangai_toroku = $kinmu_toroku->jikangai_toroku;
            }
            else {
                $kanni_kinmu_start = NULL;
                $kanni_kinmu_end = NULL;
                $jikangai_toroku = NULL;
            }
            
            
            
        //     // その日の日付の勤務登録、簡易勤務登録-出勤、簡易勤務登録-退勤情報を取得する
        //     Carbon::setLocale('ja');
        //     $ymd = Carbon::today();
        //     $ymd_fmt = $ymd->format('Y/m/d');
        //     $dayofweek = $ymd->isoFormat('(ddd)');
        //     $ymd = $ymd->format('Y-m-d');
            
        //     // 初期化
        //     $kanni_kinmu_start['check'] = false;
        //     $kanni_kinmu_end['check'] = false;
            
        //     // TODO 退勤の後に出勤を押させない制御が必要
            
        //     // 簡易勤務登録-出勤
        //     // 済のときはtrue
        //     // checkInsertKinmuTorokusTable($ymd)はkinmu_torokus()->where('ymd', $ymd)->exists()だからうまくまとめたい
        //     if (Auth::user()->checkInsertKinmuTorokusTable($ymd)){
        //         // 済のときはtrue
        //         $kanni_kinmu_start['check'] = Auth::user()->getKinmuToroku($ymd)->checkInsertKanniKinmuTorokuStartsTable();
        //         if ($kanni_kinmu_start['check']){
        //             $kanni_kinmu_start['ymd'] = $ymd_fmt;
        //             $kanni_kinmu_start['dayofweek'] = $dayofweek;
        //             $kanni_kinmu_start['time'] = Auth::user()->getKinmuToroku($ymd)->kanni_kinmu_toroku_start->kanni_kinmu_start_time;
        //         }
        //     }
            
        //     // 簡易勤務登録-退勤
        //     // 済のときはtrue
        //     // checkInsertKinmuTorokusTable($ymd)はkinmu_torokus()->where('ymd', $ymd)->exists()だからうまくまとめたい
        //     if (Auth::user()->checkInsertKinmuTorokusTable($ymd)){
        //         // 済のときはtrue
        //         $kanni_kinmu_end['check'] = Auth::user()->getKinmuToroku($ymd)->checkInsertKanniKinmuTorokuEndsTable();
        //         if ($kanni_kinmu_end['check']){
        //             $kanni_kinmu_end['ymd'] = $ymd_fmt;
        //             $kanni_kinmu_end['dayofweek'] = $dayofweek;
        //             $kanni_kinmu_end['time'] = Auth::user()->getKinmuToroku($ymd)->kanni_kinmu_toroku_end->kanni_kinmu_end_time;
        //         }
        //     }
        }
            
        // 詳細勤務入力ページを表示する
        // return view('employments.syosai_kinmu', [
        //     // 勤務項目から通常勤務を取得
        //     'kinmu_komoku' => Kinmu_komoku::findOrFail(1),
        //     'kanni_kinmu_start' => $kanni_kinmu_start,
        //     'kanni_kinmu_end' => $kanni_kinmu_end,
        // ]);
        return view('employments.syosai_kinmu', [
            'ymd_fmt' => $ymd_fmt,
            'dayofweek' => $dayofweek,
            'kinmu_komokus' => $kinmu_komokus,
            'kinmu_toroku' => $kinmu_toroku,
            'kanni_kinmu_start' => $kanni_kinmu_start,
            'kanni_kinmu_end' => $kanni_kinmu_end,
            'jikangai_toroku' => $jikangai_toroku,
        ]);
        
    }
}
