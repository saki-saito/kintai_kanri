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
    
     /* ----------------------------------------------------------- *
     * このユーザーの簡易勤務登録 - 出勤
     * ----------------------------------------------------------- */
    public function kanni_kinmu_toroku_starts(){
        
        /* ---------------------------------------------------- *
         * hasManyThrough(, )：～経由の一対多
         * 第一引数：最終的にアクセスしたいモデル名
         * 第二引数：第２引数は仲介するモデル名
         * ---------------------------------------------------- */
        return $this->hasManyThrough(Kanni_kinmu_toroku_start::class, Kinmu_toroku::class, 'user_id', 'kinmu_toroku_id', 'id', 'id');
        // return $this->hasManyThrough(Kanni_kinmu_toroku_start::class, Kinmu_toroku::class);
    }
    
    
    /* ---------------------------------------------------- *
     * 勤務登録する
     * 
     * @param   $kinmu_komoku_id    登録する勤務項目のid
     *          $ymd                登録する日付
     * 
     * @return  bool    true：勤務登録した
     *                  false：勤務登録していない
     * ---------------------------------------------------- */
    public function insertKinmuTorokusTable($kinmu_komoku_id, $ymd){
        
        // 勤務登録できるかの確認
        $check = $this->checkInsertKinmuTorokusTable($ymd);
        
        // 勤務登録できる
        if ($check){
            // 勤務登録を行う
            $this->kinmu_torokus()->attach($kinmu_komoku_id, ['ymd' => $ymd]);
            return true;
        }
        // 勤務登録できない
        else {
            return false;
        }
    }
    
    /* ------------------------------------------------------------------- *
     * このユーザーが$ymdの日に勤務登録できるか調べる
     * 
     * @return  bool    勤務登録できる：true
     *                  勤務登録できない：false
     * ------------------------------------------------------------------- */
    public function checkInsertKinmuTorokusTable($ymd){
        
        if ($ymd == '' || is_null($ymd)){
            // その日の日付
            $ymd = Carbon::today()->format('Y-m-d');
        }
        
        return !($this->kinmu_torokus()->where('ymd', $ymd)->exists());
    }
    
    /* ---------------------------------------------------- *
     * 簡易勤務登録 - 出勤する
     * 
     * @param   $kinmu_toroku_id    簡易勤務登録 - 出勤を紐づける勤務登録のid
     * 
     * @return  bool
     * ---------------------------------------------------- */
    public function insertKanniKinmuTorokuStartsTable($kinmu_toroku_id, $time){
        
        // 簡易勤務登録 - 出勤できるかの確認
        $check = $this->checkInsertKanniKinmuTorokuStartsTable($kinmu_toroku_id);
        
        // 簡易勤務登録 - 出勤できる
        if ($check){
            
            // createで書けない？？？？？
            /* ************************************************************************** *
             * // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
             * $request->user()->microposts()->create([
             *     'content' => $request->content,
             * ]);
             * みたいにかきたい
             * ************************************************************************* */
            /* ****************************************************** *
            // 簡易勤務登録 - 出勤登録を行う
            $this->kanni_kinmu_toroku_starts()->create([
                'kinmu_toroku_id' => $kinmu_toroku_id, 
                'kanni_kinmu_start_time' => $time,
            ]);
             * ****************************************************** */
            // App\User::find(1)->kinmu_toroku_relations()->where('id',2 )->get()[0];
            
            // 簡易勤務登録 - 出勤登録を行う
            $obj = new Kanni_kinmu_toroku_start;
            $obj->kinmu_toroku_id = $kinmu_toroku_id;
            $obj->kanni_kinmu_start_time = $time;
            $obj->save();   // エラーでた
            
            return true;
        }
        // 簡易勤務登録 - 出勤できない
        else {
            return false;
        }
    }
    
    /* ------------------------------------------------------------------- *
     * このユーザーが簡易勤務登録 - 出勤できるか調べる
     * 
     * @return  bool    勤務登録できる：true
     *                  勤務登録できない：false
     * ------------------------------------------------------------------- */
    public function checkInsertKanniKinmuTorokuStartsTable($kinmu_toroku_id){
        
        return !($this->kanni_kinmu_toroku_starts()->where('kinmu_toroku_id', $kinmu_toroku_id)->exists());
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
    
}
