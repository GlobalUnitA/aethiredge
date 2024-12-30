<?php

namespace App\Http\Controllers\Admin\Bonus;

use App\Models\AthUser;
use App\Models\AthDevice;
use App\Models\AthDeviceAff;
use App\Models\Bonus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeviceBonusController extends Controller
{
    public function __construct()
    {
        
    }
    

    public function list(Request $request)
    {
        $list = DB::table('ath_device_aff')
        ->join('ath_device', 'ath_device.id', '=', 'ath_device_aff.device_id')
        ->join('ath_user', 'ath_device_aff.user_id', '=', 'ath_user.user_id')
        ->join('users', 'ath_device_aff.user_id', '=', 'users.id')
        ->leftJoin('ath_user as aff_ath_user', 'ath_device_aff.aff_user_id', '=', 'aff_ath_user.user_id')
        ->leftJoin('users as aff_users', 'ath_device_aff.aff_user_id', '=', 'aff_users.id')
        ->select('ath_device_aff.*', 
                'ath_device.usdt',
                'users.name as user_name',
                'ath_user.level as user_level',
                'ath_user.part_usdt as user_part_usdt',
                'ath_user.meta_uid as user_meta_uid',
                'ath_user.memo as user_memo',
                'aff_users.id as aff_user_id',
                'aff_users.name as aff_user_name',
                'aff_ath_user.level as aff_user_level')
        ->where('ath_device_aff.is_ref','=', 1)
        ->when(request('category') != '', function ($query) {
            if(request('category') == 'mid'){
                $query->where('users.id', request('keyword'));
            } else {
                $query->where('users.account', request('keyword'));
            }
        })
        ->when(request('start_date'), function ($query) {
            $start_date = Carbon::parse(request('start_date'))->startOfDay();
            $query->where('ath_device_aff.created_at', '>=', $start_date);
        })
        ->when(request('end_date'), function ($query) {
            $end_date = Carbon::parse(request('end_date'))->endOfDay();
            $query->where('ath_device_aff.created_at', '<=', $end_date);
        })
        ->orderBy('ath_device_aff.created_at', 'desc')
        ->paginate(10);

        foreach ($list as $key => $val) {
           
            $sub_list = DB::table('ath_device_aff')
                ->join('ath_user', 'ath_device_aff.user_id', '=', 'ath_user.user_id')
                ->join('users', 'ath_device_aff.user_id', '=', 'users.id')
                ->leftJoin('ath_user as aff_ath_user', 'ath_device_aff.aff_user_id', '=', 'aff_ath_user.user_id')
                ->leftJoin('users as aff_users', 'ath_device_aff.aff_user_id', '=', 'aff_users.id')
                ->select(
                    'ath_device_aff.*',
                    'users.name as user_name',
                    'ath_user.level as user_level',
                    'ath_user.part_usdt as user_part_usdt',
                    'ath_user.meta_uid as user_meta_uid',
                    'ath_user.memo as user_memo',
                    'aff_users.id as aff_user_id',
                    'aff_users.name as aff_user_name'
                )
                ->where('ath_device_aff.is_ref', '=', 0)
                ->where('ath_device_aff.device_id', '=', $val->device_id)
                ->get();
            
            if ($sub_list->isNotEmpty()) {
                $val->aff = $sub_list;
            }
        }
        
        return view('admin.bonus.device-list', compact('list'));
    }

    public function view($id)
    {
        
        $view = DB::table('ath_device')
        ->join('users', 'ath_device.user_id', '=', 'users.id')
        ->join('ath_user', 'ath_device.user_id', '=', 'ath_user.user_id')
        ->select('ath_device.*', 'users.email', 'users.name', 'ath_user.phone')
        ->where('ath_device.id', '=', $id)
        ->first();
        
        if (!$view) {
            abort(404, '404 not found');
        }

        $view->image_urls = json_decode($view->image_urls, true);

        return view('admin.package.device-view', compact('view'));
    }
}
