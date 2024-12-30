<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

class ResetPasswordController extends Controller
{

    public function index(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'account' => $request->account]
        );
    }

 
    public function reset(Request $request)
    {
   
        $this->validate($request, [
            'account' => 'required',
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).+$/', 'confirmed'],
            'token' => 'required',
        ]);

        $reset = DB::table('password_resets')
        ->where('account', $request->account)
        ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return response()->json([
                'status' => 'error',
                'message' => '토큰이 유효하지 않거나 만료되었습니다.',
            ]);
        }
        $user = User::where('account', $request->account)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => '해당 계정을 가진 사용자를 찾을 수 없습니다.',
            ]);
        }
    
        $user->password = Hash::make($request->password);
        $user->save();
    
        DB::table('password_resets')->where('account', $request->account)->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => '비밀번호가 성공적으로 변경되었습니다.',
        ]);
    }
}
