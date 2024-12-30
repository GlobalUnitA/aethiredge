<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\AthUser;
use App\Models\AthStaking;
//use App\Models\AthStakingAff;
use App\Models\AthStakingTest;
use App\Models\Bonus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StakingController extends Controller
{
    public function __construct()
    {
        
    }
    

    public function list(Request $request)
    {
        $list = DB::table('ath_staking')
        ->join('users', 'ath_staking.user_id', '=', 'users.id')
        ->join('ath_user', 'ath_staking.user_id', '=', 'ath_user.user_id')
        ->select('ath_staking.*', 'users.account', 'users.name', 'ath_user.phone')
        ->when(request('category') != '', function ($query) {
            if(request('category') == 'mid'){
                $query->where('users.id', request('keyword'));
            } else {
                $query->where('users.account', request('keyword'));
            }
        })
        ->when(request('start_date'), function ($query) {
            $start_date = Carbon::parse(request('start_date'))->startOfDay();
            $query->where('ath_staking.created_at', '>=', $start_date);
        })
        ->when(request('end_date'), function ($query) {
            $end_date = Carbon::parse(request('end_date'))->endOfDay();
            $query->where('ath_stakng.created_at', '<=', $end_date);
        })
        ->orderBy('ath_staking.created_at', 'desc')
        ->paginate(10); 


        return view('admin.package.staking-list', compact('list'));
    }
    
    public function view($id)
    {
        
        $view = DB::table('ath_staking')
        ->join('users', 'ath_staking.user_id', '=', 'users.id')
        ->join('ath_user', 'ath_staking.user_id', '=', 'ath_user.user_id')
        ->select('ath_staking.*', 'users.account', 'users.name', 'ath_user.phone')
        ->where('ath_staking.id', '=', $id)
        ->first();

        if (!$view) {
            abort(404, '404 not found');
        }

        $bonus_list = AthStakingTest::where('staking_id', $id)->where('aff_user_id', '=', '0')
            ->get();

        $allowance_list = AthStakingTest::where('staking_id', $id)->where('aff_user_id', '!=', '0')
            ->get();
        
        if ($bonus_list->isNotEmpty()) {
            $view->bonus = $bonus_list;
        }

        if ($allowance_list->isNotEmpty()) {
            $view->allowance = $allowance_list;
        }

        $view->image_urls = json_decode($view->image_urls, true);

        return view('admin.package.staking-view', compact('view'));
    }
    public function status(Request $request)
    { 
        $staking = AthStaking::find($request->id);

        $staking->update([
            'status' => $request->status,
        ]);
        
        if($request->status == 'p'){
            return response()->json([
                'status' => 'success',
                'message' => '승인되었습니다.',
                'url' => route('admin.staking.list'),
            ]);
    
        } else {
            return response()->json([
                'status' => 'success',
                'message' => '취소되었습니다.',
                'url' => route('admin.staking.list'),
            ]);
    
        }
    }

    public function test(Request $request)
    {
       
        $user_id = $request->user_id;
        $staking_id = $request->staking_id;
        $aff_user_id = $request->input('aff_user_id');
        $dailies = $request->input('daily');
        $paids = $request->input('paid');
        $earns = $request->input('earn');
        $created_at = $request->input('created_at');
        
        $recordCount = count($dailies);

        for ($i = 0; $i < $recordCount; $i++) {
            AthStakingTest::create([
                'user_id' => $user_id,
                'staking_id' => $staking_id,
                'aff_user_id' => $aff_user_id[$i],
                'daily' => $dailies[$i],
                'paid' => $paids[$i],
                'earn' => $earns[$i],
                'created_at' => $created_at[$i],
                'updated_at' => $created_at[$i],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => '보너스 지급되었습니다.',
            'url' => route('admin.staking.list'),
        ]);
    }

    public function delete(Request $request)
    { 
      

        $stakingTest = AthStakingTest::find($request->id);
        $stakingTest->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => '삭제되었습니다.',
            'url' => url()->previous(),
        ]);
        
    }
   /*
    public function confirm(Request $request)
    {
        
        $device = AthDevice::find($request->id);
        if ($device) {

            $user = AthUser::with('parent')->where('user_id', $device->user_id)->first();
            
            $usdt = (float) $request->usdt;

            $bonusArr = Bonus::calculateBonus($user, $usdt);

            $device->update([
                'status' => 'p',
            ]);

            if($bonusArr) {
                try {
                    DB::beginTransaction();

                    foreach($bonusArr as $key => $val) {
                        AthDeviceAff::create([
                            'device_id' => $device->id,
                            'user_id' => $val['user_id'],
                            'aff_user_id' => $user->user_id,
                            'aff_user_level' => $user->level,
                            'is_ref' => $val['is_ref'],
                            'bonus' => $val['bonus'],
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
                    'status' => 'sucess',
                    'message' => '승인은 되었으나, 보너스 지급할 추천인이 없습니다.',
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
*/
    public function update(Request $request)
    {
        $staking = AthStaking::find($request->id);

        if ($staking) {

            DB::beginTransaction();

            try {
                $usdt = (float) $request->usdt;

                $staking->update([
                    'usdt' => $usdt,
                    'status' => $request->status ?? 'o',
                    'memo' => $request->memo,
                ]);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => '수정되었습니다.',
                    'url' => route('admin.staking.view', ['id' => $staking->id]),
                ]);

            } catch (\Exception $e) {
                DB::rollBack();

                \Log::error('Failed to update staking', ['error' => $e->getMessage()]);

                return response()->json([
                    'status' => 'error',
                    'message' => '예기치 못한 오류가 발생했습니다.',
                ]);
            }
        }
    }
}
