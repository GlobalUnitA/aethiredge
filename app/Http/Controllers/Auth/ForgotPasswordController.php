<?php 

namespace App\Http\Controllers\Auth;

use App\Mail\PasswordResetMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{


    public function index()
    {
        return view('auth.passwords.email');
    }

    
    public function sendResetLinkEmail(Request $request)
    {
        $user = User::where('account', $request->input('account'))->first();
    
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => '해당 아이디를 찾을 수 없습니다.',
            ]);
        }

        $token = Str::random(64);
        DB::table('password_resets')->updateOrInsert(
            ['account' => $user->account],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );
    
        
        $resetUrl = url(route('password.reset', [
            'token' => $token,
            'account' => $user->account,
        ], false));
    
        try {
            Mail::to($request->input('email'))->send(new PasswordResetMail($resetUrl, $token));
        } catch (\Exception $e) {
            \Log::error('비밀번호 재설정 링크 전송 실패: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => '현재 비밀번호 재설정 서비스를 이용할 수 없습니다. 잠시 후 다시 시도해주세요.',
            ]);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => '비밀번호 재설정 링크가 이메일로 전송되었습니다.',
        ]);
    }
}