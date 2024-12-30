<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
 
    public function __construct()
    {
        
    }

   
    public function index()
    {
        $amount = $this->getDeviceCount(Auth::id());

        $notice = DB::table('ath_post')
            ->select('*')
            ->where('board_code', 'notice')
            ->orderBy('created_at', 'desc')
            ->first();

        $data = [
            'amount' => $amount,
            'notice' => $notice,
        ];
        
        return view('home', $data);
    }

    protected function getDeviceCount($user_id)
    {
        $result = DB::table('ath_device')
            ->select(DB::raw('sum(ea) as sum'))
            ->where('ath_device.user_id', '=', $user_id)
            ->where('ath_device.status', '=', 'p')
            ->first();

        $amount =  floor($result->sum * 10) / 10 ?? 0;
        
        return $amount;
    }
}
