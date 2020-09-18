<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Jikangai_toroku;

class Jikangai_toroku extends Model
{
    protected $fillable = [
        'kinmu_toroku_id', 
        'jikangai_start_time', 
        'jikangai_end_time', 
        'jikangai_riyu', 
        'jikangai_kyukei_start_time', 
        'jikangai_kyukei_end_time', 
    ];
    
    protected $table = 'jikangai_torokus';
    
    /* ----------------------------------------------------------- *
     * 一対一
     * ----------------------------------------------------------- *
     * この時間外登録が紐づいている勤務登録
     * ----------------------------------------------------------- */
    public function kinmu_toroku(){
        return $this->belongsTo(kinmu_toroku::class);
    }
}
