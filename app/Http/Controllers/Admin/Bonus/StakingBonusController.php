<?php

namespace App\Http\Controllers\Admin\Bonus;

use App\Models\AthUser;
use App\Models\AthStaking;
use App\Models\AthStakingAff;
use App\Models\Bonus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StakingBonusController extends Controller
{
    public function __construct()
    {
        
    }
    public function list(Request $request)
    {
        $list = DB::table('ath_staking_test')
        ->join('users', 'ath_staking_test.user_id', '=', 'users.id')
        ->select('ath_staking_test.*', 'users.name', 'users.id as user_id')
        ->when(request('category') != '', function ($query) {
            if(request('category') == 'mid'){
                $query->where('users.id', request('keyword'));
            } else {
                $query->where('users.account', request('keyword'));
            }
        })
        ->when(request('start_date'), function ($query) {
            $start_date = Carbon::parse(request('start_date'))->startOfDay();
            $query->where('ath_staking_test.created_at', '>=', $start_date);
        })
        ->when(request('end_date'), function ($query) {
            $end_date = Carbon::parse(request('end_date'))->endOfDay();
            $query->where('ath_staking_test.created_at', '<=', $end_date);
        })
        ->orderBy('ath_staking_test.created_at', 'desc')
        ->paginate(10); 


        return view('admin.bonus.staking-list', compact('list'));
    }
/*
    public function list(Request $request)
    {
        $list = DB::table('ath_staking_aff')
        ->join('ath_staking', 'ath_staking.id', '=', 'ath_staking_aff.staking_id')
        ->join('ath_user', 'ath_staking.user_id', '=', 'ath_user.user_id')
        ->join('users', 'ath_staking_aff.user_id', '=', 'users.id')
        ->leftJoin('ath_user as aff_ath_user', 'ath_staking_aff.aff_user_id', '=', 'aff_ath_user.user_id')
        ->leftJoin('users as aff_users', 'ath_staking_aff.aff_user_id', '=', 'aff_users.id')
        ->select('ath_staking_aff.*', 
                'ath_staking.usdt',
                'users.name as user_name',
                'aff_users.id as aff_user_id',
                'aff_users.name as aff_user_name',
                'aff_ath_user.meta_uid as aff_user_meta_uid',
                'aff_ath_user.memo as aff_user_memo')
        ->when(request('start_date'), function ($query) {
            $start_date = Carbon::parse(request('start_date'))->startOfDay();
            $query->where('ath_staking_aff.created_at', '>=', $start_date);
        })
        ->when(request('end_date'), function ($query) {
            $end_date = Carbon::parse(request('end_date'))->endOfDay();
            $query->where('ath_staking_aff.created_at', '<=', $end_date);
        })
        ->orderBy('ath_staking_aff.created_at', 'desc')
        ->paginate(10); 

        return view('admin.bonus.staking-list', compact('list'));
    }
*/
    public function view($id)
    {
        
        $view = DB::table('ath_staking')
        ->join('users', 'ath_staking.user_id', '=', 'users.id')
        ->join('ath_user', 'ath_staking.user_id', '=', 'ath_user.user_id')
        ->select('ath_staking.*', 'users.email', 'users.name', 'ath_user.phone')
        ->where('ath_staking.id', '=', $id)
        ->first();
        
        if (!$view) {
            abort(404, '404 not found');
        }

        $view->image_urls = json_decode($view->image_urls, true);

        return view('admin.package.staking-view', compact('view'));
    }
}
