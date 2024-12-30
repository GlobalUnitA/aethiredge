<?php 

namespace App\Models;

use App\Models\AthDeviceAff;
use App\Models\AthDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Bonus
{

    public static function calculateBonus($user, $usdt) {
      
        $current_user = $user->parent;
        
        if(!$current_user){
            return false;
        }

        $return_arr = [];
    
        while ($current_user !== null && $current_user->level >= 0) {
        
            $step = $user->level - $current_user->level;

            $part_usdt = ($current_user->part_usdt >= 2000) ? 2000 : $current_user->part_usdt;
            $part_usdt = $part_usdt == 1300 ? 2000 : $part_usdt; 

            if($part_usdt == 200 ) {
                $percent = ((float) 2000 / 2000 ) * 100;        
            } else {
                $percent = ((float) $part_usdt / 2000 ) * 100;        
            }
            
            $is_ref = ($step == 1) ? 1 : 0;

            if($step == 1 && $usdt != 1300) {
                $bonus = ((($usdt * 15) / 100) * $percent) / 100;
            } else if(1 < $step && $step < 6 && $part_usdt != 200 && $usdt != 1300) {
                $bonus = ((($usdt * 10 / 4) / 100) * $percent) / 100;
            } else if(5 < $step && $step < 11 && $part_usdt != 200 && $usdt != 1300) {
                $bonus = ((($usdt * 5 / 5) / 100) * $percent) / 100;
            } else if(10 < $step && $step < 16 && $part_usdt != 200 && $usdt != 1300) {
                $bonus = ((($usdt * 3 / 5) / 100) * $percent) / 100;
            } else if(15 < $step && $step < 21 && $part_usdt != 200 && $usdt != 1300) {
                $bonus = ((($usdt * 2 / 5) / 100) * $percent) / 100;
            } else {
                $bonus = 0;
            }

            $return_arr[] = [
                'user_id' => $current_user->user_id,
                'is_ref' => $is_ref,
                'bonus' => $bonus,
                //part_usdt 주문 당시 유저의 참여 금액으로 하려면 => $part_usdt
                'part_usdt' => $current_user->part_usdt,
            ];

            $current_user = $current_user->parent;
            
        }

        return $return_arr;

    }

    public static function getDeviceBonus($user_id) {

        $start_Week = Carbon::now()->startOfWeek();
        $end_Week = Carbon::now()->endOfWeek();

        $ref_week = DB::table('ath_device_aff')
            ->select(DB::raw('sum(bonus) as bonus'))
            ->where('ath_device_aff.user_id', '=', $user_id)
            ->where('is_ref', '=', 1)
            ->whereBetween('created_at', [$start_Week, $end_Week])
            ->first();

        $ref_full = DB::table('ath_device_aff')
            ->select(DB::raw('sum(bonus) as bonus'))
            ->where('ath_device_aff.user_id', '=', $user_id)
            ->where('is_ref', '=', 1)
            ->first();

        $aff_week = DB::table('ath_device_aff')
            ->select(DB::raw('sum(bonus) as bonus'))
            ->where('ath_device_aff.user_id', '=', $user_id)
            ->where('is_ref', '=', 0)
            ->whereBetween('created_at', [$start_Week, $end_Week])
            ->first();

        $aff_full = DB::table('ath_device_aff')
            ->select(DB::raw('sum(bonus) as bonus'))
            ->where('ath_device_aff.user_id', '=', $user_id)
            ->where('is_ref', '=', 0)
            ->first();

        $bonus = [
            'week_ref' => $ref_week->bonus ?? 0,
            'full_ref' => $ref_full->bonus ?? 0,
            'week_aff' => $aff_week->bonus ?? 0,
            'full_aff' => $aff_full->bonus ?? 0,
        ];


        return $bonus;
    }

    public static function getStakingBonus($user_id) {

        $start_Week = Carbon::now()->startOfWeek();
        $end_Week = Carbon::now()->endOfWeek();

        $ref_bonus = DB::table('ath_staking_aff')
            ->select(DB::raw('sum(bonus) as ref'))
            ->where('ath_device_aff.user_id', '=', $user_id)
            ->where('is_ref', '=', 1)
            ->whereBetween('created_at', [$start_Week, $end_Week])
            ->first();

        $aff_bonus = DB::table('ath_staking_aff')
            ->select(DB::raw('sum(bonus) as aff'))
            ->where('ath_device_aff.user_id', '=', $user_id)
            ->where('is_ref', '=', 0)
            ->whereBetween('created_at', [$start_Week, $end_Week])
            ->first();

        $bonus = [
            'ref' => $ref_bonus->ref ?? 0,
            'aff' => $aff_bonus->aff ?? 0,
        ];

        return $bonus;
    }

    public static function renualBonus($user)
    {
        $start_Week = Carbon::now()->startOfWeek();
        $end_Week = Carbon::now()->endOfWeek();

        $rows = DB::table('ath_device_aff as aff')
        ->join('ath_device as dev', 'aff.device_id', '=', 'dev.id')
        ->select('aff.*', 'dev.usdt')
        ->where('aff.user_id', $user->user_id)
        ->whereBetween('aff.created_at', [$start_Week, $end_Week])
        ->get();
        

        $recent_usdt = $user->part_usdt;
        
        DB::beginTransaction();

        try {
            
            foreach($rows as $key => $val){
                

                $step = $val->aff_user_level - $user->level;
        
                $recent_usdt = ($recent_usdt >= 2000) ? 2000 : $recent_usdt;
                $recent_usdt = $recent_usdt == 1300 ? 2000 : $recent_usdt; 

                if($recent_usdt == 200 ) {
                    $percent = ((float) 2000 / 2000 ) * 100;        
                } else {
                    $percent = ((float) $recent_usdt / 2000 ) * 100;        
                }

                if($step == 1 && $val->usdt != 1300 ) {
                    $bonus = ((($val->usdt * 15) / 100) * $percent) / 100;
                } else if(1 < $step && $step < 6 && $recent_usdt != 200 && $val->usdt != 1300 ) {
                    $bonus = ((($val->usdt * 10 / 4) / 100) * $percent) / 100;
                } else if(5 < $step && $step < 11 && $recent_usdt != 200 && $val->usdt != 1300 ) {
                    $bonus = ((($val->usdt * 5 / 5) / 100) * $percent) / 100;
                } else if(10 < $step && $step < 16 && $recent_usdt != 200 && $val->usdt != 1300 ) {
                    $bonus = ((($val->usdt * 3 / 5) / 100) * $percent) / 100;
                } else if(15 < $step && $step < 21 && $recent_usdt != 200 && $val->usdt != 1300 ) {
                    $bonus = ((($val->usdt * 2 / 5) / 100) * $percent) / 100;
                } else {
                    $bonus = 0;
                }
            
            
               $record = AthDeviceAff::find($val->id);

               $record->bonus = $bonus;
               $record->part_usdt = $user->part_usdt;
               $record->save();
                
               Log::channel('bonus')->info('Bonus log', [
                    'id' => $val->id,
                    'usdt' => $record->part_usdt,
                    'bonus' => $record->bonus,
                    'device_usdt' => $val->usdt,
                    'timestamp' => now(),
                ]);
           
            }

            DB::commit(); 
        } catch (\Exception $e) {
          
            DB::rollBack();
            
            Log::channel('bonus')->error('Error updating bonuses: ' . $e->getMessage());
          
        }
    }
 
}   