<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AthDevice;
use App\Models\AthDeviceAff;
use App\Models\AthStaking;
use App\Models\Bonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{

    public function __construct()
    {

    }


    public function index()
    {
        /*
        $deviceData = [
            ['id' => 1, 'date' => '2024-10-04'],
            ['id' => 2, 'date' => '2024-10-04'],
            ['id' => 3, 'date' => '2024-10-04'],
            ['id' => 4, 'date' => '2024-10-05'],
            ['id' => 5, 'date' => '2024-10-05'],
            ['id' => 6, 'date' => '2024-10-08'],
            ['id' => 7, 'date' => '2024-10-09'],
            ['id' => 8, 'date' => '2024-10-11'],
            ['id' => 9, 'date' => '2024-10-11'],
            ['id' => 10, 'date' => '2024-10-12'],
            ['id' => 11, 'date' => '2024-10-12'],
            ['id' => 12, 'date' => '2024-10-12'],
            ['id' => 13, 'date' => '2024-10-12'],
            ['id' => 14, 'date' => '2024-10-23'],
            ['id' => 15, 'date' => '2024-10-29'],
            ['id' => 16, 'date' => '2024-10-31'],
            ['id' => 17, 'date' => '2024-10-31'],
            ['id' => 18, 'date' => '2024-11-02'],
            ['id' => 19, 'date' => '2024-11-05'],
            ['id' => 20, 'date' => '2024-11-12'],
            ['id' => 21, 'date' => '2024-11-12'],
            ['id' => 22, 'date' => '2024-11-20'],
            ['id' => 23, 'date' => '2024-11-26'],
            ['id' => 24, 'date' => '2024-11-26'],
            ['id' => 25, 'date' => '2024-11-26'],
            ['id' => 26, 'date' => '2024-11-29'],
            ['id' => 27, 'date' => '2024-12-05'],
            ['id' => 28, 'date' => '2024-12-09'],
            ['id' => 29, 'date' => '2024-12-09'],
            ['id' => 30, 'date' => '2024-12-13'],
            ['id' => 31, 'date' => '2024-12-09'],
            ['id' => 32, 'date' => '2024-12-09']
        ];

        foreach($deviceData as $val){
            $device = AthDevice::find($val['id']);

            if ($device) {
                $device->created_at = $val['date'];
                $device->updated_at = $val['date'];
                $device->save();
            }


            $bonus = AthDeviceAff::where('device_id', $val['id'])->get();

            foreach ($bonus as $bonusItem) {
                $bonusItem->created_at = $val['date'];
                $bonusItem->updated_at = $val['date'];
                $bonusItem->save();
            }
        }

        $stakingData = [
            ['id' => 1, 'date' => '2024-11-02'],
            ['id' => 2, 'date' => '2024-11-02'],
            ['id' => 3, 'date' => '2024-11-20'],
            ['id' => 4, 'date' => '2024-12-03']
        ];

        foreach($stakingData as $val){
            $staking = AthStaking::find($val['id']);

            if ($staking) {
                $staking->created_at = $val['date'];
                $staking->updated_at = $val['date'];
                $staking->save();
            }
        }
        */


        $users = User::all();

        foreach ($users as $user) {
            $user->password = Hash::make('test1004@');
            $user->save();

        }
    }

    //test 주석 작성.
}
