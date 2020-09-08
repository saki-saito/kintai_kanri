<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kinmu_komoku extends Model
{
    protected $fillable = [
        'kinmu_name', 'syotei_start_time', 'syotei_end_time', 'syotei_kyukei_start_time', 'syotei_kyukei_end_time'
    ];
    
    /* ----------------------------------------------------------- *
     * 一対多
     * ----------------------------------------------------------- *
     * この勤務項目が登録されている勤務登録（なくてもいい？）
     * ----------------------------------------------------------- */
    public function kinmu_torokus(){
        return $this->hasMany(Kinmu_toroku::class);
    }
}
