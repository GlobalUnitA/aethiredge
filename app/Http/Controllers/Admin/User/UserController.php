<?php

namespace App\Http\Controllers\Admin\User;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AthUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        
    }
    

    public function list(Request $request)
    {
        $list = DB::table('users')
        ->join('ath_user', 'users.id', '=', 'ath_user.user_id')
        ->select('ath_user.*', 'users.name', 'users.account')
        ->when(request('keyword') != '', function ($query) {
            if(request('category') == 'mid'){
                $query->where('users.id', request('keyword'));
            } else {
                $query->where('users.account', request('keyword'));
            }
        })
        ->when(request('start_date'), function ($query) {
            $start_date = Carbon::parse(request('start_date'))->startOfDay();
            $query->where('users.created_at', '>=', $start_date);
        })
        ->when(request('end_date'), function ($query) {
            $end_date = Carbon::parse(request('end_date'))->endOfDay();
            $query->where('users.created_at', '<=', $end_date);
        })
    
        ->orderBy('users.created_at', 'desc')
        ->paginate(10);


        return view('admin.user.list', compact('list'));
    }

    public function view($id)
    {
   
        $view = DB::table('ath_user')
        ->join('users', 'ath_user.user_id', '=', 'users.id')
        ->select('ath_user.*', 'users.name', 'users.account')
        ->where('ath_user.id', '=', $id)
        ->first();
        
        if (!$view) {
            abort(404, '404 not found');
        }

        return view('admin.user.view', compact('view'));
    }

    public function update(Request $request)
    {
   
        $user = User::find($request->id);
        $ath_user = AthUser::where('user_id', $request->id)->first();

        if ($user) {

            DB::beginTransaction();

            try {

                $user->update([
                    'name' => $request->name,
                    'account' => $request->account,
                    'password' => $request->password ? Hash::make($request->password) : $user->password, 
                ]);

                $ath_user->update([
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'meta_uid' =>$request->meta_uid,
                    'pcc' => $request->pcc,
                    'post_code' => $request->post_code,
                    'address' => $request->address,
                    'detail_address' => $request->detail_address,
                    'memo' => $request->memo
                ]);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => '수정되었습니다.',
                    'url' => route('admin.user.view', ['id' => $ath_user->id]),
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

    public function export(Request $request)
    {

        return Excel::download(new UsersExport($request->all()), 'users.xlsx');

    }

}
