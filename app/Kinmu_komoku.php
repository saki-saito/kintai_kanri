<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kinmu_komoku extends Model
{
    protected $fillable = [
        'kinmu_name', 
        'syotei_start_time', 
        'syotei_end_time', 
        'syotei_kyukei_start_time', 
        'syotei_kyukei_end_time',
    ];
    
    protected $table = 'kinmu_komokus';
    
    // /* ----------------------------------------------------------- *
    //  * 一対多
    //  * ----------------------------------------------------------- *
    //  * この勤務項目が登録されている勤務登録（なくてもいい？）
    //  * ----------------------------------------------------------- */
    // public function kinmu_torokus(){
    //     return $this->hasMany(Kinmu_toroku::class);
    // }
    
    /* ----------------------------------------------------------- *
     * この勤務項目が登録されている勤務登録
     * ----------------------------------------------------------- */
    public function kinmu_torokus(){
        /* --------------------------------------------------------------------------------------------- *
         * belongsToMany()
         * 第一引数：相手先モデル
         * 第二引数：結合テーブル（中間テーブル）
         * 第三引数：指定した相手先モデルが参照に利用しているこっちのカラム名
         * 第四引数：指定した相手先モデル側がこの関数へ参照を持つために利用しているあっちのカラム名
         * --------------------------------------------------------------------------------------------- */
        return $this->belongsToMany(User::class, 'kinmu_torokus', 'kinmu_komoku_id', 'user_id')->withTimestamps()->using('App\Kinmu_toroku')->withPivot('ymd');
    }
}
