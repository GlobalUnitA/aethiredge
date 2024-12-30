<?php

namespace App\Http\Controllers\Profile;


use App\Models\AthUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function __construct()
    {
   
    }
    
    public function index()
    {
        $view = AthUser::join('users', 'ath_user.user_id', '=', 'users.id')
        ->select('ath_user.*', 'users.name')
        ->where('ath_user.user_id', '=', Auth::id())
        ->first();


        return view('profile.profile', compact('view'));   
    }

    public function update(Request $request)
    {
        $validated = $this->validator($request->all())->validate();
        $ath_user = AthUser::where('user_id', $request->id)->first();

        if ($ath_user) {

            DB::beginTransaction();

            try {

                $ath_user->update([
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'meta_uid' =>$request->meta_uid,
                    'pcc' => $request->pcc,
                    'post_code' => $request->post_code,
                    'address' => $request->address,
                    'detail_address' => $request->detail_address
                ]);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => '수정되었습니다.',
                    'url' => route('home'),
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

    public function password()
    {
        $view = AthUser::join('users', 'ath_user.user_id', '=', 'users.id')
        ->select('ath_user.*', 'users.name', 'users.account')
        ->where('ath_user.user_id', '=', Auth::id())
        ->first();

        return view('profile.password', compact('view'));  
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).+$/', 'confirmed'],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => '현재 비밀번호가 일치하지 않습니다.',
            ]);
        }

        
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
                    'status' => 'success',
                    'message' => '비밀번호가 변경되었습니다.',
                    'url' => route('profile'),
                ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'min:9', 'max:12'],
            'metaUid' => ['nullable', 'string'],
            'pcc' => ['nullable', 'string', 'min:10'],
            'postcode' => ['nullable', 'string', '10'],
            'address' => ['nullable', 'string'], 
            'detailAddress' => ['nullable', 'string'],
        ]);
    }
}