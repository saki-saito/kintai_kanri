<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kanni_kinmu_toroku_start extends Model
{
    
    protected $fillable = [
        'kinmu_toroku_id', 
        'kanni_kinmu_start_time', 
    ];
    
    protected $table = 'kanni_kinmu_toroku_starts';
    
    /* ----------------------------------------------------------- *
     * 一対一
     * ----------------------------------------------------------- *
     * この簡易勤務登録 - 出勤が紐づいている勤務登録
     * ----------------------------------------------------------- */
    public function kinmu_toroku(){
        return $this->belongsTo(kinmu_toroku::class);
    }
    
    // /* ----------------------------------------------------------- *
    //  * 経由の一対多
    //  * ----------------------------------------------------------- *
    //  * この簡易勤務登録 - 出勤が紐づいているユーザー
    //  * ----------------------------------------------------------- */
    // public function user(){
    //     return $this->belongsTo(user::class);
    // }
}

// App\User::find(1)->kinmu_torokus()->where('kinmu_torokus.id', 2)->get()[0]->pivot->kanni_kinmu_toroku_start()->create(['kanni_kinmu_start_time' => '09:05:00'])->toSql();