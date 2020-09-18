<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

use App\User;
use App\Kinmu_toroku;
use App\Kanni_kinmu_toroku_start;
use App\Kanni_kinmu_toroku_end;
use App\Jikangai_toroku;

class Kinmu_toroku extends Pivot
{
    protected $fillable = [
        'user_id', 
        'kinmu_komoku_id', 
        'ymd'
    ];
    
    protected $table = 'kinmu_torokus';
    
    // /* ----------------------------------------------------------- *
    //  * 一対多
    //  * ----------------------------------------------------------- *
    //  * この勤務登録を登録したユーザー
    //  * ----------------------------------------------------------- */
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }
    
    // /* ----------------------------------------------------------- *
    //  * 一対多
    //  * ----------------------------------------------------------- *
    //  * この勤務登録に登録されている勤務項目
    //  * ----------------------------------------------------------- */
    // public function kinmu_komoku(){
    //     return $this->belongsTo(Kinmu_komoku::class);
    // }
    
    /* ----------------------------------------------------------- *
     * 一対一
     * ----------------------------------------------------------- *
     * この勤務登録に紐づいている簡易勤務登録 - 出勤
     * ----------------------------------------------------------- */
    public function kanni_kinmu_toroku_start(){
        return $this->hasOne(kanni_kinmu_toroku_start::class, 'kinmu_toroku_id');
    }
    
    /* ----------------------------------------------------------- *
     * 一対一
     * ----------------------------------------------------------- *
     * この勤務登録に紐づいている簡易勤務登録 - 退勤
     * ----------------------------------------------------------- */
    public function kanni_kinmu_toroku_end(){
        return $this->hasOne(kanni_kinmu_toroku_end::class, 'kinmu_toroku_id');
    }
    
    /* ----------------------------------------------------------- *
     * 一対一
     * ----------------------------------------------------------- *
     * この勤務登録に紐づいている時間外登録
     * ----------------------------------------------------------- */
    public function jikangai_toroku(){
        return $this->hasOne(jikangai_toroku::class, 'kinmu_toroku_id');
    }
    
    /* ---------------------------------------------------- *
     * この勤務登録に紐づく簡易勤務登録 - 出勤を登録する
     * 
     * @param   $kinmu_toroku_id    簡易勤務登録 - 出勤を紐づける勤務登録のid
     * 
     * @return  bool
     * ---------------------------------------------------- */
    public function insertKanniKinmuTorokuStartsTable($kinmu_toroku_id, $time){
        
        // 簡易勤務登録 - 出勤できるかの確認
        $check = $this->checkInsertKanniKinmuTorokuStartsTable();
        
        // 簡易勤務登録 - 出勤できる
        if (!$check){
            
            // 簡易勤務登録 - 出勤登録を行う
            Kinmu_toroku::find($kinmu_toroku_id)->kanni_kinmu_toroku_start()->create([
                'kinmu_toroku_id' => $kinmu_toroku_id, 
                'kanni_kinmu_start_time' => $time,
            ]);
            
            // saveでも書ける
            // $obj = new Kanni_kinmu_toroku_start;
            // $obj->kinmu_toroku_id = $kinmu_toroku_id;
            // $obj->kanni_kinmu_start_time = $time;
            // $obj->save();
            
            return true;
        }
        // 簡易勤務登録 - 出勤できない
        else {
            return false;
        }
    }
    
    /* ------------------------------------------------------------------- *
     * この勤務登録に簡易勤務登録 - 出勤登録が紐づいているか調べる
     * 
     * @return  bool    勤務登録済：true
     *                  勤務登録まだ：false
     * ------------------------------------------------------------------- */
    public function checkInsertKanniKinmuTorokuStartsTable(){
        
        return $this->kanni_kinmu_toroku_start()->exists();
    }
    
    /* ---------------------------------------------------- *
     * この勤務登録に紐づく簡易勤務登録 - 退勤を登録する
     * 
     * @param   $kinmu_toroku_id    簡易勤務登録 - 退勤を紐づける勤務登録のid
     * 
     * @return  bool    できた：true
     *                  できなかった：false
     * ---------------------------------------------------- */
    public function insertKanniKinmuTorokuEndsTable($kinmu_toroku_id, $time){
        
        // 簡易勤務登録 - 退勤できるかの確認
        $check = $this->checkInsertKanniKinmuTorokuEndsTable();
        
        // 簡易勤務登録 - 退勤できる
        if (!$check){
            
            // 簡易勤務登録 - 退勤登録を行う
            Kinmu_toroku::find($kinmu_toroku_id)->kanni_kinmu_toroku_end()->create([
                'kinmu_toroku_id' => $kinmu_toroku_id, 
                'kanni_kinmu_end_time' => $time,
            ]);
            
            return true;
        }
        // 簡易勤務登録 - 出勤できない
        else {
            return false;
        }
    }
    
    /* ------------------------------------------------------------------- *
     * この勤務登録に簡易勤務登録 - 退勤登録が紐づいているか調べる
     * 
     * @return  bool    勤務登録済：true
     *                  勤務登録まだ：false
     * ------------------------------------------------------------------- */
    public function checkInsertKanniKinmuTorokuEndsTable(){
        
        return $this->kanni_kinmu_toroku_end()->exists();
    }
    
    // /* ------------------------------------------------------------------- *
    //  * この勤務登録に紐づいている簡易勤務登録 - 出勤を取得する
    //  * 
    //  * @return  object  簡易勤務登録-出勤テーブルの該当のレコード
    //  *                  該当レコードがない場合はNULLを返す
    //  * ------------------------------------------------------------------- */
    // public function getKanniKinmuTorokuStart(){
    //     $this->kanni_kinmu_toroku_start;
    // }
    
    // // debug
    // public function hello(){
    //     return 'Hello, world.';
    // }
}
