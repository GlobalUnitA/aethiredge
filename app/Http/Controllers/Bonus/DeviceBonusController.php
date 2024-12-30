<?php

namespace App\Http\Controllers\Bonus;

use App\Models\AthDeviceAff;
use App\Models\Bonus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceBonusController extends Controller
{
    public function __construct()
    {
        
    }
    
    public function index()
    {
        $bonus = Bonus::getDeviceBonus(auth()->id());


        return view('bonus.device.device', compact('bonus'));   
    }

    public function list($mode)
    {
        if($mode === 'ref'){
            $list = AthDeviceAff::where('user_id', auth()->id())->where('is_ref', 1)->paginate(10);
        } else {
            $list = AthDeviceAff::where('user_id', auth()->id())->where('is_ref', 0)->paginate(10);
        }
        
        return view('bonus.device.device-list', compact('list'));   
    }
    
}
