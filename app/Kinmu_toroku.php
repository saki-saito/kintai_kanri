<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

use App\User;
use App\Kanni_kinmu_toroku_start;

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
            
            // createで書けない？？？？？
            // それかhasonethroughでUserモデルに処理書きたい
            
            // // 簡易勤務登録 - 出勤登録を行う
            // $this->kanni_kinmu_toroku_start()->create([
            //     'kinmu_toroku_id' => $kinmu_toroku_id, 
            //     'kanni_kinmu_start_time' => $time,
            // ]);  // エラーになる
            
            // 簡易勤務登録 - 出勤登録を行う
            $obj = new Kanni_kinmu_toroku_start;
            $obj->kinmu_toroku_id = $kinmu_toroku_id;
            $obj->kanni_kinmu_start_time = $time;
            $obj->save();   // できる
            
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
    
    // /* ------------------------------------------------------------------- *
    //  * この勤務登録に簡易勤務登録 - 出勤登録が紐づいているか調べる
    //  * 
    //  * @return  bool    勤務登録済：true
    //  *                  勤務登録まだ：false
    //  * ------------------------------------------------------------------- */
    // public function checkInsertKanniKinmuTorokuStartsTable(){
        
    //     return $this->kanni_kinmu_toroku_start()->exists();
    // }
    
    
    
    // debug
    public function hello(){
        return 'Hello, world.';
    }
}
