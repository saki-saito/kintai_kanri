<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kanni_kinmu_toroku_end extends Model
{
     protected $fillable = [
        'kinmu_toroku_id', 
        'kanni_kinmu_end_time', 
    ];
    
    protected $table = 'kanni_kinmu_toroku_ends';
    
    /* ----------------------------------------------------------- *
     * 一対一
     * ----------------------------------------------------------- *
     * この簡易勤務登録 - 退勤が紐づいている勤務登録
     * ----------------------------------------------------------- */
    public function kinmu_toroku(){
        return $this->belongsTo(kinmu_toroku::class);
    }
}
