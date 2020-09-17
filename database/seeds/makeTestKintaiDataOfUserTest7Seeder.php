<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
use App\User;

class makeTestKintaiDataOfUserTest7Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ym = new Carbon('2020-08');
        
        // 1か月分ループ
        $firstOfMonth = $ym->firstOfMonth();
        $endOfMonth = $firstOfMonth->copy()->endOfMonth();
        
        for ($i = 0; true; $i++) {
            
            $date = $firstOfMonth->copy()->addDays($i);
            if ($date > $endOfMonth) {
                break;
            }

            $ymd = $date->format('Y-m-d');
            
            DB::table('kinmu_torokus')->insert([
                'user_id' => 9,
                'kinmu_komoku_id' => 1,
                'ymd' => $ymd,
            ]);
            
            $kinmu_toroku_id = User::find(9)->getKinmuToroku($ymd)->id;
            DB::table('kanni_kinmu_toroku_starts')->insert([
                'kinmu_toroku_id' => $kinmu_toroku_id,
                'kanni_kinmu_start_time' => '09:05:00',
            ]);
            
            DB::table('kanni_kinmu_toroku_ends')->insert([
                'kinmu_toroku_id' => $kinmu_toroku_id,
                'kanni_kinmu_end_time' => '17:05:00',
            ]);
            
            
        }
        
    }
}
