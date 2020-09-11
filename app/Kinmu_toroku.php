<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

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
        return $this->hasOne(kanni_kinmu_toroku_start::class);
    }
    
    // debug
    public function hello(){
        return 'Hello, world.';
    }
}
