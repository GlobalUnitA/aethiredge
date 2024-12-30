<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\AthUser;
use App\Models\AthDevice;
use App\Models\AthDeviceAff;
use App\Models\Bonus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeviceController extends Controller
{
    public function __construct()
    {
        
    }
    

    public function list(Request $request)
    {
        
        $list = DB::table('ath_device')
        ->join('users', 'ath_device.user_id', '=', 'users.id')
        ->join('ath_user', 'ath_device.user_id', '=', 'ath_user.user_id')
        ->select('ath_device.*', 'users.account', 'users.name', 'ath_user.phone')
        ->when(request('category') != '', function ($query) {
            if(request('category') == 'mid'){
                $query->where('users.id', request('keyword'));
            } else {
                $query->where('users.account', request('keyword'));
            }
        })
        ->when(request('start_date'), function ($query) {
            $start_date = Carbon::parse(request('start_date'))->startOfDay();
            $query->where('ath_device.created_at', '>=', $start_date);
        })
        ->when(request('end_date'), function ($query) {
            $end_date = Carbon::parse(request('end_date'))->endOfDay();
            $query->where('ath_device.created_at', '<=', $end_date);
        })
        ->when(request('mode'), function ($query) {
            if(request('mode') == 'cancel') {
                $query->where('ath_device.status', 'c');
            } else {
                $query->whereIn('ath_device.status', ['o', 'p']);
            }
        })
        ->orderBy('ath_device.created_at', 'desc')
        ->paginate(10); 

        $list->appends(request()->all());

        return view('admin.package.device-list', compact('list'));
    }

    public function view($id)
    {
        
        $view = DB::table('ath_device')
        ->join('users', 'ath_device.user_id', '=', 'users.id')
        ->join('ath_user', 'ath_device.user_id', '=', 'ath_user.user_id')
        ->select('ath_device.*', 'users.account', 'users.name', 'ath_user.phone')
        ->where('ath_device.id', '=', $id)
        ->first();
        
        if (!$view) {
            abort(404, '404 not found');
        }

        $view->image_urls = json_decode($view->image_urls, true);

        return view('admin.package.device-view', compact('view'));
    }

    public function status(Request $request)
    {
        
        $device = AthDevice::find($request->id);


        if ($device) {

            $usdt = (float) $request->usdt;

            $device->update([
                'status' => $request->status,
                'usdt' => $usdt,
            ]);

            if($request->status == 'c') {
                return response()->json([
                    'status' => 'success',
                    'message' => '취소되었습니다.',
                    'url' => route('admin.device.list'),
                ]);
            }

            $user = AthUser::with('parent')->where('user_id', $device->user_id)->first();

           
            try {
                DB::beginTransaction();

                $user->part_usdt += $usdt;
                $user->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                \Log::error('Failed to update user', ['error' => $e->getMessage()]);

                return response()->json([
                    'status' => 'error',
                    'message' => '예기치 못한 오류가 발생했습니다.',
                ]);
            }
                        
            Bonus::renualBonus($user);
            $bonus_arr = Bonus::calculateBonus($user, $usdt);
    
            if($bonus_arr) {
                try {
                    DB::beginTransaction();
   
                    foreach($bonus_arr as $key => $val) {
                        AthDeviceAff::create([
                            'device_id' => $device->id,
                            'user_id' => $val['user_id'],
                            'aff_user_id' => $user->user_id,
                            'aff_user_level' => $user->level,
                            'is_ref' => $val['is_ref'],
                            'bonus' => $val['bonus'],
                            'part_usdt' => $val['part_usdt'],
                        ]);
                    }
                    
                    DB::commit();
    
                    return response()->json([
                        'status' => 'success',
                        'message' => '승인되었습니다.',
                        'url' => route('admin.device.list'),
                    ]);
    
                } catch (\Exception $e) {
                    DB::rollBack();
    
                    \Log::error('Failed to update device', ['error' => $e->getMessage()]);
    
                    return response()->json([
                        'status' => 'error',
                        'message' => '예기치 못한 오류가 발생했습니다.',
                    ]);
                }
            } else {

                return response()->json([
                    'status' => 'success',
                    'message' => '승인되었습니다.',
                    'url' => route('admin.device.list'),
                ]);
            }
            
        } else {
            return response()->json([
                'status' => 'error',
                'message' => '존재하지 않는 주문 건입니다.',
            ]);
        }
    }

    public function update(Request $request)
    {
        $device = AthDevice::find($request->id);

        if ($device) {

            DB::beginTransaction();

            try {
                $usdt = (float) $request->usdt;

                $device->update([
                    'usdt' => $usdt,
                    'status' => $request->status ?? 'o',
                    'memo' => $request->memo,
                ]);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => '수정되었습니다.',
                    'url' => route('admin.device.view', ['id' => $device->id]),
                ]);

            } catch (\Exception $e) {
                DB::rollBack();

                \Log::error('Failed to update device', ['error' => $e->getMessage()]);

                return response()->json([
                    'status' => 'error',
                    'message' => '예기치 못한 오류가 발생했습니다.',
                ]);
            }
        }
    }
}
