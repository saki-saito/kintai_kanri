<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kanni_kinmu_toroku extends Model
{
    protected $fillable = [
        'kinmu_toroku_id', 'kanni_kinmu_start_time', 'kanni_kinmu_end_time'
    ];
    
    /* ----------------------------------------------------------- *
     * 一対多
     * ----------------------------------------------------------- *
     * この簡易勤務登録が紐づいている勤務登録
     * ----------------------------------------------------------- */
    public function kinmu_toroku(){
        return $this->belongsTo(Kinmu_toroku::class);
    }
}
