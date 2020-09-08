<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kinmu_toroku extends Model
{
    protected $fillable = [
        'user_id', 'kinmu_komoku_id', 'ymd'
    ];
    
    /* ----------------------------------------------------------- *
     * 一対多
     * ----------------------------------------------------------- *
     * この勤務登録を登録したユーザー
     * ----------------------------------------------------------- */
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    /* ----------------------------------------------------------- *
     * 一対多
     * ----------------------------------------------------------- *
     * この勤務登録に登録されている勤務項目
     * ----------------------------------------------------------- */
    public function kinmu_komoku(){
        return $this->belongsTo(Kinmu_komoku::class);
    }
}
