<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Carbon\Carbon;
use App\Kanni_kinmu_toroku_start;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    protected $table = 'users';
    
    /* ----------------------------------------------------------- *
     * 多対多
    /* ----------------------------------------------------------- *
     * このユーザーの勤務登録（勤務項目との紐づけ）
     * ----------------------------------------------------------- */
    public function kinmu_torokus(){
        /* --------------------------------------------------------------------------------------------- *
         * belongsToMany()
         * 第一引数：相手先モデル
         * 第二引数：結合テーブル（中間テーブル）
         * 第三引数：指定した相手先モデルが参照に利用しているこっちのカラム名
         * 第四引数：指定した相手先モデル側がこの関数へ参照を持つために利用しているあっちのカラム名
         * --------------------------------------------------------------------------------------------- */
        return $this->belongsToMany(Kinmu_komoku::class, 'kinmu_torokus', 'user_id', 'kinmu_komoku_id')->withTimestamps()->using('App\Kinmu_toroku')->withPivot(['id', 'ymd']);
        // App\User::find(1)->kinmu_torokus()->first()->pivot->id;
    }
    
    /* ----------------------------------------------------------- *
     * 一対多
    /* ----------------------------------------------------------- *
     * このユーザーの勤務登録（勤務登録テーブルとの関係）
     * ----------------------------------------------------------- */
    public function kinmu_toroku_relations(){
        return $this->hasMany(Kinmu_toroku::class);
    }
    
    //  /* ----------------------------------------------------------- *
    //  * このユーザーの簡易勤務登録 - 出勤
    //  * ----------------------------------------------------------- */
    // public function kanni_kinmu_toroku_start(){
        
    //     /* ---------------------------------------------------- *
    //      * hasOneThrough(, )：～経由の一対一
    //      * 第一引数：最終的にアクセスしたいモデル名
    //      * 第二引数：第２引数は仲介するモデル名
    //      * ---------------------------------------------------- */
    //     return $this->hasOneThrough(Kanni_kinmu_toroku_start::class, Kinmu_toroku::class, 'id', 'kinmu_toroku_id', 'id', 'id');
    //     // return $this->hasOneThrough(Kanni_kinmu_toroku_start::class, Kinmu_toroku::class);
    // }
    
    
    /* ---------------------------------------------------- *
     * 勤務登録する
     * 
     * @param   $kinmu_komoku_id    登録する勤務項目のid
     *          $ymd                登録する日付
     * 
     * @return  bool    true：勤務登録した
     *                  false：勤務登録していない（できなかった）
     * ---------------------------------------------------- */
    public function insertKinmuTorokusTable($kinmu_komoku_id, $ymd){
        
        // // 勤務登録できるかの確認
        // $check = $this->checkInsertKinmuTorokusTable($ymd);
        
        // // 勤務登録できる
        // if (!$check){
        //     // 勤務登録を行う
        //     $this->kinmu_torokus()->attach($kinmu_komoku_id, ['ymd' => $ymd]);
        //     return true;
        // }
        // // 勤務登録できない
        // else {
        //     return false;
        // }
        
        $this->kinmu_torokus()->attach($kinmu_komoku_id, ['ymd' => $ymd]);
    }
    
    /* ------------------------------------------------------------------- *
     * このユーザーが$ymdの日に勤務登録済か未か調べる
     * 
     * @return  bool    勤務登録済：true
     *                  勤務登録まだ：false
     * ------------------------------------------------------------------- */
    public function checkInsertKinmuTorokusTable($ymd){
        
        if ($ymd == '' || is_null($ymd)){
            // その日の日付
            $ymd = Carbon::today()->format('Y-m-d');
        }
        
        return $this->kinmu_torokus()->where('ymd', $ymd)->exists();
    }
    
    /* ---------------------------------------------------- *
     * このユーザーの$ymdの勤務登録を取得する
     * 
     * @param   $ymd    取得する日付
     * 
     * @return  object  勤務登録テーブルの該当のレコード
     *                  該当レコードがない場合はNULLを返す
     * ---------------------------------------------------- */
    public function getKinmuToroku($ymd){
        
        $obj = $this->kinmu_torokus()->where('ymd', $ymd);
        
        // $ymdの勤務登録があるとき
        if ($obj->count() == 1){
            // 勤務登録テーブルのレコードのみを返す
            return $obj->get()[0]->pivot;
        }
        else {
            return NULL;
        }
        
        
    }
    
    /* ---------------------------------------------------- *
     * このユーザーの$ymdの勤務項目を取得する
     * 
     * @param   $ymd    取得する日付
     * 
     * @return  object  勤務項目テーブルの該当のレコード
     *                  該当レコードがない場合はNULLを返す
     * ---------------------------------------------------- */
        public function getKinmuKomoku($ymd){
        
        $obj = $this->kinmu_torokus()->where('ymd', $ymd);
        
        // $ymdの勤務登録があるとき
        if ($obj->count() == 1){
            // 勤務登録テーブルのレコードのみを返す
            return $obj->get()[0];
        }
        else {
            return NULL;
        }
        
        
    }
    
}
